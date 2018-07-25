<?php
namespace Application\Entity;

use Doctrine\ORM\EntityRepository;

class AtividadeRepository extends EntityRepository
{

    public function getTituloAtividadesDoEvento(array $criteria)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('
                atividade.titulo 
                ')
            ->from('Application\Entity\Atividade', 'atividade')
            ->from('Application\Entity\Evento', 'evento');
        
        $qb->andWhere('atividade.evento = evento.id');
        $qb->andWhere('evento.id = ' . $criteria['evento']->getId());
        $qb->orderBy("atividade.titulo", "ASC");
        $query = $qb->getQuery();
        
        return $query->getResult();
    }



    /**
     * Retorna uma lista das atividades de um tipo
     * @return array
     */
    public function findAtividadesDoTipoDeAtividadePopulate($tipo_atividade_id, $evento_id)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('atividade.id, atividade.titulo')
            ->from('Application\Entity\Atividade', 'atividade');

        $qb->andWhere('atividade.evento = '.$evento_id);
        $qb->andWhere('atividade.tipoAtividade = '.$tipo_atividade_id);

        $qb->orderBy('atividade.titulo', 'ASC');

        $query = $qb->getQuery();

        $result = $query->getResult();

        return $result;
    }
}
