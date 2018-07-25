<?php
namespace Application\Service;

use Base\Service\AbstractService;
use Doctrine\ORM\EntityManager;
use Zend\Crypt\Key\Derivation\Pbkdf2;

class Participacao extends AbstractService
{

    public function __construct(EntityManager $em)
    {
        parent::__construct($em);
        
        $this->entity = 'Application\Entity\Participacao';
    }


    public function insert($data)
    {

        if($this->countBuscarParticipacao($data['participante_id'], $data['atividade_id']) == 0 ){

            $data['data_inicio']    = date('Y-m-d', strtotime($data['data_inicio']));
            $data['data_fim']       = date('Y-m-d', strtotime($data['data_fim']));


            $this->em->getConnection()->insert('participacao', $data);
            $id = $this->em->getConnection()->lastInsertId();

            return $this->em->getRepository($this->entity)->getParticipacao($id);
        }

        return array();
    }

    public function getParticipacao(\Application\Entity\Evento $evento)
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select('
                participacao
                ')
            ->from('Application\Entity\Atividade', 'atividade')
            ->from('Application\Entity\Evento', 'evento')
            ->from('Application\Entity\Participacao', 'participacao')
            ->from('Application\Entity\Participante', 'participante')
            ->from('Application\Entity\Funcao', 'funcao');
        
        $qb->andWhere('participacao.participante = participante.id');
        $qb->andWhere('participacao.atividade = atividade.id');
        $qb->andWhere('participacao.funcao = funcao.id');
        $qb->andWhere('evento.id = atividade.evento');
        $qb->andWhere('evento.id = ' . $evento->getId());
        
        $query = $qb->getQuery();
        
        return $query->getResult();
    }

    public function delete($id)
    {
        
        /** @var  $entity \Application\Entity\Participacao*/
        $entity = $this->em->getRepository($this->entity)->findOneBy($id);
        
        if ($entity) {
            $this->em->remove($entity);
            try {
                $this->em->flush();
            } catch (\Doctrine\DBAL\Exception\DriverException $exception) {
                return $this->exceptionMenssage($exception->getErrorCode(), $exception->getMessage());
            } catch (\Exception $exception) {
                
                return $this->exceptionMenssage($exception->getCode(), $exception->getMessage());
            }
            return $id;
        }
        return null;
    }

    /**
     * retorna a quantidade total de participações de um participante em uma determinada atividade
     *
     * @param $participante_id
     * @param $atividade_id
     * @return int
     */
    public function countBuscarParticipacao($participante_id, $atividade_id){
        $qb = $this->em->createQueryBuilder();
        $qb->select('count(participacao.id) as quantidade')
            ->from('Application\Entity\Participacao', 'participacao');

        $qb->andWhere('participacao.participante = '.$participante_id);
        $qb->andWhere('participacao.atividade = '.$atividade_id);
        $query = $qb->getQuery();

        return $query->getResult()[0]['quantidade'];
    }
}

