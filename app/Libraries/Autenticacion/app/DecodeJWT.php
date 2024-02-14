<?php

namespace App\Libraries\Autenticacion\App;

use App\Libraries\Autenticacion\Abstract\EnDeJwtBase;
use App\Libraries\Autenticacion\Interfaces\IConfigJWT;
use App\Libraries\Autenticacion\Interfaces\IObjetoJwt;
use App\Libraries\Autenticacion\App\ObjetoJwt;

class DecodeJWT extends EnDeJwtBase{

    protected IConfigJWT $configuracion;
    protected IObjetoJwt $objeto_jwt;
    protected string|array $data;

    public function __construct(IConfigJWT $configuracion, string $data)
    {
        $this->configuracion = $configuracion;
        $this->objeto_jwt = new ObjetoJwt;
        $this->data = $data;
    }

}