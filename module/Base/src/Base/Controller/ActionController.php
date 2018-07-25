<?php
namespace Base\Controller;

use Application\Entity\Participante;
use Application\Entity\Usuario;
use Base\Form\DeletarForm;
use Doctrine\Common\EventManager;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Zend\Form\Form;
use Zend\Http\Request;
use Zend\Mvc\Application;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\Controller\Plugin\FlashMessenger;
use Zend\Session\Container;
use zend\View\Model\ViewModel;
use Zend\Paginator\Paginator, Zend\Paginator\Adapter\ArrayAdapter;

/** @var  $em \Doctrine\ORM\EntityManager */
class ActionController extends AbstractActionController
{

    protected $em;

    protected $service;

    protected $entity;

    protected $form;

    protected $formService = false;

    protected $route;

    protected $route_params = array(
        'deletar' => array(
            'action' => 'listar'
        ),
        'cadastrar' => array(
            'action' => 'listar'
        ),
        'editar' => array(
            'action' => 'listar'
        )
    );

    protected $controller;

    protected $action;

    protected $pageDelete = false;

    public function indexAction()
    {
        return $this->redirect()->toRoute($this->route, array(
            'action' => 'listar'
        ));
    }

    public function cadastrarAction()
    {
        $form = ($this->formService) ? $this->getServiceLocator()->get($this->form) : new $this->form();
        $request = $this->getRequest();
        
        if ($request->isPost()) {

            $form->setData($request->getPost());


            if ($form->isValid()) {
                $service = $this->getServiceLocator()->get($this->service);
                $entity = $service->insert($form->getData());
                
                if ($entity) {
                    $this->flashMessenger()
                        ->setNamespace('success')
                        ->addMessage($entity . ' cadastrado com sucesso');
                    
                    $form = ($this->formService) ? $this->getServiceLocator()->get($this->form) : new $this->form();
                    $this->redirect()->toRoute($this->route, $this->route_params['cadastrar']);
                }
            }
        }
        
        return new ViewModel(array(
            'form' => $form
        ));
    }

    public function editarAction()
    {
        $form = ($this->formService) ? $this->getServiceLocator()->get($this->form) : new $this->form();
        $form->editingMode();
        
        $request = $this->getRequest();
        
        $repository = $this->getEm()->getRepository($this->entity);
        $entity = $repository->find($this->getPK());
        
        if (! $entity) {
            return $this->redirect()->toRoute($this->route);
        }
        
        if ($this->params()->fromRoute('id', 0)) {
            $form->setData($entity->dataForm());
        }
        
        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $service = $this->getServiceLocator()->get($this->service);
                $result = $service->update($form->getData());
                
                if ($result) {
                    $this->flashMessenger()
                        ->setNamespace('success')
                        ->addMessage($entity . ' atualizado com sucesso');
                    
                    $this->redirect()->toRoute($this->route, $this->route_params['editar']);
                }
            }
        }
        
        return new ViewModel(array(
            'form' => $form,
            'entity' => $entity
        ));
    }

    /**
     * Retorna os registros da entidade com paginação
     * 
     * @return ViewModel
     */
    public function listarAction()
    {
        $list = $this->getEm()
            ->getRepository($this->entity)
            ->findAll();
        $page = $this->params()->fromRoute('page');
        
        /**
         * $paginator = new Paginator(new ArrayAdapter($list));
         * $paginator->setCurrentPageNumber($page)
         * ->setDefaultItemCountPerPage(1);
         */
        
        return new ViewModel(array(
            'data' => $list,
            'page' => $page
        ));
    }

    public function detalhesAction()
    {
        $id = $this->params('id');
        $entity = $this->getEm()
            ->getRepository($this->entity)
            ->find($id);
        
        return new ViewModel(array(
            'entity' => $entity
        ));
    }

    /**
     * Retorna todos os registros da entidade sem paginação
     * 
     * @return ViewModel
     */
    public function listarTodosAction()
    {
        $list = $this->getEm()
            ->getRepository($this->entity)
            ->findAll();
        
        return new ViewModel(array(
            'data' => $list
        ));
    }

    public function deletarAction()
    {
        $id = $this->params('id', 0);
        
        if ($this->pageDelete) {
            return $this->deletarDetailsAction();
        } else {
            $service = $this->getServiceLocator()->get($this->service);
            $row = $this->getEm()
                ->getRepository($this->entity)
                ->findOneBy(array(
                'id' => $id
            ));
            
            if ($row) {
                $id = $service->delete(array(
                    'id' => $id
                ));
                
                if (! is_null($id)) {
                    $this->flashMessenger()
                        ->setNamespace(FlashMessenger::NAMESPACE_ERROR)
                        ->addMessage($row . ' removido');
                }
            }
        }
        
        return $this->redirect()->toRoute($this->route, $this->route_params['deletar']);
    }

    public function deletarDetailsAction()
    {
        $this->layout()->setVariable('titulo', 'Deletar registro permanentemente');
        
        $form = new DeletarForm();
        $request = $this->getRequest();
        $id = $this->getPK();
        
        $row = $this->getEm()
            ->getRepository($this->entity)
            ->find(array(
            'id' => $id
        ));
        
        // Se o registro a ser deletado existir popula o form deletar com ele
        if (! $row)
            return $this->redirect()->toRoute($this->route, array(
                'action' => 'listar'
            ));
        else
            $form->setData($row->toArray());
        
        if ($request->isPost()) {
            $data = $request->getPost();
            $form->setData($request->getPost());
            
            if ($form->isValid() && $data['result'] === 'sim') {
                
                $this->flashMessenger()
                    ->setNamespace('success')
                    ->addMessage($row . ' removido');
                
                $service = $this->getServiceLocator()->get($this->service);
                $service->delete(array(
                    'id' => $id
                ));
                
                return $this->redirect()->toRoute($this->route, array(
                    'action' => 'listar'
                ));
            }
            return $this->redirect()->toRoute($this->route, array(
                'action' => 'listar'
            ));
        }
        
        return new ViewModel(array(
            'form' => $form,
            'row' => $row,
            'rote' => $this->route
        ));
    }

    /**
     * Retorna o em do banco de dados root do sistema
     * 
     * @return \Doctrine\ORM\EntityManager
     */
    protected function getEm()
    {
        return $this->em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
    }

    /**
     * Retorna a chave primaria enviada pela requisição,
     * 
     * @param string $pk
     * @return mixed $id
     */
    protected function getPK($pk = 'id')
    {
        if (! is_null($this->getRequest()->getPost()[$pk]))
            return $this->getRequest()->getPost()[$pk];
        return $this->params()->fromRoute($pk, 0);
    }

    /**
     * Retorna o tipo do usuario logado
     * 
     * @return null
     */
    public function getTipoUsuarioLogado()
    {
        $container = new Container('logado');
        
        if ($container->offsetExists('usuario')) {
            return $container->offsetGet('usuario')['tipo'];
        }
        return null;
    }

    /**
     * Retorna true se o usuario for administrador
     * 
     * @return null
     */
    public function isTipoUsuarioAdministrador()
    {
        $container = new Container('logado');
        
        if ($container->offsetExists('usuario')) {
            if ($container->offsetGet('usuario')['tipo'] == 'Administrador') {
                return true;
            }
        }
        return null;
    }

    public function getUsuarioLogado()
    {
        $container = new Container('logado');
        
        if ($container->offsetExists('usuario')) {
            return $container->offsetGet('usuario');
        }
        return null;
    }

    /**
     * A home do usuário muda a depender do tipo de usuário logado a
     * função abaixo redireciona para o home do usuario logado
     *
     * @return \Zend\Http\Response
     */
    public function redirectHome()
    {
        $container = new Container('logado');
        
        // Se existir alguem logado
        if ($container->offsetExists('usuario')) {
            $tipo = $container->offsetGet('usuario')['tipo'];
            
            if ($tipo == 'Administrador') {
                return $this->redirect()->toRoute('administrador/default', array(
                    'action' => 'dashboard'
                ));
            }
            
            if ($tipo == 'Coordenador do Evento') {
                return $this->redirect()->toRoute('coordenador/default', array(
                    'action' => 'dashboard'
                ));
            }
            
            if ($tipo == 'participante') {
                return $this->redirect()->toRoute('participante/default', array(
                    'action' => 'perfil'
                ));
            }
            
            return $this->redirect()->toRoute('home');
        } else {
            $this->redirect()->toRoute('home');
        }
    }

    public function atualizarLogado()
    {
        $container = new Container('logado');
        $usuario = $this->getEm()->find('Application\Entity\Usuario', $this->getLogado()
            ->getId());
        $container->offsetSet('usuario', $usuario->toArray());
    }

    public function isLogado()
    {
        $container = new Container('logado');
        // Se existir alguem logado
        if ($container->offsetExists('usuario')) {
            return true;
        }
        return false;
    }

    public function coordenadorLogadoECordenadorRequerendoAcessoAoRecurso($id_do_coordenador_logado, $id_do_coordenador_do_recurso)
    {
        if ($this->isTipoUsuarioAdministrador()) {
            return true;
        }
        
        if ($id_do_coordenador_logado != $id_do_coordenador_do_recurso)
            return false;
        return true;
    }
}