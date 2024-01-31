<?php 

namespace App\Controllers\Documentacion;

use App\Controllers\BaseController;

class Documentacion extends BaseController{
    public function index(){
        return view("doc/notas");
    }
    public function css(string $segment=""){
        return view("doc/css/$segment.css");
    }
    public function js($segment){
        return view("doc/js/$segment.js");
    }
    
}