<?php

    require_once 'application/view/cpanel/cpanel.php';
    require_once 'application/models/cpanel.php';

    require_once 'application/view/cpanel/message.php';
    require_once 'application/models/message.php';

    require_once 'application/view/cpanel/cataleg.php';
    require_once 'application/models/cataleg.php';

    require_once 'application/view/cpanel/preference.php';
    require_once 'application/models/preference.php';

    require_once 'application/view/cpanel/contact.php';
    require_once 'application/models/contact.php';

    require_once 'application/view/cpanel/sales.php';
    require_once 'application/models/sales.php';

    require_once 'application/view/cpanel/pos.php';
    require_once 'application/models/pos.php';

    require_once 'application/view/cpanel/buy.php';
    require_once 'application/models/buy.php';

    require_once 'application/controllers/general.php';
    require_once 'application/controllers/buy.php';

class Controller_Cpanel extends Controller
{
    //Accción que carga la pagina principal del la app
    public function action_administrator()
    {
        if ( isset($_SESSION["userLogin"]) ) {
            vistaTemplateCpanel();
        } else {
            Redirect::to_route("admin@login");
        }
    }

    //Accción que carga la ventana de mensajes
    public function action_message()
    {
       if ( isset($_SESSION["userLogin"]) ) {
            vistaTemplateMessage();
       } else {
            Redirect::to_route("admin@login");
       }
    }

    //Accción que carga la ventana de los productos "catalogo"
    public function action_cataleg()
    {
       if ( isset($_SESSION["userLogin"]) ) {
          if ( $_SESSION["userLogin"][0]["nivelUser"] == 1 ) {
            vistaTemplateCataleg("list","all");
          } else {
            //si no le pertenece esta seccion le manda a una similar
            Redirect::to_route("cpanel@pos");
          }

       } else {
            Redirect::to_route("admin@login");
       }

    }

    //Accción que carga la ventana de preferencias
    public function action_preference()
    {

       if ( isset($_SESSION["userLogin"]) ) {
            vistaTemplatePreference("");
       }else{
            Redirect::to_route("admin@login");
       }

    }

    //Accción que carga la ventana de contacto
    public function action_contact()
    {
       if ( isset($_SESSION["userLogin"]) ) {
            vistaTemplateContact();
       }else{
            Redirect::to_route("admin@login");
       }

    }

    //Accción que carga las ventas
    public function action_sales()
    {
       if ( isset($_SESSION["userLogin"]) ) {
          if ( $_SESSION["userLogin"][0]["nivelUser"] == 1 ) {
              vistaTemplateSales("sales", "all");
          } else {
              //si no le pertenece esta seccion se manda a otra similar
              Redirect::to_route("cpanel@buy");
          }
       } else {
            Redirect::to_route("admin@login");
       }

    }

    //Accción que carga el terminal punto de venta
    public function action_pos()
    {
       if ( isset($_SESSION["userLogin"]) ) {
          if ( $_SESSION["userLogin"][0]["nivelUser"] == 2 ) {
              vistaTemplatePos("pos");
          } else {
             Redirect::to_route("cpanel@cataleg");
          }
       }else{
          Redirect::to_route("admin@login");
       }
    }

    //Accción que carga la ventana de la compras
    public function action_buy()
    {
    	
       if ( isset($_SESSION["userLogin"]) ) {
            if ( $_SESSION["userLogin"][0]["nivelUser"] == 2 ) {
              vistaTemplateBuy();
            } else {
              Redirect::to_route("cpanel@sales");
            }
       }else{
          Redirect::to_route("admin@login");
       }

    }
}
