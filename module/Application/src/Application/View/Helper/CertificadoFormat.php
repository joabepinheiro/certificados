<?php
namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;

class CertificadoFormat extends AbstractHelper
{

    public function __invoke($chave)
    {
        return substr($chave, 0, 4) . '-' . substr($chave, 4, 4) . '-' . substr($chave, 8, 4) . '-' . substr($chave, 12, 4);
    }
}


