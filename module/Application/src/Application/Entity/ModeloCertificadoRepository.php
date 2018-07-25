<?php
namespace Application\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;

class ModeloCertificadoRepository extends EntityRepository
{
    public function getModelosDoEvento($evento_id)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('modelo_certificado')
            ->from('Application\Entity\ModeloCertificado', 'modelo_certificado')
            ->from('Application\Entity\CertificadoTipoFuncaoEvento', 'certificado_tipo_funcao_evento');

        $qb->andWhere('modelo_certificado.id = certificado_tipo_funcao_evento.modeloCertificado');
        $qb->andWhere('certificado_tipo_funcao_evento.evento = '.$evento_id);
        $qb->orderBy('modelo_certificado.nome', 'ASC');
        $qb->distinct();

        $query = $qb->getQuery();
        $result = $query->getResult();

        return $result;
    }

    public function populateTodosModelos(){

        $qb = $this->_em->createQueryBuilder();
        $qb->select('modelo_certificado.id as id, modelo_certificado.nome as nome')
            ->from('Application\Entity\ModeloCertificado', 'modelo_certificado');

        $query1 = $qb->getQuery();

        $array = $query1->getResult();

        $result = array();

        foreach ($array as $value){
            $result[$value['id']]= $value['nome'];
        }

        return $result;
    }
}
