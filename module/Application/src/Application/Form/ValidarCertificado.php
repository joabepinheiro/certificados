<?php
namespace Application\Form;

use Base\Form\FormAbstract;
use Zend\Form\Element;
use Zend\Form\Element\Csrf;

class ValidarCertificado extends FormAbstract
{

    public function __construct($_name = 'Salvar')
    {
        parent::__construct($_name);
        $this->setAttribute('enctype', "multipart/form-data");
        
        $this->setInputFilter((new Filter\ValidarCertificado())->getInputFilter());
        
        $chave = new Element\Text('chave');
        $chave->setLabel('Chave')->setAttributes(array(
            'placeholder' => 'Informe aqui o código de registro do certificado',
            'class' => 'form-control',
            'required' => 'required',
            'id' => 'chave'
        ));
        $this->add($chave);

        $captcha = new Element\Captcha('captcha');
        $captcha->setCaptcha(new \Zend\Captcha\ReCaptcha(array(
            'secret_key' => '6LfFeUYUAAAAAJKojud7UOaVuF2MK8ywV7DnH8gK',
            'site_key' => '6LfFeUYUAAAAAIDyKbMbhGxNGdvzw74Aa375qR7S',
        )));
        $this->add($captcha);
        

        
        $submit = new Element\Submit('submit');
        $this->add($submit);
    }

    public function editingMode()
    {}
}