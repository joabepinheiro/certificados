<?php
namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;

class CPF extends AbstractHelper
{

    public function __invoke($cpf)
    {
        return substr($cpf, 0, 3) . '.' . substr($cpf, 3, 3) . '.' . substr($cpf, 6, 3) . '-' . substr($cpf, 9, 2);
    }
}