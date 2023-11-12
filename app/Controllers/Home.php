<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Config\Services;

class Home extends BaseController
{
    public function index()//123-180375-0000U
    {
        helper("view");
        $session = Services::session();

        if($session->has("usuario")==false and $session->has("nombre")==false and $session->has("apellido")==false){
            //return redirect()->route("inicio");
            return redirect()->route("inicio");
        }

        //return view('inicio/inicio');
        return view("layout/header").view("layout/nav-bar").view("inicio/inicio").view("layout/footer");
    }
}
