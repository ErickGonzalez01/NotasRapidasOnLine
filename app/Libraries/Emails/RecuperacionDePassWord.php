<?php

namespace App\Libraries\Emails;

use Config\Services;

use App\Libraries\Emails\IEmail;

class RecuperacionDePassWord implements IEmail{

    private $emailService;

    public function __construct(string $correo,string $nombre, string $clave)
    {
        $this->emailService = Services::email();

        $this->emailService->setTo($correo);
        $this->emailService->setSubject("Recuperacion de cuenta");
        $this->emailService->setMessage("Hola $nombre, ¿Estas teniendo problemas para acceder a tu cuenta?\n aqui tienes tu contraseña de un solo uso que has colicitado\n Contraseña de un solo uso: '$clave'");
    }
    public function Enviar():bool{
        return $this->emailService->send();
    }
}