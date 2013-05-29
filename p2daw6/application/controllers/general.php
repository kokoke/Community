<?php

/**
 * Controlador genera, lo que se utilizan en más de una página
 */
class Controller_General
{
    //Acción que carga el nav(barra superior)
    public function actionLoadNav()
    {
        if(isset($_SESSION["userLogin"])){
            $html = vistaNavCpanel();
        } else {
            $html = vista_nav_login();
        }
        return $html;
    }

    //Acción cerrar sesion
    public function action_logout()
    {
        Session::destroy("userLogin");
        Redirect::to_route("admin@login");
    }
}