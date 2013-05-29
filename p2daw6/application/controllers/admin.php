<?php

    require_once 'application/view/login/login.php';
    require_once 'application/models/admin.php';

    require_once 'application/controllers/general.php';


class Controller_Admin extends Controller
{

    /**
     * Acción que llama a la vista login
     */
    public function action_login()
    {
        //se coprueba que se envia algo
        if ($_POST) {
            //comprobar que se envia el email y la contraseña
            if ($_POST['email'] != "" && $_POST['password'] != "") {

                $datos_usuario = array(
                    'email'    => $_POST['email'],
                    'password' => $_POST['password']
                );

                //comprueba que el usuario existe
                $user = Admin::get($datos_usuario);
                //se comprueba que contenga algo lo devuelto, y se crea la sesion
                $_SESSION["userLogin"] = ($user) ? $user[0] : false;
                //dependiendo de lo que se guarde en la sesion, se envia a una pagina u otra
                if ($_SESSION["userLogin"] != false) {
                    //Se llama a la instancia Redirect, enviandole la nueva ruta
                    Redirect::to_route("cpanel@administrator");
                } else {
                    //se llama a la instancia Redirect, enviandole a la pagina anterior
                    Redirect::to_prev();
                }
            }
        } else {
            //si la sesion existe le mando a la nueva pagina, si no existe vuelve a cargar la página
            if(isset($_SESSION["userLogin"])){
                 Redirect::to_route("cpanel@administrator");
            }else{
                vista_template_login();
            }
        }
    }

    /**
     * Acción que llama a la vista recordar
     */
    public function action_remember()
    {
        vista_template_remember();
    }

}