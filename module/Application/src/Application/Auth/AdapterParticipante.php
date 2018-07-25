<?php
namespace Application\Auth;

use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Result;
use Doctrine\ORM\EntityManager;

class AdapterParticipante implements AdapterInterface
{

    protected $em;

    protected $cpf;

    protected $data_nascimento;

    function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function authenticate()
    {
        /** @var $repository \Application\Entity\ParticipanteRepository*/
        $repository = $this->em->getRepository('Application\Entity\Participante');
        $usuario = $repository->findByCpfDataNascimento($this->getCpf(), $this->getDataNascimento());
        
        /** @var $usuario \Application\Entity\Participante*/
        if ($usuario) {
            return new Result(Result::SUCCESS, $usuario, array());
        }
        return new Result(Result::FAILURE_CREDENTIAL_INVALID, null, array(
            'O CPF ou data de nascimento estão incorretos'
        ));
    }

    /**
     *
     * @return EntityManager
     */
    public function getEm()
    {
        return $this->em;
    }

    /**
     *
     * @param EntityManager $em
     */
    public function setEm($em)
    {
        $this->em = $em;
    }

    /**
     *
     * @return mixed
     */
    public function getCpf()
    {
        return $this->cpf;
    }

    /**
     *
     * @param mixed $cpf
     */
    public function setCpf($cpf)
    {
        $this->cpf = $cpf;
    }

    /**
     *
     * @return \DateTime
     */
    public function getDataNascimento()
    {
        return $this->data_nascimento;
    }

    /**
     *
     * @param mixed $data_nascimento
     */
    public function setDataNascimento($data_nascimento)
    {
        $ano = substr($data_nascimento, 6, 4);
        $mes = substr($data_nascimento, 3, 2);
        $dia = substr($data_nascimento, 0, 2);
        
        $datetime = new \DateTime();
        $datetime->setDate($ano, $mes, $dia);
        
        $this->data_nascimento = $datetime;
    }
}