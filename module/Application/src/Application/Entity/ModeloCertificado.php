<?php
namespace Application\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Zend\Hydrator\ClassMethods;

/**
 * ModeloCertificado
 *
 * @ORM\Table(name="modelo_certificado")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Application\Entity\ModeloCertificadoRepository")
 */
class ModeloCertificado
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=45, nullable=false)
     */
    private $nome;

    /**
     * @var string
     *
     * @ORM\Column(name="texto_frente", type="text", nullable=true)
     */
    private $textoFrente;

    /**
     * @var string
     *
     * @ORM\Column(name="descricao_frente", type="string", length=45, nullable=true)
     */
    private $descricaoFrente;

    /**
     * @var string
     *
     * @ORM\Column(name="estilo_container_texto_frente", type="text", length=65535, nullable=true)
     */
    private $estiloContainerTextoFrente;

    /**
     * @var string
     *
     * @ORM\Column(name="bg_frente", type="string", length=255, nullable=true)
     */
    private $bgFrente;

    /**
     * @var string
     *
     * @ORM\Column(name="texto_verso", type="text", nullable=true)
     */
    private $textoVerso;

    /**
     * @var string
     *
     * @ORM\Column(name="descricao_verso", type="string", length=45, nullable=true)
     */
    private $descricaoVerso;

    /**
     * @var string
     *
     * @ORM\Column(name="estilo_container_texto_verso", type="text", length=65535, nullable=true)
     */
    private $estiloContainerTextoVerso;

    /**
     * @var string
     *
     * @ORM\Column(name="bg_verso", type="string", length=255, nullable=true)
     */
    private $bgVerso;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo", type="string", nullable=false)
     */
    private $tipo = 'frente';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="cadastrado_em", type="datetime", nullable=false)
     */
    private $cadastradoEm;


    /**
     * ModeloCertificado constructor.
     * 
     * @param $options
     */


    /**
     * Collection com todos os certificados
     * @ORM\OneToMany(targetEntity="Application\Entity\CertificadoTipoFuncaoEvento", mappedBy="modeloCertificado")
     */
    private $certificadosTipoFuncaoEvento;

    public function __construct($options)
    {
        $this->cadastradoEm     = new \DateTime('now');
        $this->certificadosTipoFuncaoEvento = new ArrayCollection();

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

    /**
     * @return string
     */
    public function getTextoFrente()
    {
        return $this->textoFrente;
    }

    /**
     * @param string $textoFrente
     */
    public function setTextoFrente($textoFrente)
    {
        $this->textoFrente = $textoFrente;
    }

    /**
     * @return string
     */
    public function getDescricaoFrente()
    {
        return $this->descricaoFrente;
    }

    /**
     * @param string $descricaoFrente
     */
    public function setDescricaoFrente($descricaoFrente)
    {
        $this->descricaoFrente = $descricaoFrente;
    }

    /**
     * @return string
     */
    public function getEstiloContainerTextoFrente()
    {
        return $this->estiloContainerTextoFrente;
    }

    /**
     * @param string $estiloContainerTextoFrente
     */
    public function setEstiloContainerTextoFrente($estiloContainerTextoFrente)
    {
        $this->estiloContainerTextoFrente = $estiloContainerTextoFrente;
    }

    /**
     * @return string
     */
    public function getBgFrente()
    {
        return $this->bgFrente;
    }

    /**
     * @param string $bgFrente
     */
    public function setBgFrente($bgFrente)
    {
        $this->bgFrente = $bgFrente;
    }

    /**
     * @return string
     */
    public function getBgVerso()
    {
        return $this->bgVerso;
    }

    /**
     * @param string $bgVerso
     */
    public function setBgVerso($bgVerso)
    {
        $this->bgVerso = $bgVerso;
    }

    /**
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @param string $tipo
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
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
     * @return mixed
     */
    public function getCertificadosTipoFuncaoEvento()
    {
        return $this->certificadosTipoFuncaoEvento;
    }

    /**
     * @param mixed $certificadosTipoFuncaoEvento
     */
    public function setCertificadosTipoFuncaoEvento($certificadosTipoFuncaoEvento)
    {
        $this->certificadosTipoFuncaoEvento = $certificadosTipoFuncaoEvento;
    }

    /**
     * @return string
     */
    public function getTextoVerso()
    {
        return $this->textoVerso;
    }

    /**
     * @param string $textoVerso
     */
    public function setTextoVerso($textoVerso)
    {
        $this->textoVerso = $textoVerso;
    }

    /**
     * @return string
     */
    public function getDescricaoVerso()
    {
        return $this->descricaoVerso;
    }

    /**
     * @param string $descricaoVerso
     */
    public function setDescricaoVerso($descricaoVerso)
    {
        $this->descricaoVerso = $descricaoVerso;
    }

    /**
     * @return string
     */
    public function getEstiloContainerTextoVerso()
    {
        return $this->estiloContainerTextoVerso;
    }

    /**
     * @param string $estiloContainerTextoVerso
     */
    public function setEstiloContainerTextoVerso($estiloContainerTextoVerso)
    {
        $this->estiloContainerTextoVerso = $estiloContainerTextoVerso;
    }



}

