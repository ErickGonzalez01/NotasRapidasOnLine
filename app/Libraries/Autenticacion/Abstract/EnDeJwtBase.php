<?php

namespace App\Libraries\Autenticacion\Abstract;
use App\Libraries\Autenticacion\Interfaces\IAutJWT;
use App\Libraries\Autenticacion\Interfaces\IConfigJWT;
use App\Libraries\Autenticacion\Interfaces\IObjetoJwt;
//use App\Libraries\Autenticacion\App\ObjetoJwt;

use Firebase\JWT\JWT;
use Firebase\JWT\JWK;
use Firebase\JWT\Key;

use Firebase\JWT\SignatureInvalidException;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;
use DomainException;
use Exception;
use InvalidArgumentException;
use UnexpectedValueException;

abstract class EnDeJwtBase implements IAutJWT{
    protected IConfigJWT $configuracion;
    protected IObjetoJwt $objeto_jwt;
    protected string|array $data;

    private function Type(string|array $data){
        if(is_string($data)){
            $this->decode();
        }

        if(is_array($data)){
            $this->encode();
        }

    }

    private function decode(){
        try {

            $jwt = JWT::decode($this->data,new key($this->configuracion->GetKey(),$this->configuracion->GetFirma()));
            $this->objeto_jwt->SetBody((array)$jwt);
        }catch (InvalidArgumentException $e) {
            $this->objeto_jwt->SetError("La clave/matriz de claves proporcionada está vacía o mal formada.");
        }catch (DomainException $e) {
            $this->objeto_jwt->SetError("El algoritmo proporcionado no es compatible O\nLa clave proporcionada no es válida O\nError desconocido arrojado en openSSL o libsodium O\nSe requiere libsodio pero no está disponible.");
        }catch (SignatureInvalidException $e) {
            $this->objeto_jwt->SetError("La verificación de la firma JWT haya fallado.");
        }catch (BeforeValidException $e) {
            $this->objeto_jwt->SetError("Siempre que JWT esté intentando usarse antes del reclamo 'nbf' O\nSiempre que JWT esté intentando usarse antes del reclamo 'iat'.");
        }catch (ExpiredException $e) {
            $this->objeto_jwt->SetError("siempre que JWT esté intentando usarse después del reclamo 'exp'.");
        }catch (UnexpectedValueException $e) {
            $this->objeto_jwt->SetError("Siempre que JWT tenga un formato incorrecto O\nSiempre que a JWT le falte un algoritmo / use un algoritmo no compatible O\nEl algoritmo JWT proporcionado no coincide con la clave proporcionada O\nEl ID de clave proporcionado en clave/matriz de claves está vacío o no es válido.");
        }
    }

    private function encode(){
        $jwt = JWT::encode($this->configuracion->GetPayload($this->data),$this->configuracion->GetKey(),$this->configuracion->GetFirma());
        $this->objeto_jwt->SetBody($jwt);
    }

    public function Get():IObjetoJwt{
        $this->Type($this->data);
        return $this->objeto_jwt;
    }
}