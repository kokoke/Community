<?php

/**
 * Controlador de configuracion del lenguaje
 */
class Controller_Lang extends Controller {

    public function action_index()
    {
        //Se carga el idoma pasado por GET en la sesion
        Session::set('language', $_GET['lang']);
        Redirect::to_prev();
    }
}