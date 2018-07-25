<?php
namespace Application\Auth;

use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Result;
use Doctrine\ORM\EntityManager;
use Zend\Session\Container;

class Adapter implements AdapterInterface
{

    protected $em;

    protected $login;

    protected $senha;

    function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function authenticate()
    {
        /** @var $repository \Application\Entity\UsuarioRepository*/
        $repository = $this->em->getRepository('Application\Entity\Usuario');
        /** @var  $usuario \Application\Entity\Usuario */
        $usuario = $repository->findByLoginSenha($this->getLogin(), $this->getSenha());

        if ($usuario) {

            return new Result(Result::SUCCESS, $usuario, array());
        }
        return new Result(Result::FAILURE_CREDENTIAL_INVALID, null, array(
            'O login ou senha estão incorretos'
        ));
    }

    /**
     *
     * @return EntityManager
     */
    public function getEm()
    {
        return $this->em;
    }

    /**
     *
     * @param EntityManager $em
     */
    public function setEm($em)
    {
        $this->em = $em;
    }

    /**
     *
     * @return mixed
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     *
     * @param mixed $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     *
     * @return mixed
     */
    public function getSenha()
    {
        return $this->senha;
    }

    /**
     *
     * @param mixed $senha
     */
    public function setSenha($senha)
    {
        $this->senha = $senha;
    }
}