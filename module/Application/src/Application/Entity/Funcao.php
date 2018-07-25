<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Hydrator\ClassMethods;

/**
 * Funcao
 *
 * @ORM\Table(name="funcao")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Application\Entity\FuncaoRepository")
 */
class Funcao
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
     * @var string @ORM\Column(name="nome", type="string", length=120, nullable=false)
     */
    private $nome;

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
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param string $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }


}

