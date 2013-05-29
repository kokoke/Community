<?php

require_once 'application/view/cpanel/sales.php';
require_once 'application/models/sales.php';

require_once 'application/controllers/general.php';


/**
 * Controlador de las Ventas
 */
class Controller_Sales
{

    public function action_view($product)
    {
        if(isset($_SESSION["userLogin"])){
            vistaTemplateSales("view", $product);
        }
    }

    public function action_del($product)
    {
        if(isset($_SESSION["userLogin"])){
            vistaTemplateSales("del", $product);
        }
    }
    
    public function action_xml($idPedido) {
	    $data = Sales::getDataClientePedido($idPedido);
	    if( $data ) {
	        vistaTemplateXMLSales( $data );
	    } else {
	        Redirect::to_route("cpanel@buy");
	    }
    }
   
}