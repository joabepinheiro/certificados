<?php
namespace Application\Service;

use Base\Service\AbstractService;
use Doctrine\ORM\EntityManager;

class Administrador extends AbstractService
{

    public function __construct(EntityManager $em)
    {
        parent::__construct($em);
        
        $this->entity = 'Application\Entity\Usuario';
    }

    public function getDataDashboard()
    {
        $result = array();
        
        // Total de total_participantes_cadastrados
        $qb = $this->em->createQueryBuilder();
        $qb->select('count(participante.id) as total_participantes')->from('Application\Entity\Participante', 'participante');
        $query = $qb->getQuery();
        
        $result['total_participantes'] = $query->getSingleResult()['total_participantes'];
        
        // total_de_funcoes
        $qb = $this->em->createQueryBuilder();
        $qb->select('count(funcao.id) as total_de_funcoes')->from('Application\Entity\Funcao', 'funcao');
        $query = $qb->getQuery();
        
        $result['total_de_funcoes'] = $query->getSingleResult()['total_de_funcoes'];
        
        // Total usuarios
        $qb = $this->em->createQueryBuilder();
        $qb->select('count(usuario.id) as total_de_usuarios')->from('Application\Entity\Usuario', 'usuario');
        $query = $qb->getQuery();
        
        $result['total_de_usuarios'] = $query->getSingleResult()['total_de_usuarios'];
        
        // Total os eventos
        $qb = $this->em->createQueryBuilder();
        $qb->select('count(evento.id) as total_de_eventos')->from('Application\Entity\Evento', 'evento');
        $query = $qb->getQuery();
        
        $result['total_de_eventos'] = $query->getSingleResult()['total_de_eventos'];
        
        // Últimos eventos cadastrados
        $qb = $this->em->createQueryBuilder();
        $qb->select('evento')->from('Application\Entity\Evento', 'evento');
        $query = $qb->getQuery();
        
        $result['eventos'] = $query->getResult();
        
        return $result;
    }
}

