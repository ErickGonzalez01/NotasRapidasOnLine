<?php

use App\Libraries\Autenticacion\AutenticacionJWT;

function data(){
    $autentication = new AutenticacionJWT();
    $data = $autentication->GetDecode();
    return $data;
}


function GetInfoUsuario(){
    return data();
}

function idUsuario(){    
    return data()["id"];
}

function GetInfoUserName(){
    $usuario = [
        "nombre"=>data()["nombre"],
        "apellido"=>data()["apellido"]
    ];
    return $usuario;
}