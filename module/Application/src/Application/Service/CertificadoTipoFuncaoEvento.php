<?php
namespace Application\Service;

use Base\Service\AbstractService;
use Doctrine\ORM\EntityManager;
use Zend\Mvc\Controller\Plugin\FlashMessenger;

class CertificadoTipoFuncaoEvento extends AbstractService
{
    public function __construct(EntityManager $em)
    {
        parent::__construct($em);
        
        $this->entity = 'Application\Entity\CertificadoTipoFuncaoEvento';
    }

    public function insert($data)
    {
        /** @var  $entity \Application\Entity\ModeloCertificado */
        $modelo         = (new ModeloCertificado($this->em))->insert($data);
        $data['modelo'] = $modelo->getId();

        return $this->insert_criterios($data);
    }

    protected function insert_criterios($data)
    {
        $return = array();
        $return['inserts'] = 0;
        $return['message'] = array();

        if(isset($data['tiposAtividade']))
        {
            for($x=0; $x < count($data['tiposAtividade']); $x++) {
                try{
                    if($this->em->getRepository($this->entity)->countCriterioNoEvento($data['evento'], $data['tiposAtividade'][$x], $data['funcoes'][$x]) == 0){
                        $this->em->getConnection()->insert('certificado_tipo_funcao_evento', array(
                            'modelo_certificado_id' => $data['modelo'],
                            'evento_id'             => $data['evento'],
                            'tipo_atividade_id'     => $data['tiposAtividade'][$x],
                            'funcao_id'             => $data['funcoes'][$x]
                        ));

                        $return['inserts']++;
                    }else{
                        $atividade              = $this->em->getRepository('Application\Entity\TipoAtividade')->find($data['tiposAtividade'][$x]);
                        $funcao                 = $this->em->getRepository('Application\Entity\Funcao')->find($data['funcoes'][$x]);
                        $return['message'][]    = "O critério ".$atividade.'/'.$funcao.' já está  sendo utilizado em um modelo';
                    }

                }catch (\Exception $exception){
                    echo $exception->getMessage();die;
                }
            }
        }

        return $return;
    }

    public function update($data)
    {
        /** @var  $modelo \Application\Entity\ModeloCertificado */
        (new ModeloCertificado($this->em))->update($data);

        try{
            $this->em->getConnection()->delete('certificado_tipo_funcao_evento', array(
                'modelo_certificado_id' => $data['id'],
                'evento_id'             => $data['evento']
            ));
        }catch (\Exception $exception){
            echo $exception->getMessage();die;
        }
        $data['modelo'] =  $data['id'];
        return $this->insert_criterios($data);
    }

    /**
     * deleta todos os critérios de um modelo em um determinado evento
     * @param $modelo_certificado_id
     * @param $evento_id
     * @return int
     */
    public function deletar_criterios($modelo_certificado_id, $evento_id)
    {
        try{
            return $this->em->getConnection()->delete('certificado_tipo_funcao_evento', array(
                'modelo_certificado_id' => $modelo_certificado_id,
                'evento_id'             => $evento_id,
            ));
        }catch (\Exception $exception){
            return 0;
        }
    }
}

