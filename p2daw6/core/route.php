<?php

class Route {

    public static function in($url, $controller_action)
    {
        $controller_action = explode('@', $controller_action);

        $GLOBALS['routes'][$url] = array(
            'controller' => $controller_action[0],
            'action'     => $controller_action[1]
        );
    }

    public static function exists($url)
    {
        // Si existe la ruta la devolvemos
        if (isset($GLOBALS['routes'][$url])) return $GLOBALS['routes'][$url];

        // Si no existe quizás es porque tiene variables, así que miramos
        foreach ($GLOBALS['routes'] as $ruta => $dataRuta) {
            if ($arguments = static::sameFormat($url, $ruta)) {
                $GLOBALS['routes'][$url] = array_merge($dataRuta, array('arguments' => $arguments));

                return true;
            }
        }

        // No existe
        return false;
    }

    public static function getControllerAndAction($url)
    {
        $data = $GLOBALS['routes'][$url];

        return array(

            'controller' => $data['controller'],
            'action'     => $data['action'],
            'arguments'  => isset($data['arguments']) ? $data['arguments'] : array(),

            'usage' => array(
                'controller' => 'Controller_' . ucwords($data['controller']),
                'action'     => 'action_' . $data['action']
            )
        );
    }

    public static function sameFormat($urlActual, $urlRuta)
    {
        // Primera comprobación: Mismo número de parámetros
        $urlActual = explode('/', $urlActual);
        $urlRuta   = explode('/', $urlRuta);

        $argumentos = array();

        if (count($urlActual) == count($urlRuta)) {

            // Recorremos toda la ruta en busca de parámetros y coincidencia
            $count = 0;
            foreach ($urlRuta as $parametroRuta) {
                if ($parametroRuta == '{argument}') {
                    $argumentos[] = $urlActual[$count];
                } elseif ($parametroRuta != $urlActual[$count]) {

                    return false;
                }

                $count++;
            }
        } else {
            return false;
        }

        return $argumentos;
    }



    public static function to($controllerAction, $arguments = array())
    {
        $controllerAction = explode('@', $controllerAction);

        $controller = $controllerAction[0];
        $action = $controllerAction[1];

        foreach ($GLOBALS['routes'] as $ruta => $datosRuta) {
            if ($datosRuta['controller'] == $controller and $datosRuta['action'] == $action){
                $configAPP = Config::app();

                $ruta = explode('/', $ruta);
                $ruta = array_filter($ruta);

                $countArguments = 0;
                $count = 0;

                foreach ($ruta as $key => $parameter) {
                    if ($parameter == '{argument}') {
                        $ruta[$key] = $arguments[$countArguments];
                        $countArguments++;
                    }
                    $count++;
                }


                $ruta = implode('/', $ruta);

                return $configAPP['url_base'] . $ruta;
            }
        }

        throw new Exception('No existe la ruta ' . $controllerAction, 1);

    }
}