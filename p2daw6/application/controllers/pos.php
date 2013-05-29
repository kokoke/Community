<?php

require_once 'application/view/cpanel/pos.php';
require_once 'application/models/pos.php';

require_once 'application/controllers/general.php';

/**
 * Controlador que carga el terminal punt de venta
 */

class Controller_Pos
{
    //Acción que elimina un producto del carrito
    public function action_delProduct($producto)
    {
        if ( isset($_SESSION["carrito"]) ) {
            for ( $i=0; $i < count($_SESSION["carrito"]); $i++ ) {
                if($_SESSION["carrito"][$i]["Producto"] === $producto){
                    unset($_SESSION["carrito"][$i]);
                }
            }
            //reordena la array tras eliminar el producto
            $_SESSION["carrito"] = array_values($_SESSION["carrito"]);
            //pd($_SESSION["carrito"]);
            Redirect::to_route("cpanel@pos");
        }
    }

    //Acción para eliminar el carrito
    public function action_delCart()
    {
        if(isset($_SESSION["carrito"])){
            unset($_SESSION["carrito"]);
        }
        Redirect::to_route("cpanel@pos");
    }

    //Acción para comprar
    public function action_addPedido()
    {
        //Se recibe por parametros el numero de la tarjeta
        $data = $_POST["target"];
        Pos::insertarPedido($data);
    }
}