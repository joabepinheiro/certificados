<?php
namespace Application\Controller;

use Application\Service\Certificado;
use Application\Service\Mail;
use Application\Service\Participacao;
use Base\Controller\ActionController;
use Dompdf\Dompdf;
use Zend\Filter\Digits;
use Zend\Mvc\Controller\Plugin\FlashMessenger;
use Zend\Validator\Csrf;
use Zend\View\Model\JsonModel;
use DOMPDFModule\View\Model\PdfModel;
use Zend\View\Model\ViewModel;

class PublicController extends ActionController
{

    public function __construct()
    {}

    public function eventosDoParticipanteAction()
    {
        $cpf = (new Digits())->filter($this->params('cpf'));
        $data_nascimento = (new Digits())->filter($this->params('data_nascimento'));

        $eventos = $this->getEm()->getRepository('Application\Entity\Evento')
            ->getEventosDoParticipante($cpf, $data_nascimento);
        
        return new JsonModel($eventos);
    }

    /**
     * Força o download do certificado pelo navegador
     * o download so será feito se o csrf da requisisão for válido
     *
     * @return PdfModel|\Zend\Http\Response
     */
    public function baixarCertificadoAction()
    {
        $csrf_value = $this->params('csrf', 0);
        $csrf = new Csrf();
        
        if ($csrf->isValid($csrf_value)) {
            /** @var  $participacao \Application\Entity\Participacao */
            $participacao = $this->getEm()->getRepository('Application\Entity\Participacao')->find($this->params('participacao', 0));

            $modelo_array = (new Certificado($this->getEm()))->getModeloComTexto($participacao);


            if (is_null($modelo_array)) {
                $this->flashMessenger()
                    ->setNamespace(FlashMessenger::NAMESPACE_WARNING)
                    ->addMessage("Não há nenhum modelo de certificado compatível com esta participação: ".$participacao->getAtividade()->getTipoAtividade()." (Tipo de Atividade) / ".$participacao->getFuncao()." (Função)");
                
                return $this->redirect()->toRoute('emitir', array(
                    'action' => 'home'
                ));
            }

            return (new Certificado($this->getEm()))->gerarCertificado($modelo_array, $participacao);

            /**
             $nome_do_arquivo = 'certificado-' . $participacao->getChaveValidacao();
            
            $pdf = new PdfModel();
            
            $pdf->setOption('fileName', $nome_do_arquivo); // "pdf" extension is automatically appended
            $pdf->setOption('display', PdfModel::DISPLAY_ATTACHMENT); // Triggers browser to prompt "save as" dialog
            $pdf->setOption('paperSize', 'a4'); // Defaults to "8x11"
            $pdf->setOption('dpi', 200);
            $pdf->setOption('paperOrientation', 'landscape'); // Defaults to "portrait"

            // gera uma uri imagem do fundo do certificado
            $image = 'http://'.$_SERVER['SERVER_NAME'].'/assets/certificados/frente/' . $modelo->getId() . '.png';
            $type = pathinfo($image, PATHINFO_EXTENSION);
            $data = file_get_contents($image);
            $dataUri = 'data:image/' . $type . ';base64,' . base64_encode($data);
            
            $pdf->setVariable('fundo', $dataUri);
            $pdf->setVariable('modelo', $modelo);
            $pdf->setVariable('participacao', $participacao);
            
            return $pdf;
             ***/

        } else {
            $this->flashMessenger()
                ->setNamespace(FlashMessenger::NAMESPACE_WARNING)
                ->addMessage('Solicitação inválida. Informe seu cpf e data de nascimento novamente');
            
            return $this->redirect()->toRoute('emitir', array(
                'action' => 'home'
            ));
        }
    }

    public function downloadCadastrarParticipantePorPlanilhaAction()
    {
        $file = 'data/planilhas/cadastrar_participante_por_planilha.xlsx';
        $response = new \Zend\Http\Response\Stream();
        $response->setStream(fopen($file, 'r'));
        $response->setStatusCode(200);
        $response->setStreamName(basename($file));
        $headers = new \Zend\Http\Headers();
        $headers->addHeaders(array(
            'Content-Disposition' => 'attachment; filename="' . basename($file) . '"',
            'Content-Type' => 'application/octet-stream',
            'Content-Length' => filesize($file),
            'Expires' => '@0', // @0, because zf2 parses date as string to \DateTime() object
            'Cache-Control' => 'must-revalidate',
            'Pragma' => 'public'
        ));
        $response->setHeaders($headers);
        return $response;
    }

    public function downloadCadastrarAtividadesDoEventoPorPlanilhaAction()
    {
        $file = 'data/planilhas/cadastrar_atividades_do_evento_por_planilha.xlsx';
        $response = new \Zend\Http\Response\Stream();
        $response->setStream(fopen($file, 'r'));
        $response->setStatusCode(200);
        $response->setStreamName(basename($file));
        $headers = new \Zend\Http\Headers();
        $headers->addHeaders(array(
            'Content-Disposition' => 'attachment; filename="' . basename($file) . '"',
            'Content-Type' => 'application/octet-stream',
            'Content-Length' => filesize($file),
            'Expires' => '@0', // @0, because zf2 parses date as string to \DateTime() object
            'Cache-Control' => 'must-revalidate',
            'Pragma' => 'public'
        ));
        $response->setHeaders($headers);
        return $response;
    }

    public function enviarCertificadoAction(){

        if ((new Csrf())->isValid($this->params('csrf', 0))) {

            $service = new Certificado($this->getEm());

            /** @var  $participacao \Application\Entity\Participacao */
            $participacao  = $this->getEm()->getRepository('Application\Entity\Participacao')->find($this->params('id'));

            if (is_null($participacao)) {
                return new JsonModel(array(
                    'code'       => 404,
                    'message'    => 'A participação informada não existe'
                ));
            }

            $modelo = $service->getModeloComTexto($participacao);

            if (is_null($modelo))
            {
               return new JsonModel(array(
                   'code'       => 404,
                   'message'    => "Não há nenhum modelo de certificado compatível com esta participação: ".$participacao->getAtividade()->getTipoAtividade()." (Tipo de Atividade) / ".$participacao->getFuncao()." (Função)"
               ));
            }

            $arquivo = $service->getPdf($this->getServiceLocator()->get('ViewRenderer'),  $participacao, $modelo);

            //se o arquivo não foi gerado
            if ($arquivo ==  false) {
                return new JsonModel(array(
                    'code'       => 404,
                    'message'    => 'Não foi possível gerar o arquivo  '. $arquivo['name']
                ));
            }

            $envio = $service->enviarCertificadoPorEmail($participacao, $arquivo['name'], $arquivo['path']);
            if($envio  === true) {
                return new JsonModel(array(
                    'code'       => 200,
                    'message'    => 'Certificado enviado com sucesso'
                ));
            }else {
                return new JsonModel(array(
                    'code'       => 404,
                    'message'    => 'Um erro ocorreu ao enviar para  '. $participacao->getParticipante()->getEmail(). '('.$envio.')'
                ));
            }

        }else{
            return new JsonModel(array(
                'code'       => 401,
                'message'    => 'Você não tem autorização para gerar esse certificado'
            ));
        }
    }
}

