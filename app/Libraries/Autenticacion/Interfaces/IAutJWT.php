<?php 

namespace App\Libraries\Autenticacion\Interfaces;
use App\Libraries\Autenticacion\Interfaces\IObjetoJwt;

Interface IAutJWT {
    public function Get():IObjetoJwt;
}