<?php
namespace Application\Service;


use PHPMailer\PHPMailer\PHPMailer;

class MailCertificado extends PHPMailer
{

    public function __construct()
    {
        parent::__construct(true);

        try {
            //Server settings
            $this->SMTPDebug = 0;
            $this->CharSet = 'UTF-8';// Enable verbose debug output
            $this->isSMTP();                                      // Set mailer to use SMTP
            $this->Host = 'smtps.ifba.edu.br';  // Specify main and backup SMTP servers
            $this->SMTPAuth = true;                               // Enable SMTP authentication
            $this->Username = 'weekit.vdc@ifba.edu.br';                 // SMTP username
            $this->Password = '1W&!6@IT2&K0';                           // SMTP password
            $this->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
            $this->Port = 465;                                     // TCP port to connect to

        } catch (\Exception $e) {

        }
    }
    
    /**
     * @param $from_address em
     * @param string $from_name
     * @param $subject
     * @param $body
     * @param array $address
     * @param array $replyTo
     * @param $attachment
     * @return bool
     */
    public function enviar($from_address, $from_name = '', $to_address, $to_name = '',  $subject, $body,  array $address, array $replyTo = array(), $attachment){
        try {

            $this->addAddress($to_address, $to_name);     // Add a recipie

            //Recipients
            $this->setFrom($from_address, $from_name);

            foreach ($address as $value){
                $this->addReplyTo($value['address'], isset($value['name']) ? $value['name'] : '');
            }

            if(empty($replyTo)){
                foreach ($replyTo as $value){
                    $this->addReplyTo($value['address'], $value['name']);
                }
            }

            //Attachments
            $this->addAttachment($attachment);

            //Content
            $this->isHTML(true);                                  // Set email format to HTML
            $this->Subject = $subject;
            $this->Body    = $body;

            $this->send();
            return true;
        } catch (\Exception $e) {
           // echo 'Message could not be sent. Mailer Error: ', $this->ErrorInfo;
            return false;
        }
    }
}

