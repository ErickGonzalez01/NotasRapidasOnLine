<?php 

namespace App\Controllers\Documentacion;

use CodeIgniter\Debug\Toolbar\Collectors\BaseCollector;

class Documentacion extends BaseCollector{
    public function index(){
        return view("doc/notas");
    }
    
}