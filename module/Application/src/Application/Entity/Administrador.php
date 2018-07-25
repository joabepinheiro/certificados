<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator;
use Zend\Crypt\Key\Derivation\Pbkdf2;

/**
 * Administrador
 *
 * @ORM\Table(name="administrador")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Application\Entity\AdministradorRepository")
 */
class Administrador
{

    /**
     *
     * @var integer @ORM\Column(name="id", type="bigint", nullable=false)
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     *
     * @var string @ORM\Column(name="nome", type="string", length=100, nullable=false)
     */
    private $nome;

    /**
     *
     * @var string @ORM\Column(name="sobrenome", type="string", length=100, nullable=false)
     */
    private $sobrenome;

    /**
     *
     * @var string @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email;

    /**
     *
     * @var string @ORM\Column(name="senha", type="string", length=255, nullable=false)
     */
    private $senha;

    /**
     *
     * @var string @ORM\Column(name="dominio", type="string", length=100, nullable=true)
     */
    private $dominio;

    /**
     *
     * @var string @ORM\Column(name="cnpj", type="string", length=100, nullable=true)
     */
    private $cnpj;

    /**
     *
     * @var string @ORM\Column(name="cpf", type="string", length=100, nullable=true)
     */
    private $cpf;

    /**
     *
     * @var string @ORM\Column(name="endereco", type="string", length=255, nullable=false)
     */
    private $endereco;

    /**
     *
     * @var string @ORM\Column(name="numero", type="string", length=45, nullable=false)
     */
    private $numero;

    /**
     *
     * @var string @ORM\Column(name="cep", type="string", length=45, nullable=false)
     */
    private $cep;

    /**
     *
     * @var string @ORM\Column(name="bairro", type="string", length=100, nullable=false)
     */
    private $bairro;

    /**
     *
     * @var string @ORM\Column(name="cidade", type="string", length=45, nullable=false)
     */
    private $cidade;

    /**
     *
     * @var string @ORM\Column(name="estado", type="string", length=45, nullable=false)
     */
    private $estado;

    /**
     *
     * @var boolean @ORM\Column(name="ativo", type="boolean", nullable=false)
     */
    private $ativo;

    /**
     *
     * @var \DateTime @ORM\Column(name="cadastrado_em", type="datetime", nullable=false)
     */
    private $cadastradoEm = 'CURRENT_TIMESTAMP';

    private $hash = 'jm8NY81CiHA=edhdvFRy14g54sGFG';

    public $verbose_name = 'Administrador';

    public $verbose_name_plural = 'Administradores';

    public function __construct(array $options = array())
    {
        (new Hydrator\ClassMethods())->hydrate($options, $this);
        $this->cadastradoEm = new \DateTime("now");
    }

    public function toArray()
    {
        return (new Hydrator\ClassMethods())->extract($this);
    }

    public function dataForm()
    {
        $data = (new Hydrator\ClassMethods())->extract($this);
        return $data;
    }

    public function __toString()
    {
        return $this->getNome() . ' ' . $this->getSobrenome();
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
    public function getNome()
    {
        return $this->nome;
    }

    /**
     *
     * @param string $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     *
     * @return string
     */
    public function getSobrenome()
    {
        return $this->sobrenome;
    }

    /**
     *
     * @param string $sobrenome
     */
    public function setSobrenome($sobrenome)
    {
        $this->sobrenome = $sobrenome;
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

    /**
     *
     * @return string
     */
    public function getDominio()
    {
        return $this->dominio;
    }

    /**
     *
     * @param string $dominio
     */
    public function setDominio($dominio)
    {
        $this->dominio = $dominio;
    }

    /**
     *
     * @return string
     */
    public function getCnpj()
    {
        return $this->cnpj;
    }

    /**
     *
     * @param string $cnpj
     */
    public function setCnpj($cnpj)
    {
        $this->cnpj = $cnpj;
    }

    /**
     *
     * @return string
     */
    public function getCpf()
    {
        return $this->cpf;
    }

    /**
     *
     * @param string $cpf
     */
    public function setCpf($cpf)
    {
        $this->cpf = $cpf;
    }

    /**
     *
     * @return string
     */
    public function getEndereco()
    {
        return $this->endereco;
    }

    /**
     *
     * @param string $endereco
     */
    public function setEndereco($endereco)
    {
        $this->endereco = $endereco;
    }

    /**
     *
     * @return string
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     *
     * @param string $numero
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;
    }

    /**
     *
     * @return string
     */
    public function getCep()
    {
        return $this->cep;
    }

    /**
     *
     * @param string $cep
     */
    public function setCep($cep)
    {
        $this->cep = $cep;
    }

    /**
     *
     * @return string
     */
    public function getBairro()
    {
        return $this->bairro;
    }

    /**
     *
     * @param string $bairro
     */
    public function setBairro($bairro)
    {
        $this->bairro = $bairro;
    }

    /**
     *
     * @return string
     */
    public function getCidade()
    {
        return $this->cidade;
    }

    /**
     *
     * @param string $cidade
     */
    public function setCidade($cidade)
    {
        $this->cidade = $cidade;
    }

    /**
     *
     * @return string
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     *
     * @param string $estado
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    /**
     *
     * @return bool
     */
    public function isAtivo()
    {
        return $this->ativo;
    }

    /**
     *
     * @param bool $ativo
     */
    public function setAtivo($ativo)
    {
        $this->ativo = $ativo;
    }

    /**
     *
     * @return \DateTime
     */
    public function getCadastradoEm()
    {
        return $this->cadastradoEm;
    }

    /**
     *
     * @param \DateTime $cadastradoEm
     */
    public function setCadastradoEm($cadastradoEm)
    {
        $this->cadastradoEm = $cadastradoEm;
    }

    /**
     *
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     *
     * @param string $hash
     */
    public function setHash($hash)
    {
        $this->hash = $hash;
    }

    /**
     *
     * @return string
     */
    public function getVerboseName()
    {
        return $this->verbose_name;
    }

    /**
     *
     * @param string $verbose_name
     */
    public function setVerboseName($verbose_name)
    {
        $this->verbose_name = $verbose_name;
    }

    /**
     *
     * @return string
     */
    public function getVerboseNamePlural()
    {
        return $this->verbose_name_plural;
    }

    /**
     *
     * @param string $verbose_name_plural
     */
    public function setVerboseNamePlural($verbose_name_plural)
    {
        $this->verbose_name_plural = $verbose_name_plural;
    }

    public function encryptPassword($password)
    {
        return base64_encode(Pbkdf2::calc('sha256', $password, $this->hash, 10000, strlen($password * 2)));
    }
}

