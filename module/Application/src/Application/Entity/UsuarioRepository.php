<?php
namespace Application\Entity;

use Doctrine\ORM\EntityRepository;

class UsuarioRepository extends EntityRepository
{

    function findByLoginSenha($login, $senha)
    {
        $usuario = $this->findOneBy(array(
            'login' => $login
        ));
        
        if (! is_null($usuario)) {
            $hashSenha = $usuario->encryptPassword($senha);
            
            if ($hashSenha == $usuario->getSenha()) {
                return $usuario;
            }
        }
        return false;
    }

    public function findCoordenadores()
    {
        return $this->_em->getRepository($this->_entityName)->findBy(array(
            'tipo' => 'Coordenador do Evento'
        ));
    }
}
