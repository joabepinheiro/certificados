<?php
namespace Application\Entity;

use Doctrine\ORM\EntityRepository;

class TipoAtividadeRepository extends EntityRepository
{

    public function findAll()
    {
        return $this->findBy(array(), array('nome' => 'ASC'));
    }

    public function populateTiposAtividadesDoEvento(array $criteria){


        $qb = $this->_em->createQueryBuilder();
        $qb->select('tipo_atividade.id, tipo_atividade.nome, count(atividade.tipoAtividade) as tipoAtividade')
            ->from('Application\Entity\TipoAtividade', 'tipo_atividade')
            ->from('Application\Entity\Atividade', 'atividade');

        $qb->where("atividade.tipoAtividade = tipo_atividade.id");
        $qb->andWhere('atividade.evento = '.$criteria['evento_id']);
        $qb->groupBy("tipo_atividade.id");


        $query1 = $qb->getQuery();

        $array = $query1->getResult();


        $result = array();

        foreach ($array as $value){
            $result[$value['id']]= $value['nome']. ' ('. $value['tipoAtividade'].')';
        }

        return $result;
    }

}
