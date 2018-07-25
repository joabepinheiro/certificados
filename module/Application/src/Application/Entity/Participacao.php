<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Hydrator\ClassMethods;

/**
 * Participacao
 *
 * @ORM\Table(name="participacao", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"}), @ORM\UniqueConstraint(name="chave_validacao", columns={"chave_validacao"})}, indexes={@ORM\Index(name="participante_id", columns={"participante_id"}), @ORM\Index(name="funcao_id", columns={"funcao_id"}), @ORM\Index(name="FK_participacao_atividade", columns={"atividade_id"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Application\Entity\ParticipacaoRepository")
 */
class Participacao
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var float
     *
     * @ORM\Column(name="carga_horaria", type="float", precision=10, scale=0, nullable=true, unique=false)
     */
    private $cargaHoraria;

    /**
     * @var integer
     *
     * @ORM\Column(name="ordem_autoria", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $ordem;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="email_enviado_em", type="datetime", precision=0, scale=0, nullable=true, unique=false)
     */
    private $emailEnviadoEm;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data_ultima_emissao", type="datetime", precision=0, scale=0, nullable=false, unique=false)
     */
    private $dataUltimaEmissao;

    /**
     * @var integer
     *
     * @ORM\Column(name="qtd_bolsista", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $qtdBolsista;

    /**
     * @var string
     *
     * @ORM\Column(name="chave_validacao", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $chaveValidacao;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data_inicio", type="datetime", precision=0, scale=0, nullable=true, unique=false)
     */
    private $dataInicio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data_fim", type="datetime", precision=0, scale=0, nullable=true, unique=false)
     */
    private $dataFim;

    /**
     * @var \Application\Entity\Atividade
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Atividade")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="atividade_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $atividade;

    /**
     * @var \Application\Entity\Evento
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Evento")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="evento_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $evento;

    /**
     * @var \Application\Entity\Funcao
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Funcao")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="funcao_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $funcao;

    /**
     * @var \Application\Entity\Participante
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Participante")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="participante_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $participante;


    public $verbose_name = 'Participação';

    public $verbose_name_plural = 'Participações';

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
        return (string) 'Participação em ' . $this->getAtividade()
            ->getEvento()
            ->getNome() . ' ' . $this->getAtividade()
            ->getEvento()
            ->getAno() . ' como ' . $this->getFuncao()->getNome();
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
     * @return int
     */
    public function getOrdem()
    {
        return $this->ordem;
    }

    /**
     *
     * @param int $ordem
     */
    public function setOrdem($ordem)
    {
        $this->ordem = $ordem;
    }

    /**
     *
     * @return \DateTime
     */
    public function getDataUltimaEmissao()
    {
        return $this->dataUltimaEmissao;
    }

    /**
     *
     * @param \DateTime $dataUltimaEmissao
     */
    public function setDataUltimaEmissao($dataUltimaEmissao)
    {
        $this->dataUltimaEmissao = $dataUltimaEmissao;
    }

    /**
     *
     * @return int
     */
    public function getQtdBolsista()
    {
        return $this->qtdBolsista;
    }

    /**
     *
     * @param bool $qtdBolsista
     */
    public function setQtdBolsista($qtdBolsista)
    {
        $this->qtdBolsista = $qtdBolsista;
    }

    /**
     *
     * @return string
     */
    public function getChaveValidacao()
    {
        return $this->chaveValidacao;
    }

    /**
     *
     * @param string $chaveValidacao
     */
    public function setChaveValidacao($chaveValidacao)
    {
        $this->chaveValidacao = $chaveValidacao;
    }

    /**
     *
     * @return Atividade
     */
    public function getAtividade()
    {
        return $this->atividade;
    }

    /**
     *
     * @param \Atividade $atividade
     */
    public function setAtividade($atividade)
    {
        $this->atividade = $atividade;
    }

    /**
     * @return Evento
     */
    public function getEvento()
    {
        return $this->evento;
    }

    /**
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

    /**
     *
     * @return Participante
     */
    public function getParticipante()
    {
        return $this->participante;
    }

    /**
     *
     * @param Participante $participante
     */
    public function setParticipante($participante)
    {
        $this->participante = $participante;
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

    /**
     * @return \DateTime
     */
    public function getEmailEnviadoEm()
    {
        return $this->emailEnviadoEm;
    }

    /**
     * @param \DateTime $emailEnviadoEm
     */
    public function setEmailEnviadoEm($emailEnviadoEm)
    {
        $this->emailEnviadoEm = $emailEnviadoEm;
    }





}

