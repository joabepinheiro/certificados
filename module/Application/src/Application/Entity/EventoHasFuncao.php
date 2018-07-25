<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator;
use Zend\Crypt\Key\Derivation\Pbkdf2;

/**
 * EventoHasFuncao
 *
 * @ORM\Table(name="evento_has_funcao", indexes={@ORM\Index(name="fk_evento_has_funcao_evento1_idx", columns={"evento_id"}), @ORM\Index(name="fk_evento_has_funcao_funcao1_idx", columns={"funcao_id"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Application\Entity\EventoHasFuncaoRepository")
 */
class EventoHasFuncao
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
     * @var \DateTime @ORM\Column(name="cadastradoEm", type="datetime", nullable=false)
     */
    private $cadastradoem = 'CURRENT_TIMESTAMP';

    /**
     *
     * @var Evento @ORM\ManyToOne(targetEntity="Evento")
     *      @ORM\JoinColumns({
     *      @ORM\JoinColumn(name="evento_id", referencedColumnName="id")
     *      })
     */
    private $evento;

    /**
     *
     * @var Funcao @ORM\ManyToOne(targetEntity="Funcao")
     *      @ORM\JoinColumns({
     *      @ORM\JoinColumn(name="funcao_id", referencedColumnName="id")
     *      })
     */
    private $funcao;

    public function __construct(array $options = array())
    {
        $this->cadastradoEm = new \DateTime("now");
        (new Hydrator\ClassMethods())->hydrate($options, $this);
    }

    public function toArray()
    {
        return (new Hydrator\ClassMethods())->extract($this);
    }

    public function dataForm()
    {
        return (new Hydrator\ClassMethods())->extract($this);
    }

    public function __toString()
    {
        return (string) $this->getId();
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
     * @return \DateTime
     */
    public function getCadastradoem()
    {
        return $this->cadastradoem;
    }

    /**
     *
     * @param \DateTime $cadastradoem
     */
    public function setCadastradoem($cadastradoem)
    {
        $this->cadastradoem = $cadastradoem;
    }

    /**
     *
     * @return Evento
     */
    public function getEvento()
    {
        return $this->evento;
    }

    /**
     *
     * @param Evento $evento
     */
    public function setEvento($evento)
    {
        $this->evento = $evento;
    }

    /**
     *
     * @return Funcao
     */
    public function getFuncao()
    {
        return $this->funcao;
    }

    /**
     *
     * @param Funcao $funcao
     */
    public function setFuncao($funcao)
    {
        $this->funcao = $funcao;
    }
}

