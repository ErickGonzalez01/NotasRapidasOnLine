<?php 

namespace App\Libraries\Autenticacion\App;

use App\Libraries\Autenticacion\Interfaces\IObjetoJwt;
use App\Libraries\Autenticacion\Interfaces\IConfigJWT;
use App\Libraries\Autenticacion\Abstract\EnDeJwtBase;
use App\Libraries\Autenticacion\App\ObjetoJwt;

class EncodeJWT extends EnDeJwtBase{
    protected IConfigJWT $configuracion;
    protected IObjetoJwt $objeto_jwt;
    protected string|array $data;

    function __construct(IConfigJWT $configuracion, array $data, string $correo)
    {
        $this->data = $data;
        $this->objeto_jwt = new ObjetoJwt();
        $this ->configuracion = $configuracion;
        $this->configuracion->SetSub($correo);
    }
}