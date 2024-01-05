<?php

namespace App\Libraries\Emails;

use Config\Services;

use App\Libraries\Emails\IEmail;

class Saludo implements IEmail{

    private $emailServise;

    public function __construct(string $correo,string $nombre)
    {
        $this->emailServise = Services::email();

        $this->emailServise->setSubject("Te has registrado con exito");
        $this->emailServise->setTo($correo);
        $this->emailServise->setMessage("Hola $nombre, gracias por registrarte");
    }
    public function Enviar():bool{        
        return $this->emailServise->send();
    }
}