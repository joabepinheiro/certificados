<?php
namespace Application\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Zend\Hydrator\ClassMethods;

/**
 * Usuario
 *
 * @ORM\Table(name="usuario")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Application\Entity\UsuarioRepository")
 */
class Usuario
{

    /**
     *
     * @var integer @ORM\Column(name="id", type="integer", nullable=false)
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     *
     * @var string @ORM\Column(name="email", type="string", length=150, nullable=true)
     */
    private $email;

    /**
     *
     * @var string @ORM\Column(name="senha", type="string", length=255, nullable=true)
     */
    private $senha;

    /**
     *
     * @var string @ORM\Column(name="login", type="string", length=100, nullable=true)
     */
    private $login;

    /**
     *
     * @var string @ORM\Column(name="tipo", type="string", nullable=true)
     */
    private $tipo;

    /**
     *
     * @var ArrayCollection @ORM\OneToMany(targetEntity="Application\Entity\Evento", mappedBy="usuario", cascade={"persist", "remove"})
     */
    private $coordenacoes;

    public $verbose_name = 'Usuário';
    public $verbose_name_plural = 'Usuários';

    public function __construct(array $options = array())
    {
        (new ClassMethods())->hydrate($options, $this);
        $this->coordenacoes = new ArrayCollection();
    }

    public function toArray()
    {
        return (new ClassMethods())->extract($this);
    }

    public function dataForm()
    {
        $data = (new ClassMethods())->extract($this);
        return $data;
    }

    public function __toString()
    {
        return $this->getLogin();
    }

    /**
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     *
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     *
     * @return string
     */
    public function getSenha()
    {
        return $this->senha;
    }

    /**
     *
     * @param string $senha
     */
    public function setSenha($senha)
    {
        $this->senha = $this->encryptPassword($senha);
    }

    public function addSenhaNoEncrypt($senha)
    {
        $this->senha = $senha;
    }

    /**
     *
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     *
     * @param string $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     *
     * @param string $tipo
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }

    public function encryptPassword($senha)
    {
        return md5($senha);
    }

    public function isAdministrador()
    {
        return ($this->tipo == 'Administrador');
    }

    public function isCoordenadorDoEvento()
    {
        return ($this->tipo == 'Coordenador do Evento');
    }

    /**
     *
     * @return ArrayCollection
     */
    public function getCoordenacoes()
    {
        return $this->coordenacoes;
    }

    /**
     *
     * @param ArrayCollection $coordenacoes
     */
    public function setCoordenacoes($coordenacoes)
    {
        $this->coordenacoes = $coordenacoes;
    }
}

