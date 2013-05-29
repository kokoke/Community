<?php

Class Pos
{
    public function  getPosListaProductos()
    {
        $user = $_SESSION["userLogin"][0]["idUser"];
       
        $datos = DataBase::consulta('
          select * from productos pr
          inner join productosEmpresa pe on pr.idProducto = pe.idProducto
          inner join empresa e on pe.idEmpresa = e.idEmpresa
          inner join persona p on p.empresa = e.idEmpresa
          inner join user u on u.iduser = e.idempresa
          inner join contacto c1 on c1.idUsuario1 = u.idUser
          where ((c1.idUsuario1 = ' . $user . ') or (c1.idusuario2 = ' . $user . ')) 
          	and (c1.aceptadoUsuario1 = 1 and c1.aceptadoUsuario2 = 1)
        ');

        return count($datos) > 0
                ? $datos
                : false;
    }

    public function getTargetPay()
    {
        $data = DataBase::consulta('
          select * from targetasCredito
          where persona = '.$_SESSION["userLogin"][0]["idUser"]
        );
        return count($data) > 0
                 ? $data
                 : false;
    }

    public function insertarPedido( $targeta )
    {
    	$user = $_SESSION["userLogin"][0]["idUser"];
        //se comprueba que la tarjeta le pertenece
        $data = DataBase::consulta('
          select * from targetasCredito
          where persona = '.$user.' and idTargeta ='.$targeta
        );
        
        //creo en una variable la consulta, tema de bucles
        $insert = '
          insert into pedido (fecha, idComprador, pago) values (NOW(),'.$user.' ,'.$targeta.');
          select @@IDENTITY;
          insert into comanda (idProducto, idPedido, cantidad) values';
        $update = '';
        
        foreach ( $_SESSION["carrito"] as  $value ) {
            $insert .= '("'.$value["Producto"].'", @@IDENTITY, '.$value["Cantidad"].'),';
            //Adquiero la cantidad de Stock que hay del producto
            $cantidadStock = DataBase::consulta('select stock from productosEmpresa where referencia = "'.$value["Producto"].'"');
            //Le resto la cantidad que ha solicitado
            $cantidadRestante = $cantidadStock[0]["stock"] - $value["Cantidad"] ;
            //concadeno todos los updates de todos los productos
            $update .= 'update productosEmpresa set stock = '.$cantidadRestante.' where referencia = "'.$value["Producto"].'";';
        }
        
        //le quito la ultima ","
        $insert = trim($insert, ',');

        if( count($data) > 0 ) {
          DataBase::insertar($insert);
          DataBase::insertar($update);
          unset($_SESSION["carrito"]);
        }
        Redirect::to_route("cpanel@buy");
    }

    public function getTarjetas()
    {
      $data = DataBase::consulta('
        select * from targetasCredito
        where persona = '.$_SESSION["userLogin"][0]["idUser"]
      );
      return count($data) > 0
               ? $data
               : false;
    }



}