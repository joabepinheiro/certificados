<?php
namespace Application\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

class ParticipacaoRepository extends EntityRepository
{

    public function getParticipacoes(Evento $evento)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('
                participante.id as participante_id,
                participante.nomeCompleto as participante_nome_completo,
                participante.dataNascimento as participante_data_nascimento,
                participante.email as participante_email,
                participante.cpf as participante_cpf,
                
                participacao.id as participacao_id,
                participacao.cargaHoraria as participacao_carga_horaria,
                participacao.ordem as participacao_ordem,
                participacao.dataInicio as participacao_data_inicio,
                participacao.dataFim as participacao_data_fim,
                participacao.emailEnviadoEm as email_enviado_em,
                participacao.dataUltimaEmissao as data_ultima_emissao,
                
                atividade.id as atividade_id,
                atividade.titulo as atividade_titulo,
                tipo_atividade.nome as atividade_tipo,  
                atividade.cargaHoraria as atividade_carga_horaria,
                
                funcao.id as funcao_id,
                funcao.nome as funcao_nome_funcao,
                
                evento.nome as evento_nome,
                evento.dataInicial as evento_data_inicial,
                evento.dataFinal as evento_data_final
   
                ')
            ->from('Application\Entity\Atividade', 'atividade')
            ->from('Application\Entity\TipoAtividade', 'tipo_atividade')
            ->from('Application\Entity\Evento', 'evento')
            ->from('Application\Entity\Participacao', 'participacao')
            ->from('Application\Entity\Participante', 'participante')
            ->from('Application\Entity\Funcao', 'funcao');
        
        $qb->andWhere('participacao.participante = participante.id');
        $qb->andWhere('participacao.atividade = atividade.id');
        $qb->andWhere('tipo_atividade.id = atividade.tipoAtividade');
        $qb->andWhere('participacao.funcao = funcao.id');
        $qb->andWhere('atividade.evento = evento.id');
        $qb->andWhere('evento.id = ' . $evento->getId());
        
        $query = $qb->getQuery();
        
        return $query->getResult();
    }

    public function getParticipacao($participacao_id)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('
                participante.id as participante_id,
                participante.nomeCompleto as participante_nome_completo,
                participante.dataNascimento as participante_data_nascimento,
                participante.email as participante_email,
                participante.cpf as participante_cpf,
                
                participacao.id as participacao_id,
                participacao.cargaHoraria as participacao_carga_horaria,
                participacao.ordem as participacao_ordem,
                participacao.dataInicio as participacao_data_inicio,
                participacao.dataFim as participacao_data_fim,
                
                atividade.id as atividade_id,
                atividade.titulo as atividade_titulo,
                tipo_atividade.nome as atividade_tipo, 
                atividade.cargaHoraria as atividade_carga_horaria,
                
                funcao.id as funcao_id,
                funcao.nome as funcao_nome_funcao,
                
                evento.nome as evento_nome,
                evento.dataInicial as evento_data_inicial,
                evento.dataFinal as evento_data_final
   
                ')
            ->from('Application\Entity\Atividade', 'atividade')
            ->from('Application\Entity\TipoAtividade', 'tipo_atividade')
            ->from('Application\Entity\Evento', 'evento')
            ->from('Application\Entity\Participacao', 'participacao')
            ->from('Application\Entity\Participante', 'participante')
            ->from('Application\Entity\Funcao', 'funcao');
        
        $qb->andWhere('participacao.participante = participante.id');
        $qb->andWhere('participacao.atividade = atividade.id');
        $qb->andWhere('tipo_atividade.id = atividade.tipoAtividade');
        $qb->andWhere('participacao.funcao = funcao.id');
        $qb->andWhere('atividade.evento = evento.id');
        $qb->andWhere('participacao.id = ' . $participacao_id);
        
        $query = $qb->getQuery();
        
        return $query->getResult();
    }

    /**
     * Retorna todos os participantes que não estão no evento informado no parametro
     * 
     * @return array de Participante
     *        
     */
    public function getNaoParticipacoes($evento_id)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('participante.id')
            ->from('Application\Entity\Atividade', 'atividade')
            ->from('Application\Entity\Evento', 'evento')
            ->from('Application\Entity\Participacao', 'participacao')
            ->from('Application\Entity\Participante', 'participante');
        
        $qb->andWhere('participacao.participante = participante.id');
        $qb->andWhere('participacao.atividade = atividade.id');
        $qb->andWhere('atividade.evento = evento.id');
        $qb->andWhere('evento.id = ' . $evento_id);
        
        // quem participou
        $query1 = $qb->getQuery();
        $result1 = $query1->getResult();
        
        $result1 = array_column($result1, 'id');
        
        $qb = $this->_em->createQueryBuilder();
        $qb->select('participante')->from('Application\Entity\Participante', 'participante');
        
        if (! empty($result1)) {
            $qb->where($qb->expr()
                ->notIn('participante.id', $result1));
        }
        $query = $qb->getQuery();
        
        return $query->getResult();
    }

    /**
     * Retorna todos os participantes
     * */
    public function getTodosOsParticipantes()
    {

        $qb = $this->_em->createQueryBuilder();
        $qb->select('participante')->from('Application\Entity\Participante', 'participante');

        $query = $qb->getQuery();

        return $query->getResult();
    }


    /**
     *
     * @param Evento $evento
     * @return array Participacao
     */
    public function getParticipantes(Evento $evento)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('participacao')
            ->from('Application\Entity\Atividade', 'atividade')
            ->from('Application\Entity\Evento', 'evento')
            ->from('Application\Entity\Participacao', 'participacao')
            ->from('Application\Entity\Participante', 'participante');

        $qb->andWhere('participacao.participante = participante.id');
        $qb->andWhere('participacao.atividade = atividade.id');
        $qb->andWhere('atividade.evento = evento.id');
        $qb->andWhere('evento.id = ' . $evento->getId());

        // quem participou
        $query1 = $qb->getQuery();
        return $query1->getResult();
    }

    public function getNaoParticipantes(Evento $evento)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('participante.id')
            ->from('Application\Entity\Atividade', 'atividade')
            ->from('Application\Entity\Evento', 'evento')
            ->from('Application\Entity\Participacao', 'participacao')
            ->from('Application\Entity\Participante', 'participante');
        
        $qb->andWhere('participacao.participante = participante.id');
        $qb->andWhere('participacao.atividade = atividade.id');
        $qb->andWhere('atividade.evento = evento.id');
        $qb->andWhere('evento.id = ' . $evento->getId());
        
        // quem participou
        $query1 = $qb->getQuery();
        $result1 = $query1->getResult();
        
        $result1 = array_column($result1, 'id');
        
        $qb = $this->_em->createQueryBuilder();
        $qb->select('participante.id as participante_id', 'participante.nomeCompleto as participante_nome_completo', 'participante.cpf as participante_cpf', 'participante.email as participante_email', 'participante.instituicao as participante_instituicao', 'participante.dataNascimento as participante_data_nascimento')->from('Application\Entity\Participante', 'participante');
        
        if (! empty($result1)) {
            $qb->where($qb->expr()
                ->notIn('participante.id', $result1));
        }
        $query = $qb->getQuery();
        
        return $query->getResult();
    }

    public function getParticipante($participante_id)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('participante.id as participante_id', 'participante.nomeCompleto as participante_nome_completo', 'participante.cpf as participante_cpf', 'participante.email as participante_email', 'participante.dataNascimento as participante_data_nascimento')->from('Application\Entity\Participante', 'participante');
        
        $qb->andWhere('participante.id = ' . $participante_id);
        
        $query = $qb->getQuery();
        
        return $query->getResult();
    }

    public function getParticipacaoParticipanteNoEvento($cpf, $evento_id)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('participacao')
            ->from('Application\Entity\Atividade', 'atividade')
            ->from('Application\Entity\Evento', 'evento')
            ->from('Application\Entity\Participacao', 'participacao')
            ->from('Application\Entity\Participante', 'participante');
        
        $qb->andWhere('participacao.participante = participante.id');
        $qb->andWhere('participacao.atividade = atividade.id');
        $qb->andWhere('atividade.evento = evento.id');
        $qb->andWhere('evento.id = ' . $evento_id);
        $qb->andWhere('participante.cpf = ' . $cpf);
        
        $query1 = $qb->getQuery();
        
        return $query1->getResult();
    }
}
