<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Home extends BaseController
{
    public function index()//123-180375-0000U
    {
        helper("usuario");
        //return view('inicio/inicio');
        return view("layout/header").view("layout/nav-bar",["usuario_name"=>GetInfoUsuario()["nombre"]]).view("inicio/inicio").view("layout/footer");
    }
}
