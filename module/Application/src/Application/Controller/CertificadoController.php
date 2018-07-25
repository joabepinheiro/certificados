<?php
namespace Application\Controller;

use Application\Entity\Participacao;
use Application\Entity\ParticipacaoRepository;
use Application\Service\Certificado;
use Base\Controller\ActionController;
use Zend\Debug\Debug;
use Zend\Mvc\Controller\Plugin\FlashMessenger;
use Zend\View\Model\ViewModel;
use Application\Form\ValidarCertificado;
use DOMPDFModule\View\Model\PdfModel;

class CertificadoController extends ActionController
{

    public function __construct()
    {
        $this->entity = 'Application\Entity\Certificado';
        $this->form = 'Application\Form\CertificadoForm';
        $this->formService = true;
        $this->service = 'Application\Service\Certificado';
        $this->controller = 'certificado';
        $this->route = 'certificado/default';
    }

    /**
     * Tele de visualização do certificado direto no navegador
     * 
     * @return ViewModel
     */
    public function previewAction()
    {
        /** @var  $participacao Participacao */
        $participacao = $this->getEm()
            ->getRepository('Application\Entity\Participacao')
            ->find($this->params('participacao', 0));

        $modelo_array = (new Certificado($this->getEm()))->getModeloComTexto($participacao);

        if (is_null($modelo_array)) {
            $this->flashMessenger()
                ->setNamespace(FlashMessenger::NAMESPACE_WARNING)
                ->addMessage("Não há nenhum modelo de certificado compatível com esta participação: ".$participacao->getAtividade()->getTipoAtividade()." (Tipo de Atividade) / ".$participacao->getFuncao()." (Função)");

            return $this->redirect()->toRoute('participacao/default', array(
                'action' => 'cadastrar',
                'evento' => $participacao->getAtividade()->getEvento()->getId()
            ));
        }

        $view = new ViewModel(array(
            'modelo' => $modelo_array,
            'participacao' => $participacao
        ));
        
        $view->setTerminal(true);
        
        return $view;
    }

    /**
     * Gera o Certificado em formato PDF e força o download no navegador
     */
    public function downloadAction()
    {
        /** @var  $participacao Participacao */
        $participacao = $this->getEm()
            ->getRepository('Application\Entity\Participacao')
            ->find($this->params('participacao', 0));
        $modelo = (new Certificado($this->getEm()))->getModeloComTexto($participacao);


        if (is_null($modelo)) {

            $this->flashMessenger()
                ->setNamespace(FlashMessenger::NAMESPACE_WARNING)
                ->addMessage("Não há nenhum modelo de certificado compatível com esta participação: ".$participacao->getAtividade()->getTipoAtividade()." (Tipo de Atividade) / ".$participacao->getFuncao()." (Função)");
            
            return $this->redirect()->toRoute('participacao/default', array(
                'action' => 'cadastrar',
                'evento' => $participacao->getAtividade()
                    ->getEvento()
                    ->getId()
            ));
        }

        return (new Certificado($this->getEm()))->gerarCertificado($modelo, $participacao, true);
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
         * **/
    }

    public function validarAction()
    {
        $menssages = null;
        $form = new ValidarCertificado();
        $request = $this->getRequest();


        $view = new ViewModel(array(
            'form' => $form
        ));
        
        $view->setTerminal(true);

        if ($request->isPost()) {
            $form->setData($request->getPost());
            
            if ($form->isValid()) {
                $data = $form->getData();

                /**
                 *
                 * @var Participacao $participacao
                 */
                $participacao = $this->getEm()
                    ->getRepository('Application\Entity\Participacao')
                    ->findOneBy(array(
                    'chaveValidacao' => $data['chave']
                ));

                if ($participacao) {
                    $modelo = (new Certificado($this->getEm()))->getModeloComTexto($participacao);

                    if (is_null($modelo)) {
                        $menssages = 'Código de registro inválido!!! Não há certificado compatível com esta participação.';
                    } else {
                        $view->setVariable('modelo', $modelo);
                        $view->setVariable('participacao', $participacao);
                        $view->setVariable('partipante', $participacao->getParticipante());
                    }
                } else {
                    $menssages = 'Não há nenhum certificado para a chave informada';
                }
            }
        }
        
        $view->setVariable('menssages', $menssages);
        
        return $view;
    }
}

