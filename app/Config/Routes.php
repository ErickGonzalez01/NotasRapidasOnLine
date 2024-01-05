<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

 //$routes->useSupportedLocalesOnly(true);
 
$routes->get('/', function(){
    return redirect("doc/notes");
});

$routes->get("doc/notes",function(){
    return view("doc/notas");
});

$routes->group("api",function($routes){
    $routes->group("authentication",function($routes){
        $routes->post('sigout','Usuario\Autenticacion::NuevoUsuario');
        $routes->post('login','Usuario\Autenticacion::IniciarSesion');
        $routes->post('recoverypassword','Usuario\Autenticacion::RecuperarContrasena');
        $routes->post('newpassword','Usuario\Autenticacion::NuevaContrasena');
    
    });
    //api/user/notes/
    $routes->group("user",function($routes){
        $routes->resource("notes",['controller' => 'Notas\ApiNotas','placeholder' => '(:num)','except'=>'new,edit,']);
        
        $routes->get('logout','Usuario\Autenticacion::CerrarSecion');
    });
});



$routes->post("/api/CrearNotas","ApiNotas::CrearNotas");
$routes->get("/api/ListarNotas","ApiNotas::ListarNotas");
