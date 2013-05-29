<?php

require_once "application/view/cpanel/buy.php";
require_once 'application/models/buy.php';

require_once 'application/controllers/general.php';


class Controller_Buy
{
    /**
     * Acción para cargar los detalles de pedido
     */
    function action_viewDetallePedido ( $compra )
    {	
    	
        //comprueba que su pedido le pertenezca
        $data = Buy::getDetallesCompras( $compra );
        
        if( $data ) {
            vistaDetalleCompra( $data );
        } else {
            Redirect::to_route("cpanel@buy");
        }
    }

    /**
     * Acción para crear el pdf de la compra
     */
    public function action_PDF( $compra )
    {
        //comprobar que el pedido le pertenece
        $data = Buy::getDetallesCompras( $compra );
        if( $data ) {
            vistaTemplatePDf( $data );
        } else {
            Redirect::to_route("cpanel@buy");
        }
    }
}