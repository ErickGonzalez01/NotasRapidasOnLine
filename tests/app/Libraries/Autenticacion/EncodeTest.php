<?php

use CodeIgniter\Test\CIUnitTestCase;
//use App\Libraries\Autenticacion\App\
use App\Libraries\Autenticacion\App\EncodeJWT;
use App\Libraries\Autenticacion\Config\AuthJWT;
class EncodeTest extends CIUnitTestCase{

    final public function testGetEncodeJWT(){
        $encode = new EncodeJWT(new AuthJWT(),["data"],"correo");
        $code = $encode->Get();
        print_r($code->getBody());

        $this->assertIsString($code->getBody());
    }

    final public function testGetEncodeErrror(){
        $encode = new EncodeJWT(new AuthJWT(),["data"],"correo");
        $code = $encode->Get();
        print_r($code->getBody());
        $this->assertNull($code->getError());
    }

}