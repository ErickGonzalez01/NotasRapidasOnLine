<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
 
$routes->get('/', fn()=> redirect()->to("doc"));

$routes->group("doc",function($routes){

    $routes->get("/",fn()=>view("doc/index"));

    $routes->get("authentication",fn()=>view("doc/authentication"));

    $routes->get("notes",fn()=>view("doc/notes"));
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
