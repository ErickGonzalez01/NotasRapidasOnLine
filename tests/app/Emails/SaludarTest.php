<?php 

use CodeIgniter\Test\CIUnitTestCase;
use App\Libraries\Emails\Saludo;
class SaludarTest extends CIUnitTestCase{

    public function testEnviarEsTrue(){
        $saludo = new Saludo("erickjoelg@gmail.com","Erick Gonzalez");
        $this->assertTrue($saludo->Enviar());
    }

}