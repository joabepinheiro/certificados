<?php
namespace Application\View\Helper;

use Doctrine\ORM\EntityManager;
use Zend\View\Helper\AbstractHelper;

class podeGerarCertificado extends AbstractHelper
{

    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function __invoke($id)
    {
        var_dump('tetst');
        die();
        // return substr($cpf, 0,3).'.'.substr($cpf, 3,3).'.'.substr($cpf, 6,3).'-'.substr($cpf, 9,2);
    }
}