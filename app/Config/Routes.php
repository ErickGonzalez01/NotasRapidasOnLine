<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

 //$routes->useSupportedLocalesOnly(true);
 
$routes->get('/', 'Home::index');

$routes->match(['get','post'],'/nuevo','Usuario\Autenticacion::NuevoUsuario');
$routes->match(['get','post'],'/inicio','Usuario\Autenticacion::IniciarSesion');
$routes->get('/cerrar','Usuario\Autenticacion::CerrarSecion');
