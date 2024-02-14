<?php 

namespace App\Libraries\Autenticacion\App;
use App\Libraries\Autenticacion\Abstract\ObjetoJwtBase;

class ObjetoJwt extends ObjetoJwtBase{
    protected $body;
    protected $error;

    public function SetError(string $error){
        $this->error = $error;
    }

    public function SetBody(array|string $body){
        $this->body=$body;
    }
}