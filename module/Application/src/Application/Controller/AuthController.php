<?php
namespace Application\Controller;

use Application\Auth\AdapterParticipante;
use Application\Form\EsqueciSenhaForm;
use Application\Form\LoginForm;
use Application\Form\LoginParticipanteForm;
use Base\Controller\ActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session as SessionStorage;
use Application\Auth\Adapter;
use Zend\Session\Container;

class AuthController extends ActionController
{

    public function indexAction()
    {
        if ($this->isLogado()) {
            $this->redirectHome();
        }
        
        $form = new LoginForm($this->getEm());
        $request = $this->getRequest();
        $menssages = array();
        
        $view = new ViewModel();
        $view->setTerminal(true);
        
        if ($request->isPost()) {
            $form->setData($request->getPost());
            
            if ($form->isValid()) {
                $data = $form->getData();
                
                $auth = new AuthenticationService();
                $sessioStorage = new SessionStorage('login');
                $auth->setStorage($sessioStorage);
                
                $authAdapter = new Adapter($this->em);
                $authAdapter->setLogin($data['login']);
                $authAdapter->setSenha($data['senha']);
                $result = $auth->authenticate($authAdapter);
                
                if ($result->isValid()) {
                    // Armazena o usuário em uma sessão
                    /** @var  $usuarioLogado \Application\Entity\Usuario */
                    $usuarioLogado = $auth->getIdentity();
                    $sessioStorage->write($usuarioLogado, null);
                    $container = new Container('logado');
                    
                    $usuario = $usuarioLogado->toArray();
                    
                    $container->offsetSet('usuario', $usuario);

                    if($usuarioLogado->getTipo() == 'Coordenador do Evento'){
                        $ultimo_evento = $this->em->getRepository('Application\Entity\Evento')
                            ->findOneBy(array(
                                'usuario' => $usuarioLogado
                            ), array('dataFinal' => 'DESC'));

                        if(!is_null($ultimo_evento)){
                            $container->offsetSet('evento_selecionado', $ultimo_evento->toArray());
                        }
                    }

                    $this->redirectHome();
                }
                $menssages = current($result->getMessages());
            } else {
                $menssages = current(current($form->getMessages()));
            }
        }
        $view->setVariable('form', $form);
        $view->setVariable('menssages', $menssages);
        
        return $view;
    }

    public function participanteAction()
    {
        if ($this->isLogado()) {
            $this->redirectHome();
        }
        
        $form = new LoginParticipanteForm();
        $request = $this->getRequest();
        $menssages = array();
        
        $view = new ViewModel();
        $view->setTerminal(true);
        
        if ($request->isPost()) {
            $form->setData($request->getPost());
            
            if ($form->isValid()) {
                $data = $form->getData();
                
                $auth = new AuthenticationService();
                $sessioStorage = new SessionStorage('login');
                $auth->setStorage($sessioStorage);
                
                $authAdapter = new AdapterParticipante($this->getEm());
                $authAdapter->setCpf($data['cpf']);
                $authAdapter->setDataNascimento($data['data_nascimento']);
                $result = $auth->authenticate($authAdapter);
                
                if ($result->isValid()) {
                    // Armazena o usuário em uma sessão
                    /** @var  $usuarioLogado \Application\Entity\Participante */
                    $usuarioLogado = $auth->getIdentity()->toArray();
                    $usuarioLogado['tipo'] = 'participante';
                    $sessioStorage->write($usuarioLogado, null);
                    $container = new Container('logado');
                    
                    $container->offsetSet('usuario', $usuarioLogado);
                    
                    $this->redirectHome();
                }
                $menssages = current($result->getMessages());
            } else {
                $menssages = current(current($form->getMessages()));
            }
        }
        $view->setVariable('form', $form);
        $view->setVariable('menssages', $menssages);
        
        return $view;
    }

    /**
     * Action de logout de todos os ususario de sistema
     * 
     * @return \Zend\Http\Response
     */
    function logoutAction()
    {
        $auth = new AuthenticationService();
        $auth->setStorage(new SessionStorage('login'));
        $auth->clearIdentity();
        
        $container = new Container('logado');
        $tipo = $container->offsetGet('usuario')['tipo'];
        $container->getManager()->destroy();
        
        if ($tipo == 'administrador') {
            return $this->redirect()->toRoute('login_administrador');
        }
        return $this->redirect()->toRoute('login');
    }

    public function esqueciSenhaAction(){
        $form = new EsqueciSenhaForm();
        $request = $this->getRequest();

        $view =  new ViewModel(array(
            'form' => $form
        ));

        if ($request->isPost()) {

            $data = $request->getPost();

            $form->setData($data);


            if ($form->isValid()) {
                $usuario = $this->getEm()->getRepository('Application\Entity\Usuario')->findOneBy(array(
                    'email' => $data['email'])
                );

                if(is_null($usuario)){
                    //$view->setVariable('form', $form);
                    $view->setVariable('menssages',
                        'Esse email não é utilizado por nenhum usuário'
                    );
                }else{

                }

            }
        }


        $view->setTerminal(true);

        return $view;

    }

}

