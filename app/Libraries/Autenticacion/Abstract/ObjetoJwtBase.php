<?php 

namespace App\Libraries\Autenticacion\Abstract;
use App\Libraries\Autenticacion\Interfaces\IObjetoJwt;
use Exception;

class ObjetoJwtBase implements IObjetoJwt{
    protected $body;
    protected $error;
    
    final public function getBody(): string|array
    {
        if(is_array($this->body) || is_string($this->body)){
            return $this->body;
        }else{
            throw new Exception("Tipo de datos invalido 'string|array'.");
        }
        
    }

    final public function getError(): ?string
    {
        if(is_null($this->error) || is_string($this->error)){
            return $this->error;
        }
        throw new Exception("Tipo de datos invalido 'null|string'.");
    }
}