<?php
namespace Application\Controller;

use Application\Form\ConfigurarModeloCertificado;
use Application\Form\ModeloCertificadoForm;
use Application\Service\CertificadoTipoFuncaoEvento;
use Application\Service\ModeloCertificado;
use Base\Controller\ActionController;
use Zend\Mvc\Controller\Plugin\FlashMessenger;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class ConfigurarModeloCertificadoController extends ActionController
{

    public function __construct()
    {
        $this->entity       = 'Application\Entity\CertificadoTipoFuncaoEvento';
        $this->form         = 'Application\Form\ConfigurarModeloCertificado.php';
        $this->formService  = true;
        $this->service      = 'Application\Service\ConfigurarModeloCertificado';
        $this->controller   = 'configurar-modelo-certificado/default';
        $this->route        = 'configurar-modelo-certificado/default';
    }

    public function cadastrarAction()
    {

        $evento = $this->getEm()->getRepository('Application\Entity\Evento')->find($this->params('evento'));
        $form = new ConfigurarModeloCertificado(null, $this->getEm(), $evento);

        $request = $this->getRequest();

        if ($request->isPost()) {

            $data = $request->getPost()->toArray();
            $files = $request->getFiles();

            $data = array_merge($data, [
                'bgFrente' => $files['bgFrente'],
                'bgVerso'  => $files['bgVerso']
            ]);


            $form->setData($data);

            if ($form->isValid()) {
                $service = new CertificadoTipoFuncaoEvento($this->getEm());

                $array = $service->insert($data);

                foreach ($array['message'] as $value){
                    $this->flashMessenger()
                        ->setNamespace(FlashMessenger::NAMESPACE_WARNING)
                        ->addMessage($value);
                }

                if($array['inserts'] > 0){
                    $this->flashMessenger()
                        ->setNamespace('success')
                        ->addMessage( 'Modelo cadastrado com sucesso');
                }

                $form = new ConfigurarModeloCertificado(null, $this->getEm(), $evento);

                $this->redirect()->toRoute($this->route, array(
                    'action' => 'listar',
                    'evento' => $evento->getId()
                ));
            }
        }

        return new ViewModel(array(
            'form'          => $form,
            'evento'        => $evento,
        ));
    }

    public function listarAction()
    {
        $evento = $this->getEm()->getRepository('Application\Entity\Evento')->find($this->params('evento'));

        if ($this->podeAcessarParticipacao($evento)) {
            $modelos = $this->getEm()->getRepository('Application\Entity\ModeloCertificado')->getModelosDoEvento($evento->getId());
        } else {
            return $this->redirect()->toRoute('coordenador/default', array(
                'action' => 'listar-eventos'
            ));
        }

        return new ViewModel(array(
            'evento'        => $evento,
            'modelos'       => $modelos
        ));
    }

    public function editarAction(){
        $evento = $this->getEm()->getRepository('Application\Entity\Evento')->find($this->params('evento'));
        $form = new ConfigurarModeloCertificado(null, $this->getEm(), $evento);
        $form->editingMode();

        $modelo =  $this->getEm()->getRepository('Application\Entity\ModeloCertificado')->find($this->params('id'));

        $request = $this->getRequest();

        $repository = $this->getEm()->getRepository('Application\Entity\ModeloCertificado');
        $entity = $repository->find($this->getPK());

        if (! $entity) {
            return $this->redirect()->toRoute($this->route);
        }

        if ($this->params()->fromRoute('id', 0)) {
            $form->setData($entity->dataForm());
        }

        if ($request->isPost()) {

            $data = $request->getPost()->toArray();
            $files = $request->getFiles();

            $data = array_merge($data, [
                'bgFrente' => $files['bgFrente'],
                'bgVerso'  => $files['bgVerso']
            ]);

            $form->setData($data);

            if ($form->isValid()) {
                $service = new CertificadoTipoFuncaoEvento($this->getEm());

                $array = $service->update($data);

                foreach ($array['message'] as $value){
                    $this->flashMessenger()
                        ->setNamespace(FlashMessenger::NAMESPACE_WARNING)
                        ->addMessage($value);
                }

                if($array['inserts'] > 0){
                    $this->flashMessenger()
                        ->setNamespace('success')
                        ->addMessage( $entity . ' atualizado com sucesso');
                }

                $form = new ConfigurarModeloCertificado(null, $this->getEm(), $evento);

                $this->redirect()->toRoute($this->route, array(
                    'action' => 'listar',
                    'evento' => $evento->getId()
                ));
            }
        }

        return new ViewModel(array(
            'form'          => $form,
            'evento'        => $evento,
            'modelo'        => $modelo,
        ));
    }
    public function editar2Action()
    {
        $modelo_certificado_id = $this->params('id');

        $evento      = $this->getEm()->getRepository('Application\Entity\Evento')->find($this->params('evento'));
        $form        = new ConfigurarModeloCertificado(null, $this->getEm(), $evento);
        $form_modelo = new ModeloCertificadoForm(null, $this->getEm());
        $modelos     = $this->getEm()->getRepository('Application\Entity\ModeloCertificado')->getModelosDoEvento($evento->getId());
        $modeloCertificado =  $this->getEm()->getRepository('Application\Entity\ModeloCertificado')->find($modelo_certificado_id);


        $certificadosTipoFuncaoEvento = $this->getEm()->getRepository('Application\Entity\CertificadoTipoFuncaoEvento')->findBy(array(
            'evento'            => $evento,
            'modeloCertificado' => $modeloCertificado
        ));


        $request = $this->getRequest();

        if ($request->isPost()) {

            $data = $request->getPost()->toArray();
            $form->setData($data);


            if ($form->isValid()) {
                $service = new CertificadoTipoFuncaoEvento($this->getEm());

                $array = $service->update($data);

                foreach ($array['message'] as $value){
                    $this->flashMessenger()
                        ->setNamespace(FlashMessenger::NAMESPACE_WARNING)
                        ->addMessage($value);
                }

                if($array['inserts'] > 0){
                    $this->flashMessenger()
                        ->setNamespace('success')
                        ->addMessage( $array['inserts']. ' critérios atualizados com sucesso');
                }

                $this->redirect()->toRoute($this->route, array(
                    'action' => 'editar',
                    'id'     => $modelo_certificado_id,
                    'evento' => $evento->getId()
                ));

            }
        }

        return new ViewModel(array(
            'form'                          => $form,
            'form_modelo'                   => $form_modelo,
            'evento'                        => $evento,
            'modelo'                        => $modeloCertificado,
            'modelos'                       => $modelos,
            'certificadosTipoFuncaoEvento'  => $certificadosTipoFuncaoEvento
        ));
    }


    public function deletarAction()
    {
        $id = $this->params('id', 0);
        $evento_id = $this->params('evento', 0);


        $service = new ModeloCertificado($this->getEm());

        $row = $this->getEm()
            ->getRepository('Application\Entity\ModeloCertificado')
            ->findOneBy(array(
                'id' => $id
            ));

        
        if ($row) {
            $id = $service->delete($id);

            if (! is_null($id)) {
                $this->flashMessenger()
                    ->setNamespace(FlashMessenger::NAMESPACE_ERROR)
                    ->addMessage($row . ' removido');
            }
        }

        return $this->redirect()->toRoute($this->route, array(
            'action' => 'listar',
            'evento' => $evento_id
        ));
    }


    /**
     * Deleta um único critério de um determinado evento
     * @return \Zend\Http\Response
     */
    public function deletarCriterioAction()
    {
        $id = $this->params('id', 0);
        $evento_id = $this->params('evento', 0);

        $service = new CertificadoTipoFuncaoEvento($this->getEm());
        $result = $service->delete(array(
            'id' => $id
        ));

        if ($result) {
            $this->flashMessenger()
                ->setNamespace(FlashMessenger::NAMESPACE_ERROR)
                ->addMessage( 'Critério removido');
        }

        return $this->redirect()->toRoute($this->route, array(
            'action' => 'listar',
            'evento' => $evento_id
        ));
    }

    public function previewAction()
    {
        $id = $this->params('id', 0);
        $evento_id = $this->params('evento', 0);
        
        $modelo = $this->getEm()
            ->getRepository($this->entity)
            ->getModeloComTexto($id);
        
        var_dump($modelo);
        die();
    }


    public function podeAcessarParticipacao(\Application\Entity\Evento $evento)
    {
        $bool = $this->getTipoUsuarioLogado() == 'Administrador' || $evento->getUsuario()->getId() == $this->getUsuarioLogado()['id'];

        if (! $bool) {
            $this->flashMessenger()
                ->setNamespace('error')
                ->addMessage(' Você não é o coordenador desse evento e não pode visualisar ou alterar informações com essa conta ');
        }

        return $bool;
    }

}

