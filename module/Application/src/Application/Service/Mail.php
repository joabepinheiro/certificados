<?php
namespace Application\Service;

use Base\Service\AbstractService;
use Doctrine\ORM\EntityManager;
use PHPMailer\PHPMailer\PHPMailer;

class Mail extends PHPMailer
{

    public function __construct()
    {
        parent::__construct(true);
        try {
            //Server settings
            $this->SMTPDebug =0;
            $this->CharSet = 'UTF-8';// Enable verbose debug output
            $this->isSMTP();                                      // Set mailer to use SMTP
            $this->Host = 'smtps.ifba.edu.br';  // Specify main and backup SMTP servers
            $this->SMTPAuth = true;                               // Enable SMTP authentication
            $this->Username = 'weekit.vdc@ifba.edu.br';                 // SMTP username
            $this->Password = '1W&!6@IT2&K0';                           // SMTP password
            $this->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
            $this->Port = 465;                                   // TCP port to connect to

            //Content
            $this->isHTML(true);

        } catch (\Exception $e) {
            echo 'Erro ao configurar o envio de email ', $this->ErrorInfo;die;
        }
    }
}

