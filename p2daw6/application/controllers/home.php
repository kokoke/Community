<?php

    require_once 'application/view/home/home.php';
    require_once 'application/models/home.php';

/*
 * Controladores de la página principal de presentacion
 */
class Controller_Home {

    //Acción que carga la página inicial Home
    public function action_home()
    {
        vistaTemplateHome();
    }

    //Acción que carga la página de contacto
    public function action_contact()
    {
        vistaTemplateContact();
    }

    //Acción que carga la página de registro
    public function action_register()
    {
        vistaTemplateRegister();
    }

    //Acción para insertar un nuevo usuario
    public function action_newUser()
    {
        if($_POST){
            Home::insertarNuevoUsuario($_POST);
        }
        Redirect::to_route("home@home");
    }

    //Acción que carga la página 404
    public function action_errorpage()
    {
        vistaTemplateErrorPage();
    }

    //Acción que carga la página de sindicacion
    public function action_sindication()
    {
        require_once 'public_html/html/rss/rss2.php';
    }
}