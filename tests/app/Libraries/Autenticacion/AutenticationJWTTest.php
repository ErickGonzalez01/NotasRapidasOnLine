<?php

use CodeIgniter\Test\CIUnitTestCase;
use App\Libraries\Autenticacion\AutenticacionJWT;

class AutenticatioJWTTest extends CIUnitTestCase{
    
    final public function testDecode(){
        header("Autorization: Beare jhrhefiefhiwuofwefhjhewfwe");
        $autentication = new AutenticacionJWT();
        $data = $autentication->GetDecode()->getBody();

        print_r($data);

        $this->assertIsString($data);
    }
}