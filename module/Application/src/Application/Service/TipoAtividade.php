<?php
namespace Application\Service;

use Base\Service\AbstractService;
use Doctrine\ORM\EntityManager;

class TipoAtividade extends AbstractService
{

    public function __construct(EntityManager $em)
    {
        parent::__construct($em);
        
        $this->entity = 'Application\Entity\TipoAtividade';
        $this->errorCodeValidator = [
            1451 => 'Para excluir esse tipo de atividade você deverá excluir todas as  atividades a ele vinculado'
        ];
    }
}

