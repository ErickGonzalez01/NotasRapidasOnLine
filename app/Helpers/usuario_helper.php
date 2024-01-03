<?php

use Config\Services;

function GetInfoUsuario(){
    $service = Services::session();

    $usuario = [
        "id"=>$service->get("id"),
        "usuario"=>$service->get("usuario"),
        "nombre"=>$service->get("nombre"),
        "apellido"=>$service->get("apellido")
    ];
    return $usuario;
}

function idUsuario(){
    $service = Services::session();
    return $service->get("id");
}

function GetInfoUserName(){
    $service = Services::session();

    $usuario = [
        "nombre"=>$service->get("nombre"),
        "apellido"=>$service->get("apellido")
    ];
    return $usuario;
}