<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Hydrator\ClassMethods;


/**
 * Atividade
 *
 * @ORM\Table(name="atividade", indexes={@ORM\Index(name="tipo_atividade_id", columns={"tipo_atividade_id"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Application\Entity\AtividadeRepository")
 */
class Atividade
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
     * @var float @ORM\Column(name="carga_horaria", type="float", precision=10, scale=0, nullable=true)
     */
    private $cargaHoraria;

    /**
     *
     * @var string @ORM\Column(name="titulo", type="string", length=200, nullable=true)
     */
    private $titulo;

    /**
     *
     * @var \DateTime @ORM\Column(name="data_inicio", type="datetime", nullable=true)
     */
    private $dataInicio;

    /**
     *
     * @var \DateTime @ORM\Column(name="data_fim", type="datetime", nullable=true)
     */
    private $dataFim;

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
     * @var TipoAtividade @ORM\ManyToOne(targetEntity="TipoAtividade")
     *      @ORM\JoinColumns({
     *      @ORM\JoinColumn(name="tipo_atividade_id", referencedColumnName="id")
     *      })
     */
    private $tipoAtividade;

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
        $data['data_inicio'] = $data['data_inicio']->format('d/m/Y');
        $data['data_fim'] = $data['data_fim']->format('d/m/Y');
        $data['evento'] = $data['evento']->getId();
        return $data;
    }

    /**
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getTitulo();
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
     * @return float
     */
    public function getCargaHoraria()
    {
        return $this->cargaHoraria;
    }

    /**
     *
     * @param float $cargaHoraria
     */
    public function setCargaHoraria($cargaHoraria)
    {
        $this->cargaHoraria = $cargaHoraria;
    }

    /**
     *
     * @return TipoAtividade
     */
    public function getTipoAtividade()
    {
        return $this->tipoAtividade;
    }

    /**
     *
     * @param TipoAtividade $tipoAtividade
     */
    public function setTipoAtividade($tipoAtividade)
    {
        $this->tipoAtividade = $tipoAtividade;
    }

    /**
     *
     * @return string
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     *
     * @param string $titulo
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
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
     * @return \DateTime
     */
    public function getDataInicio()
    {
        return $this->dataInicio;
    }

    /**
     *
     * @param \DateTime $dataInicio
     */
    public function setDataInicio($dataInicio)
    {
        $this->dataInicio = $dataInicio;
    }

    /**
     *
     * @return \DateTime
     */
    public function getDataFim()
    {
        return $this->dataFim;
    }

    /**
     *
     * @param \DateTime $dataFim
     */
    public function setDataFim($dataFim)
    {
        $this->dataFim = $dataFim;
    }


}


