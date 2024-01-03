<?php 

//Test 
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\ControllerTestTrait;
use CodeIgniter\Test\DatabaseTestTrait;

//Utilidades
use App\Controllers\ApiNotas;

class ApiNotasTest extends CIUnitTestCase {

    use ControllerTestTrait;
    use DatabaseTestTrait;

    public function testNewIsOK(){
        $result = $this->withUri("http://localhost:8080/api/user/notes/new")
        ->controller(ApiNotas::class)
        ->execute("new");
        print_r($result);
        $this->assertTrue($result->isOK());      
    }
    //public function test


}