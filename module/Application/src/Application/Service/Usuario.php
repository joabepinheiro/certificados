<?php
namespace Application\Service;

use Base\Service\AbstractService;
use Doctrine\ORM\EntityManager;

class Usuario extends AbstractService
{

    public function __construct(EntityManager $em)
    {
        parent::__construct($em);
        
        $this->entity = 'Application\Entity\Usuario';
        $this->errorCodeValidator[1451] = 'Esse usuário é coordenador de um ou mais eventos e por isso não pode ser deletado, altere a coordenação desses eventos para remover esse usuário';
        $this->errorCodeValidator[1062] = 'Esse email já está sendo utilizado por outro usuário';
    }


    public function update($data)
    {
        if(empty($data['senha'])){
            unset($data['senha']);
        }
        return parent::update($data); // TODO: Change the autogenerated stub
    }


    /**
     * Envia os dados do usuário cadastrado para o email
     *
     * @param \Application\Entity\Usuario $usuario
     * @return bool|string
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public function enviarDadosDeAcesso(\Application\Entity\Usuario $usuario){

        //envia o emal
        $mail = new Mail();

        //Recipients
        $mail->setFrom('weekit.vdc@ifba.edu.br', 'Certificados Online - IFBA Vitória da Conquista');
        $mail->addAddress($usuario->getEmail(), $usuario->getLogin());

        //Attachments
        //$mail->addAttachment($path_file, $nome_do_arquivo);    // Optional name

        //Content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = 'Dados do usuário '. $usuario->getLogin();

        $mail->Body    = '<div style="margin:0;padding:30px 0;height:100%;width:100%;background-color:#f7f7f7; font-family:Helvetica,Arial,sans-serif;">
                <div style="width: 600px; border: 1px solid #ddd; color: #353334; margin:0 auto;">
                    <div style="background: #fff;">
                        <img src="http://certificados.ifba.edu.br/assets/layouts/layout4/img/logo-email.png" style="border:0;height:auto;line-height:100%; outline:none;text-decoration:none;max-width:180px;padding: 30px; margin: auto; display: block;">
                    </div>
                    <div style="color: #fff; background: #32a041; font-weight:bold; padding: 20px 0; font-size:23px;text-align: center;">
                        Dados de acesso
                    </div>	
                    <div style="padding: 30px; background: #fff;">
                        <table>
                            <tr>
                                <td style="font-weight: bold; padding: 5px 20px;">Usuário: </td>
                                <td> ' . $usuario->getLogin().' </td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold; padding: 5px 20px;">Email: </td>
                                <td> '. $usuario->getEmail().' </td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold; padding: 5px 20px;">Senha:</td>
                                <td> '. $usuario->getSenha().'</td>
                            </tr>
                            <tr>
                                <td  style="font-weight: bold; padding: 5px 20px;">Endereço</td>
                                <td>
                                 <a href="http://certificados.ifba.edu.br/">
                                  http://certificados.ifba.edu.br/
                                  </a>
                                </td>
                            </tr>
                        </table>
                    </div>		
                </div>
                </div>';

        try{
            if($mail->send()){
                return true;
            }else{
                return false;
            }
        }catch (\Exception $exception){
            return  false;
        }
    }

}
