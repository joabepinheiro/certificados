<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Hydrator\ClassMethods;

/**
 * Instituto
 *
 * @ORM\Table(name="instituto")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Application\Entity\InstitutoRepository")
 */
class Instituto
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
     * @var string @ORM\Column(name="sigla", type="string", length=15, nullable=true)
     */
    private $sigla;

    /**
     *
     * @var string @ORM\Column(name="nome", type="string", length=150, nullable=true)
     */
    private $nome;

    /**
     *
     * @var string @ORM\Column(name="campus", type="string", length=100, nullable=true)
     */
    private $campus;

    public function __construct(array $options = array())
    {
        (new ClassMethods())->hydrate($options, $this);
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
        return $this->getNome();
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
    public function getSigla()
    {
        return $this->sigla;
    }

    /**
     *
     * @param string $sigla
     */
    public function setSigla($sigla)
    {
        $this->sigla = $sigla;
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
    public function getCampus()
    {
        return $this->campus;
    }

    /**
     *
     * @param string $campus
     */
    public function setCampus($campus)
    {
        $this->campus = $campus;
    }
}

