<?php

require_once 'application/view/cpanel/preference.php';
require_once 'application/models/preference.php';

require_once 'application/controllers/general.php';

class Controller_Preference
{

    public function action_contacts()
    {
        if(isset($_SESSION["userLogin"]))
            vistaTemplatePreference("contacts");
    }

    public function action_suppliers()
    {
        if(isset($_SESSION["userLogin"]))
            vistaTemplatePreference("suppliers");
    }

    public function action_products() {
        if(isset($_SESSION["userLogin"]))
            vistaTemplatePreference("products");
    }

    public function action_sellers() {
        if(isset($_SESSION["userLogin"]))
            vistaTemplatePreference("sellers");
    }

    public function action_pay() {
        if(isset($_SESSION["userLogin"]))
            vistaTemplatePreference("pay");
    }

    //Acción que guarda los cambios realizados al perfil del usuario
    public function action_saveDatesUser()
    {
        //Subir la imagen al servidor
        $uploads_dir    = RutaProductosAvatar;
        $tmp_name       = $_FILES["imagenEditAvatar"]["tmp_name"];
        $name           = $_FILES["imagenEditAvatar"]["name"];
        move_uploaded_file($tmp_name, "$uploads_dir/$name");

        if ( $_POST ) {
            $data["editProfileUserName"]    = $_POST["editProfileUserName"];
            $data["editProfileEmail"]       = $_POST["editProfileEmail"];
            $data["editProfilePassword"]    = $_POST["editProfilePassword"];
            $data["editProfileImage"]       = $_FILES["imagenEditAvatar"]["name"];
            Preference::saveProfileUserDate($data);
            Redirect::to_route("cpanel@preference");
        }
    }

    //Acción eliminar tarjeta de credito
    public function action_delTarget( $target )
    {
        $data = Preference::getTargetEspecifica($target);
        if ( $data ) {
            Preference::delTarget($target);
        }
        Redirect::to_route("preference@pay");
    }

    public function action_addcontact( $contact )
    {
        Preference::setContact($contact);
        Redirect::to_route("preference@contacts");
    }


    public function action_acceptcontact( $contacto )
    {
        Preference::updateAceptContact($contacto);
        Redirect::to_route("preference@contacts");
    }

    public function action_delcontact( $contact )
    {
        Preference::delContact($contact);
        Redirect::to_route("preference@contacts");
    }

}