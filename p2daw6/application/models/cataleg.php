<?php

class Cataleg
{
    public static function get()
    {
        $datosProductos = DataBase::consulta('
             select * from  productosEmpresa pe
             inner join empresa e on pe.idempresa = e.idEmpresa
             inner join persona p on p.empresa = e.idEmpresa
             inner join user u on u.idUser = p.empresa
             inner join productos pr on pr.idProducto = pe.idproducto
             inner join categories c on c.idCategory = pr.categoria
             where u.idUser = '.$_SESSION["userLogin"][0]["idUser"]
        );
        return count($datosProductos) > 0
               ? $datosProductos
               : false;
    }

    //Parecido al get(), pero en este especifico que producto quiero
    public static function getProducto($refProduct)
    {
        $datosProductos = DataBase::consulta('
          select * from  productosEmpresa pe
           inner join empresa e on pe.idempresa = e.idEmpresa
           inner join persona p on p.empresa = e.idEmpresa
           inner join user u on u.idUser = p.empresa
           inner join productos pr on pr.idProducto = pe.idproducto
           inner join categories c on c.idCategory = pr.categoria
           inner join iva i on i.idIVA = pe.iva
           where u.idUser = '.$_SESSION["userLogin"][0]["idUser"].'
                 and referencia = "'.$refProduct.'"'
        );

        return count($datosProductos) > 0
               ? $datosProductos
               : false;
    }



    public static function comprobarProductoAccion( )
    {

        $datoProducto = DataBase::consulta('
            select * from `productosEmpresa` pe
                inner join empresa e on pe.`idempresa` = e.`idEmpresa`
                inner join persona p on p.`empresa` = e.`idEmpresa`
                inner join user u on u.`idUser` = p.`idPersona`
                where u.`idUser` = '.$_SESSION["userLogin"][0]["idUser"]
        );

        return count($datoProducto) > 0
               ? true
               : false;

    }

    public static function delProduct( $producto )
    {
        DataBase::insertar('
          delete from productosEmpresa where referencia = "'.$producto.'"
        ');
    }

    public static function getCategoria()
    {
        $datosCategorias = DataBase::consulta('
          select * from categories inner join user on idUser = creador
          where creador = 0 or creador ='.$_SESSION["userLogin"][0]["idUser"]
        );
        return count($datosCategorias) > 0
               ? $datosCategorias
               : false;
    }

    public static function setNewCataleg($data)
    {
        $consulta = DataBase::consulta("
          select * from categories where category = \"".$data."\""
        );

        if ( count($consulta) == 0 ) {
          DataBase::insertar('
            insert into categories (category, creador)
            values ("'.$data.'",'.$_SESSION["userLogin"][0]["idUser"].')'
          );
        }
    }

    public static function delNewCataleg($idCategory)
    {
        $consulta = DataBase::consulta("
          select * from categories
          where idCategory = \"".$idCategory."\" and creador = ".$_SESSION["userLogin"][0]["idUser"]
        );

        if ( count( $consulta ) == 1 ) {
          DataBase::insertar('delete from categories where idCategory = '.$idCategory);
        }
    }

    public static function getIVA()
    {
        $consulta = DataBase::consulta("select * from iva");
        return $consulta;
    }

    public static function insertNewProduct($data)
    {
      //Primera parte, insertar el producto...
      //Compruebas si existe
      $consulta = DataBase::consulta("
        select * from productos where producto = \"".$data["saveNameProduct"]."\"
      ");
      //Segunda parte
      //Adquirir el id de la empresa
      $idEmpresa = DataBase::consulta(
        "select idEmpresa from empresa
        inner join persona on empresa.idEmpresa = persona.empresa
        inner join user on user.idUser = persona.idPersona
        where idUser = ".$_SESSION["userLogin"][0]["idUser"]
      );
      //Tercera Parte
      //Insertamos el producto  y detalles de producto
      if(count($consulta) == 0 && $idEmpresa > 0) {
        DataBase::insertar('insert into productos (producto, categoria) values ("'.$data["saveNameProduct"].'", '.$data["listCategory"].')');
        $idProducto = DataBase::consulta(
          "select idProducto from productos
          where producto = \"".$data["saveNameProduct"]."\"
        ");
        DataBase::insertar('
          insert into productosEmpresa (idproducto, idempresa, precio, stock, plazoEntrega, imagen, comprar, iva, referencia, precioCoste)
          values ('.$idProducto[0]["idProducto"].', '.$idEmpresa[0]["idEmpresa"].', '.$data["savePrecioProduct"].', '.$data["saveStockProduct"].', '.$data["saveDeliveryProduct"].',
            "'.$data["imagenProducto"].'",'.$data["checkEnambleBuy"].', '.$data["listIVA"].', "'.$data["saveRefProduct"].'", "'.$data["savePriceCostProduct"].'")
        ');
      //existe la empresa y el producto
      } else if ($idEmpresa > 0) {
        DataBase::insertar('
          insert into productosEmpresa (idproducto, idempresa, precio, stock, plazoEntrega, imagen, comprar, iva, referencia, precioCoste)
          values ('.$consulta[0]["idProducto"].', '.$idEmpresa[0]["idEmpresa"].', '.$data["savePrecioProduct"].', '.$data["saveStockProduct"].', '.$data["saveDeliveryProduct"].',
            "'.$data["imagenProducto"].'",'.$data["checkEnambleBuy"].', '.$data["listIVA"].', "'.$data["saveRefProduct"].'", "'.$data["savePriceCostProduct"].'")
        ');
      }
    }

    public static function updateProduct( $data )
    {
        //comprobamos de que exista el producto para crearlo o no
        $consulta = DataBase::consulta("select * from productos where producto = \"".$data["editNameProduct"]."\"");
        //Adquirir el id de la empresa
        $idEmpresa = DataBase::consulta(
          "select idEmpresa from empresa
          inner join persona on empresa.idEmpresa = persona.empresa
          inner join user on user.idUser = persona.idPersona
          where idUser = ".$_SESSION["userLogin"][0]["idUser"]
        );
        //Comprobar si el nuevo producto editado existe
        if(count($consulta) > 0 ) {

          DataBase::insertar('
            update productosEmpresa set
            idproducto  = '.$consulta[0]["idProducto"].',
            idempresa   = '.$idEmpresa[0]["idEmpresa"].',
            precio      = '.$data["editPrecioProduct"].',
            stock       = '.$data["editStockProduct"].',
            plazoEntrega= '.$data["editEntregaProduct"].',
            comprar     = '.$data["editCheckProduct"].',
            iva         = '.$data["editIvaProduct"].',
            referencia  = "'.$data["editRefProduct"].'",
            precioCoste = '.$data["editPrecioCostProduct"].',
            imagen      = "'.$data["imagenProducto"].'"
            where referencia = "'.$data["hiddenRefProduct"].'"'
          );

        } else {

          DataBase::insertar('
            insert into productos (producto, categoria)
            values ("'.$data["editNameProduct"].'", '.$data["editCategoryProduct"].')
          ');
          $idProducto = DataBase::consulta("
            select idProducto from productos
            where producto = \"".$data["editNameProduct"]."\"
          ");

          DataBase::insertar('
            update productosEmpresa set
            idproducto  = '.$idProducto[0]["idProducto"].',
            idempresa   = '.$idEmpresa[0]["idEmpresa"].',
            precio      = '.$data["editPrecioProduct"].',
            stock       = '.$data["editStockProduct"].',
            plazoEntrega= '.$data["editEntregaProduct"].',
            comprar     = '.$data["editCheckProduct"].',
            iva         = '.$data["editIvaProduct"].',
            referencia  = "'.$data["editRefProduct"].'",
            precioCoste = '.$data["editPrecioCostProduct"].',
            imagen      = "'.$data["imagenProducto"].'"
            where referencia = "'.$data["hiddenRefProduct"].'"'
          );
        }
    }
}