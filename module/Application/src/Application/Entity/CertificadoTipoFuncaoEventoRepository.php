<?php
namespace Application\Entity;

use Doctrine\ORM\EntityRepository;

class CertificadoTipoFuncaoEventoRepository extends EntityRepository
{

    public function getAtividadesDoEvento(array $criteria)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('
                atividade  
                ')
            ->from('Application\Entity\Atividade', 'atividade')
            ->from('Application\Entity\Evento', 'evento');

        $qb->andWhere('atividade.evento = evento.id');
        $qb->andWhere('evento.id = ' . $criteria['evento']->getId());
        $qb->orderBy("atividade.titulo", "ASC");

        $query = $qb->getQuery();

        return $query->getResult();
    }


    public function countCriterioNoEvento($evento_id, $tipo_atividade_id, $funcao_id)
    {

        $qb = $this->_em->createQueryBuilder();
        $qb->select('count(certificadoTipoFuncaoEvento.id) as total')
            ->from('Application\Entity\CertificadoTipoFuncaoEvento', 'certificadoTipoFuncaoEvento');


        $qb->andWhere('certificadoTipoFuncaoEvento.evento = ' . $evento_id);
        $qb->andWhere('certificadoTipoFuncaoEvento.tipoAtividade = ' . $tipo_atividade_id);
        $qb->andWhere('certificadoTipoFuncaoEvento.funcao = ' . $funcao_id);


        $query = $qb->getQuery();

        return $query->getResult()[0]['total'];
    }

}
