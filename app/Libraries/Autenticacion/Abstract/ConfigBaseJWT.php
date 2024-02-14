<?php

namespace App\Libraries\Autenticacion\Abstract;
use App\Libraries\Autenticacion\Interfaces\IConfigJWT;
use Exception;

class ConfigBaseJWT implements IConfigJWT{
    
    /**
     * Emisor del token
     * 'example.com'
     * @var string
     */
    protected $iss = "";

     /**
     * Audiencia, aquien va dirigido el token
     * 'example.com'
     * @var string
     */
    protected $aud = "";

    /**
     * Marca de tiempo en que fue emitido el token
     * @var int
     */
    protected $iat = 0;

    /**
     * Tiempo del token hasta que se valido, es decir el token sera valido despues
     * de un periodo de tiempo despues de haberse creado en segundos.
     * @var int
     */
    protected $nbf = 0;

    /**
     * Timepo de valides del token en segundos
     * @var int
     */
    protected $exp = "";

    /**
     * Identidad del usuario el correo electronico
     * 'usuario@example.com'
     * @var string
     */
    protected $sub = "";

    /**
     * Firma para jwt
     */
    protected $algoritmo_simetrico='';

    function __construct()
    {
        $this->iat = time();
    }
    final Public function GetPayload(array $data): array
    {
        $payload = [
            "iss"   =>  $this->iss,
            "aud"   =>  $this->aud,
            "sub"   =>  $this->sub,
            "iat"   =>  $this->iat,
            "nbf"   =>  $this->iat + $this->nbf,
            "exp"   =>  $this->iat + $this->exp,
            "data"  =>  $data
        ];
        return $payload;
    }

    final public function setSub(string $correo){
        $this->sub = $correo;
    }

    final public function GetKey(): string
    {
        $key = getenv("JwtKey");

        if($key == null || is_array($key)){
            throw new Exception("JwtKey no es valido en el 'env' documento.");
        }

        return $key;
    }

    final public function GetFirma():string
    {
        if(is_string($this->algoritmo_simetrico)){
            return $this->algoritmo_simetrico;
        }
        throw new Exception("Datos invalidos en 'algoritmo_simetrico'");
    }
}