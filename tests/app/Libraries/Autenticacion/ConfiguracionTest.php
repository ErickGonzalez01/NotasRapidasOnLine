<?php

use CodeIgniter\Test\CIUnitTestCase;
use App\Libraries\Autenticacion\Config\AuthJWT;

class ConfiguracionTest extends CIUnitTestCase{

    final public function testGetPayload(){
        $config = new AuthJWT();
        $data=[
            "uno"=>"dos"
        ];

        $datos = $config->GetPayload($data);

        print_r($datos);

        $this->assertIsArray($datos);
    }

    final public function testGetKey(){
        $config = new AuthJWT();
        print_r($config->GetKey());
        $this->assertIsString($config->GetKey());
    }

    final public function testGetFirma(){
        $config = new AuthJWT();
        print_r($config->GetFirma());
        $this->assertIsString($config->GetFirma());
    }

    final public function testSetSub(){
        $config = new AuthJWT();
        $config->setSub("correo@example.com");
        print_r($config->GetPayload(["data"]));
        $this->assertIsArray($config->GetPayload(["data"]));
    }
}