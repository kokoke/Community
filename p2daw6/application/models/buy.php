<?php

require_once 'application/view/general.php';


class Buy
{
    function getDetallesCompras( $pedido )
    {
        $user = $_SESSION["userLogin"][0]["idUser"];
        $sqlDatosEspecificosPedido = '
                select * from pedido p
                inner join comanda c on c.idPedido = p.idPedido
                inner join productosEmpresa pe on c.idProducto = pe.referencia
                inner join empresa e on pe.idempresa = e.idEmpresa
                inner join productos po on  po.idproducto = pe.idproducto
                inner join persona ps on ps.empresa = e.idempresa
                inner join user u on u.iduser = ps.idpersona
                where idComprador = '.$user.' and p.idpedido ='. $pedido;

        $data = DataBase::consulta($sqlDatosEspecificosPedido);
        return count($data) > 0
               ? $data
               : false;
    }

    function getListaCompras()
    {
        $user = $_SESSION["userLogin"][0]["idUser"];
        $sqlListadePedidos = '
                select *, sum(precio * c.cantidad) as precioTotal from pedido p
                inner join comanda c on c.idPedido = p.idPedido
                inner join productosEmpresa pe on c.idProducto = pe.referencia
                inner join empresa e on pe.idempresa = e.idEmpresa
                inner join persona ps on ps.empresa = e.idempresa
                inner join user u on u.iduser = ps.idpersona
                inner join targetasCredito tc on tc.idTargeta = p.pago
                where idComprador = '.$user.'
                group by p.idpedido';

        $datosProductos = DataBase::consulta($sqlListadePedidos);

        return count($datosProductos) > 0
               ? $datosProductos
               : false;
    }
}