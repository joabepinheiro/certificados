<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Hydrator\ClassMethods;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Participante
 *
 * @ORM\Table(name="participante", uniqueConstraints={@ORM\UniqueConstraint(name="CPF_UNIQUE", columns={"CPF"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Application\Entity\ParticipanteRepository")
 */
class Participante
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
     * @var string @ORM\Column(name="CPF", type="string", length=11, nullable=true)
     */
    private $cpf;

    /**
     *
     * @var string @ORM\Column(name="nome_completo", type="string", length=150, nullable=true)
     */
    private $nomeCompleto;

    /**
     *
     * @var \DateTime @ORM\Column(name="data_nascimento", type="date", nullable=true)
     */
    private $dataNascimento;

    /**
     *
     * @var string @ORM\Column(name="email", type="string", length=150, nullable=true)
     */
    private $email;

    /**
     *
     * @var string @ORM\Column(name="instituicao_ifba_vca", type="string", length=200, nullable=true)
     */
    private $instituicaoIfbaVca;

    public $verbose_name = 'Participante';

    public $verbose_name_plural = 'Participantes';

    /**
     *
     * @var ArrayCollection @ORM\OneToMany(targetEntity="Application\Entity\Participacao", mappedBy="participante", cascade={"persist", "remove"})
     */
    private $participacoes;

    public function __construct(array $options = array())
    {
        (new ClassMethods())->hydrate($options, $this);
        $this->participacoes = new ArrayCollection();
    }

    public function toArray()
    {
        return (new ClassMethods())->extract($this);
    }

    public function dataForm()
    {
        $data = (new ClassMethods())->extract($this);
        
        $data['cpf'] = substr($data['cpf'], 0, 3) . '.' . substr($data['cpf'], 3, 3) . '.' . substr($data['cpf'], 6, 3) . '-' . substr($data['cpf'], 9, 2);
        
        $data['data_nascimento'] = $data['data_nascimento']->format('d/m/Y');
        
        return $data;
    }

    public function __toString()
    {
        return $this->getNomeCompleto();
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
    public function getNomeCompleto()
    {
        return $this->nomeCompleto;
    }

    /**
     *
     * @param string $nomeCompleto
     */
    public function setNomeCompleto($nomeCompleto)
    {
        $this->nomeCompleto = strtoupper($nomeCompleto);
    }

    /**
     *
     * @return \DateTime
     */
    public function getDataNascimento()
    {
        return $this->dataNascimento;
    }

    /**
     *
     * @param \DateTime $dataNascimento
     */
    public function setDataNascimento($dataNascimento)
    {
        $this->dataNascimento = $dataNascimento;
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
        $this->email = strtolower($email);
    }

    /**
     *
     * @return string
     */
    public function getInstituicao()
    {
        return $this->instituicaoIfbaVca;
    }

    /**
     *
     * @param string $instituicaoIfbaVca
     */
    public function setInstituicao($instituicaoIfbaVca)
    {
        $this->instituicaoIfbaVca = $instituicaoIfbaVca;
    }

    /**
     * @return string
     */
    public function getInstituicaoIfbaVca()
    {
        return $this->instituicaoIfbaVca;
    }

    /**
     * @param string $instituicaoIfbaVca
     */
    public function setInstituicaoIfbaVca($instituicaoIfbaVca)
    {
        $this->instituicaoIfbaVca = $instituicaoIfbaVca;
    }



    /**
     *
     * @return ArrayCollection
     */
    public function getParticipacoes()
    {
        return $this->participacoes;
    }

    /**
     *
     * @param ArrayCollection $participacoes
     */
    public function setParticipacoes($participacoes)
    {
        $this->participacoes = $participacoes;
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
}

