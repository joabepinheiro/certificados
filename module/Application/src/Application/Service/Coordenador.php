<?php
namespace Application\Service;

use Base\Service\AbstractService;
use Doctrine\ORM\EntityManager;

class Coordenador extends AbstractService
{

    public function __construct(EntityManager $em)
    {
        parent::__construct($em);
        
        $this->entity = 'Application\Entity\Usuario';
    }

    public function getDataDashboard()
    {
        $result = array();

        $container = new \Zend\Session\Container('logado');
        $evento_selecionado = $container->offsetGet('evento_selecionado');

        $qb = $this->em->createQueryBuilder();


        if($container->offsetExists('evento_selecionado'))
        {
            // Total de total_participantes do evento selecionado
            $qb->select('count(DISTINCT participante.id) as total_participantes')
                ->from('Application\Entity\Participante', 'participante')
                ->from('Application\Entity\Participacao', 'participacao');
            $qb->andWhere('participante.id = participacao.participante');
            $qb->andWhere('participacao.evento = '.$evento_selecionado['id']);
            $query = $qb->getQuery();

            $result['total_participantes'] = $query->getSingleResult()['total_participantes'];

            // total_de_funcoes
            $qb = $this->em->createQueryBuilder();
            $qb->select('count(DISTINCT participacao.id) as total_de_participacoes')->from('Application\Entity\Participacao', 'participacao');
            $qb->andWhere('participacao.evento = '. $evento_selecionado['id']);
            $query = $qb->getQuery();
            $result['total_de_participacoes'] = $query->getSingleResult()['total_de_participacoes'];


            // Total usuarios
            $qb = $this->em->createQueryBuilder();
            $qb->select('count(atividade.id) as total_de_atividades')->from('Application\Entity\Atividade', 'atividade');
            $qb->andWhere('atividade.evento = '. $evento_selecionado['id']);
            $query = $qb->getQuery();

            $result['total_de_atividades'] = $query->getSingleResult()['total_de_atividades'];

            // Total de certificados emitidos
            $qb = $this->em->createQueryBuilder();
            $qb->select('count(DISTINCT participacao.id) as total_de_certificados_emitidos')->from('Application\Entity\Participacao', 'participacao');
            $qb->andWhere('participacao.evento = '. $evento_selecionado['id']);
            $qb->andWhere('participacao.dataUltimaEmissao  IS NOT NULL');
            $query = $qb->getQuery();
            $result['total_de_certificados_emitidos'] = $query->getSingleResult()['total_de_certificados_emitidos'];

            // Participantes do evento
            $qb = $this->em->createQueryBuilder();
            $qb->select('participacao')->from('Application\Entity\Participacao', 'participacao');
            $qb->andWhere('participacao.evento = '. $evento_selecionado['id']);
            $query = $qb->getQuery();

            $result['participacoes'] = $query->getResult();


            $container = new \Zend\Session\Container('logado');
            $usuario = $container->offsetGet('usuario');

            // Últimos eventos cadastrados
            $qb = $this->em->createQueryBuilder();
            $qb->select('evento')->from('Application\Entity\Evento', 'evento');
            $qb->where('evento.usuario = ?1');
            $qb->setParameter(1,  $usuario['id']);
            $query = $qb->getQuery();

            $result['eventos'] = $query->getResult();

        }

        return $result;
    }

    public function getDataDashboard2()
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

        // Total usuarios
        $qb = $this->em->createQueryBuilder();
        $qb->select('count(evento.id) as total_de_eventos')->from('Application\Entity\Evento', 'evento');
        $query = $qb->getQuery();

        $result['total_de_eventos'] = $query->getSingleResult()['total_de_eventos'];

        $container = new \Zend\Session\Container('logado');
        $usuario = $container->offsetGet('usuario');

        // Últimos eventos cadastrados
        $qb = $this->em->createQueryBuilder();
        $qb->select('evento')->from('Application\Entity\Evento', 'evento');
        $qb->where('evento.usuario = ?1');
        $qb->setParameter(1,  $usuario['id']);
        $query = $qb->getQuery();

        $result['eventos'] = $query->getResult();

        return $result;
    }
}

