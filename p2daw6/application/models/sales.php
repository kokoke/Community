<?php

class Sales
{

    public  function getPedidos()
    {
        $user = $_SESSION["userLogin"][0]["idUser"];
        $datosProductos = DataBase::consulta('
            select s.idPedido as pedido, s.fecha as fechaCompra, tj.targeta as formaPago,
            SUM(c.cantidad*pe.precio) as importe , p2.nombre as comprador
            from pedido s
            inner join comanda c on s.idPedido = c.idPedido
            inner join targetasCredito tj on tj.idTargeta = s.pago
            inner join productosEmpresa pe on pe.referencia = c.idProducto
            inner join empresa e on e.idEmpresa = pe.idempresa
            inner join persona p1 on p1.empresa     = e.idEmpresa
            inner join user u    on u.idUser    = p1.idPersona
            inner join persona p2 on s.idComprador = p2.idPersona
            where p1.idPersona = '.$user.'
            group by pedido
        ');

        return count($datosProductos) > 0
               ? $datosProductos
               : false;

    }
    //Comprobar que el pedido le pertenece
    public  function comprobarVentaAccion($id) {
        $user = $_SESSION["userLogin"][0]["idUser"];
         $patron = "/^[0-9]+$/";

        //Comprobar que lo que se ha introducido es un numero
            if (preg_match( $patron, $id)) {

                $datosProductos = DataBase::consulta('
                    select s.idPedido as pedido, s.fecha as fechaCompra, tj.targeta as formaPago,
                    SUM(c.cantidad*pe.precio) as importe , p2.nombre as comprador
                    from pedido s
                    inner join comanda c on s.idPedido = c.idPedido
                    inner join targetasCredito tj on tj.idTargeta = s.pago
                    inner join productosEmpresa pe on pe.referencia = c.idProducto
                    inner join empresa e on e.idEmpresa = pe.idempresa
                    inner join persona p1 on p1.empresa     = e.idEmpresa
                    inner join user u    on u.idUser    = p1.idPersona
                    inner join persona p2 on s.idComprador = p2.idPersona
                    where p1.idPersona = '.$user.' and s.idPedido='.$id.'
                    group by pedido'
                );

                return count($datosProductos) > 0
                       ? true
                       : false;

            } else {

                return false;

            }
    }

    public static function delSales($producto)
    {
        DataBase::insertar('delete from ventas where id = '.$producto);
    }

     public function getDataClientePedido($pedido)
    {
        $user = $_SESSION["userLogin"][0]["idUser"];
        $data = DataBase::consulta('
            select s.idPedido as pedido, s.fecha as fechaCompra, tj.targeta as formaPago,
            p2.nombre as comprador, e2.denominacion, p2.direccion, p2.telefono,
            po.producto, pe.referencia, c.cantidad, pe.imagen,  u2.avatar
            from pedido s
            inner join comanda c on s.idPedido = c.idPedido
            inner join targetasCredito tj on tj.idTargeta = s.pago
            inner join productosEmpresa pe on pe.referencia = c.idProducto
            inner join productos po on pe.idProducto = po.idProducto
            inner join empresa e on e.idEmpresa = pe.idempresa
            inner join persona p1 on p1.empresa     = e.idEmpresa
            inner join user u    on u.idUser    = p1.idPersona
            inner join persona p2 on s.idComprador = p2.idPersona
            inner join empresa e2 on p2.empresa = e2.idEmpresa
            inner join user u2  on u2.idUser    = p2.idPersona
            where p1.idPersona = '.$user.' and s.idPedido='.$pedido
        );
        return count($data) > 0
               ? $data
               : false;
    }
}