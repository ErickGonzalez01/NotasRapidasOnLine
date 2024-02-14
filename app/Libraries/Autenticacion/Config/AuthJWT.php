<?php

namespace App\Libraries\Autenticacion\Config;
use App\Libraries\Autenticacion\Abstract\ConfigBaseJWT;

class AuthJWT extends ConfigBaseJWT{

    /**
     * Emisor del token
     * 'example.com'
     * @var string
     */
    protected $iss = "http://localhost:8080";

    /**
     * Audiencia, aquien va dirigido el token
     * 'example.com'
     * @var string
     */
    protected $aud = "http://localhost:5173";

    /**
     * Tiempo del token hasta que se valido, es decir el token sera valido despues
     * de un periodo de tiempo despues de haberse creado en segundos.
     * @var int
     */
    protected $nbf = 0;

    /**
     * Tiempo de valides del token en segundos
     * @var int
     */
    protected $exp = 3600;

    /**
     * Firma para jwt
     */
    protected $algoritmo_simetrico = 'HS256';

}