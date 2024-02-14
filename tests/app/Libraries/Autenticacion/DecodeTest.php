<?php

use CodeIgniter\Test\CIUnitTestCase;
use App\Libraries\Autenticacion\App\DecodeJWT;
use App\Libraries\Autenticacion\App\EncodeJWT;
use App\Libraries\Autenticacion\Config\AuthJWT;

class DecodeTest extends CIUnitTestCase{

    private $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwODAiLCJhdWQiOiJodHRwOi8vbG9jYWxob3N0OjUxNzMiLCJzdWIiOiJjb3JyZW8iLCJpYXQiOjE3MDc3NTE2NzgsIm5iZiI6MTcwNzc1MTY4MywiZXhwIjoxNzA3NzU1Mjc4LCJkYXRhIjpbImRhdGEiXX0.bo9R3UkR4iKYGI0--TVfP4URxB9YoWoGNDR-pP1ef8E';

    final public function testDecodificarToken(){
        $decode = new DecodeJWT(new AuthJWT,$this->token);
        $obj = $decode->Get();
        print_r($obj->getBody());

        $this->assertIsArray($obj->getBody());
    }

    /**
     * Prueba con token autentico.
     */
    final public function testDecodeError(){
        $decode = new DecodeJWT(new AuthJWT,$this->token);
        $obj = $decode->Get();
        print_r($obj->getError());

        $this->assertNull($obj->getError());
    }

    /**
     * Cuando el token es incalido.
     */
    final public function testDecodeErrorReturnString(){
        $decode = new DecodeJWT(new AuthJWT,$this->token.'dsd');
        $obj = $decode->Get();
        print_r($obj->getError());

        $this->assertIsString($obj->getError());
    }

    /**
     * Ciclode de vida del token encode y decode.
     */
    final public function testCodificarYDecodificarElToken(){
        $data = [
            "nombre" => "Juan Gonzalez"
        ];
    
        //Configuracion
        $configuracion = new AuthJWT();

        //------------------------------------------------------------
        //--  Encode
        //------------------------------------------------------------
        $encode = new EncodeJWT($configuracion,$data,"correo@correo.com");

        $token = $encode->Get();

        $stringToken = $token->getBody();
        //------------------------------------------------------------
        //--  Decode
        //------------------------------------------------------------
        $decode = new DecodeJWT($configuracion,$stringToken);

        $data1 = $decode->Get();

        $data11 = $data1->getBody();

        print_r((array)$data11["data"]);

        print_r($data);

        $this->assertEquals($data,(array)$data11["data"]);
        //$this->assertEquals()
        //$this->assertIsString("");
    }

}