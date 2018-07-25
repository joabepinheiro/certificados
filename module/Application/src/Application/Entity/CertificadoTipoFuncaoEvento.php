<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Hydrator\ClassMethods;

/**
 * CertificadoTipoFuncaoEvento
 *
 * @ORM\Table(name="certificado_tipo_funcao_evento", uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})}, indexes={@ORM\Index(name="fk_certificado_tipo_funcao_modelo_certificado1_idx", columns={"modelo_certificado_id"}), @ORM\Index(name="fk_certificado_tipo_funcao_tipo_atividade1_idx", columns={"tipo_atividade_id"}), @ORM\Index(name="fk_certificado_tipo_funcao_funcao1_idx", columns={"funcao_id"}), @ORM\Index(name="fk_certificado_tipo_funcao_evento1_idx", columns={"evento_id"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Application\Entity\CertificadoTipoFuncaoEventoRepository")
 */
class CertificadoTipoFuncaoEvento
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="cadastrado_em", type="datetime", nullable=false)
     */
    private $cadastradoEm = 'CURRENT_TIMESTAMP';



    /**
     * @var Evento
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Evento")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="evento_id", referencedColumnName="id")
     * })
     */
    private $evento;

    /**
     * @var Funcao
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Funcao")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="funcao_id", referencedColumnName="id")
     * })
     */
    private $funcao;

    /**
     * @var ModeloCertificado
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="ModeloCertificado")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="modelo_certificado_id", referencedColumnName="id")
     * })
     */
    private $modeloCertificado;

    /**
     * @var TipoAtividade
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="TipoAtividade")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipo_atividade_id", referencedColumnName="id")
     * })
     */
    private $tipoAtividade;

    public function __construct(array $options = array())
    {
        (new ClassMethods())->hydrate($options, $this);
        $this->cadastradoEm = new \DateTime("now");
        $this->atualizadoEm = new \DateTime("now");
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
        // TODO: Implement __toString() method.
        return $this->getFuncao()->getNome() .'/'.$this->getTipoAtividade()->getNome().'/'.$this->getEvento()->getNome();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return \DateTime
     */
    public function getCadastradoEm()
    {
        return $this->cadastradoEm;
    }

    /**
     * @param \DateTime $cadastradoEm
     */
    public function setCadastradoEm($cadastradoEm)
    {
        $this->cadastradoEm = $cadastradoEm;
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
     * @return Funcao
     */
    public function getFuncao()
    {
        return $this->funcao;
    }

    /**
     * @param Funcao $funcao
     */
    public function setFuncao($funcao)
    {
        $this->funcao = $funcao;
    }

    /**
     * @return ModeloCertificado
     */
    public function getModeloCertificado()
    {
        return $this->modeloCertificado;
    }

    /**
     * @param ModeloCertificado $modeloCertificado
     */
    public function setModeloCertificado($modeloCertificado)
    {
        $this->modeloCertificado = $modeloCertificado;
    }

    /**
     * @return TipoAtividade
     */
    public function getTipoAtividade()
    {
        return $this->tipoAtividade;
    }

    /**
     * @param TipoAtividade $tipoAtividade
     */
    public function setTipoAtividade($tipoAtividade)
    {
        $this->tipoAtividade = $tipoAtividade;
    }


}

