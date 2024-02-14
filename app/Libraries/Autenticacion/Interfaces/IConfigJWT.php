<?php 

namespace App\Libraries\Autenticacion\Interfaces;

Interface IConfigJWT {

    public function GetPayload(array $data):array;

    public function GetKey():string;
}