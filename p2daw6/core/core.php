<?php

session_start();



// URL's amigables
// todas las URL's pasan por aqui
require 'helpers.php';
require 'view.php';
require 'session.php';
require 'config.php';
require 'lang.php';
require 'database.php';
require 'redirect.php';
require 'define.php';
require 'route.php';

// Definimos la variable global donde quedarán almacenadas las rutas
$GLOBALS['routes'] = array();

// Añadimos las rutas
require 'application/routes.php';

$url_actual = explode('index.php', $_SERVER['PHP_SELF']);

$url_actual = $url_actual[1]; // Nos quedamos con el segundo fragmento que es el que nos interesa


if ($url_actual == '') $url_actual = '/';

// Sanitizamos la ruta
$url_actual = explode('/', $url_actual);
$url_actual = array_filter($url_actual);
$url_actual = '/' . implode('/', $url_actual);

// Si la ruta no existe 404
if ( ! Route::exists($url_actual)) Redirect::to(HOME.'errorpage');


$controllerAction = Route::getControllerAndAction($url_actual);


$GLOBALS['default_language'] = Config::get('default_language');


require 'controller.php';

require 'application/controllers/' . $controllerAction['controller'] . '.php';

$controlador = new $controllerAction['usage']['controller'];

$view = call_user_func_array(array($controlador, $controllerAction['usage']['action']), $controllerAction['arguments']);


function __autoload($nombre_clase) {
    $modelo = substr($nombre_clase, 0, 6);

    if ($modelo == 'Model_') {
        require '../application/models/' . $nombre_clase . '.php';
    }


}

