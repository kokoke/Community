<?php

require_once 'application/controllers/ajax.php';
require_once 'core/database.php';

class Ajax {

    //Functión que comprueba si existe el email en Newsletter
    public  function getNewsletter( $data )
    {
        $datos_usuarios = DataBase::consulta('
            select * from newsletter where newsletter = "'.$data.'"
        ');
        return count($datos_usuarios);
    }

    //Función que optiene todos los productos del usuario
    public  function getProducts()
    {
        $data = DataBase::consulta('
               select * from  productos pr
               inner join productosEmpresa pe on pe.idproducto = pr.idProducto
               inner join empresa e on pe.idempresa = e.idEmpresa
               inner join persona p on p.empresa = e.idEmpresa
               inner join user u on p.usuario = u.idUser
               where u.idUser = '.$_SESSION["userLogin"][0]["idUser"]
        );
        return $data;
    }

    //Función que añade el nuevo usuario al Newsletter
    public  function setNewsletter( $data )
    {
        DataBase::insertar('
            insert into newsletter (newsletter) values ("'.$data.'")
        ');
    }

    //Función que recoge los datos del usuario
    public  function getUser( $email, $pass )
    {
        $pass = sha1($pass);//convierte la contraseña para compararla
        $data = DataBase::consulta('
            select * from user where email="'.$email.'" and password="'.$pass.'"
        ');
        return $data;
    }

    //Función que recoge el nombre de usuario para comprobar que existe
    public  function getUserName( $user )
    {
        $data = DataBase::consulta('
            select * from user where userName="'.$user.'"
        ');
        return $data;
    }

    //Función para comprobar si el email existe
    public  function getUserEmail( $email )
    {
        $data = DataBase::consulta('
            select * from user where email="'.$email.'"
        ');
        return $data;
    }

    public static function getContactMessage( $my, $you )
    {
        //Actualizar los mensajes no leidos a leidos
        DataBase::insertar('
            update mensajeUsers set leidoReceptor = 1 where idReceptor = '.$my
        );

        $data = DataBase::consulta('
                    select * from  mensajeUsers
                    inner join mensaje on mensajeUsers.idMensaje = mensaje.idmensaje
                    inner join user u1 on u1.idUser = idEmisor
                    where (mensajeUsers.idEmisor = '.$my.' and idReceptor = '. $you.' and verEmisor = 1)
                    or (mensajeUsers.idEmisor = '. $you.' and idReceptor = '.$my.' and verReceptor = 1)
                    order by mensaje.idmensaje desc
                ');
                
         return count($data) > 0
                   ? $data
                   : false;


    }

    public  function setNewMessage($user, $userSend, $message)
    {
        DataBase::insertar('
                INSERT INTO mensaje (idmensaje, mensaje,fecha,ip) VALUES (NULL, "'.$message.'", CURDATE(), "asd");
                select @@IDENTITY;
                INSERT INTO mensajeUsers (idMensaje, idEmisor, idReceptor, verEmisor, verReceptor, leidoReceptor) VALUES (@@IDENTITY, '.$user.', '.$userSend.', 1, 1, 0);
        ');
    }

    public  function comprobarProducto( $producto )
    {
        $patron = "/^[0-9]+$/";
        //Comprobar que lo que se ha introducido es un numero
        if ( preg_match($patron, $producto) ) {
            $datoProducto = DataBase::consulta('
                                select * from  productos where usuario = '.$_SESSION["userLogin"][0]["idUser"].' and id ='.$producto
                            );
            return count($datoProducto) > 0
                   ? true
                   : false;

        } else {
            return false;
        }
    }

    public  function delProduct( $idProduct )
    {
       DataBase::insertar('delete from productos where id = '.$idProduct);
    }

    public  function insertNewUser( $data )
    {
        DataBase::insertar('insert into menssage (id, enviado, recibido, mensaje, leido, eliminado ) values (null, "'.$user.'","'. $userSend.'","'.$message.'","0","0" )');
    }


    function reloadLoadContactList()
    {

        $user = $_SESSION["userLogin"][0]["idUser"];
        $data = DataBase::consulta('
            SELECT idUsuario1, idUsuario2, aceptadoUsuario1, aceptadoUsuario2, u.userName as emisor , s.userName as receptor FROM `contacto`
            inner join user u on idUsuario1 = u.idUser
            inner join user s on idUsuario2 = s.idUser
            where (idUsuario1 = '.$user.' and aceptadoUsuario1 = 1 and aceptadoUsuario2 = 1)
                or (idUsuario2 = '.$user.' and aceptadoUsuario1 = 1 and aceptadoUsuario2 = 1)
        ');

        $numeroDeMensajes = DataBase::consulta('
                                SELECT idEmisor, idReceptor, count(idReceptor) as numeroDeMensajes FROM `mensajeUsers`
                                WHERE idReceptor = '.$user.' and  leidoReceptor  = 0 group by idEmisor');

        $resultados = array_merge (array('Valores' => $data), array('Cantidades' => $numeroDeMensajes));
        return $resultados;
    }

    function getUserBreadline( $user )
    {
        $data = DataBase::consulta('select * from user where idUser="'.$user.'"');
        return $data;
    }

    function getRefProducto( $refProduct )
    {
        $data = DataBase::consulta('
            select * from productosEmpresa where referencia="'.$refProduct.'"
        ');
        return $data;
    }

    public  function setNewTarget( $data ) {
        DataBase::insertar('
            insert into targetasCredito (targeta, persona)
            values ("'.$data.'", '.$_SESSION["userLogin"][0]["idUser"].')
        ');
    }

    function getListTarget()
    {
        $data = DataBase::consulta('
            select * from targetasCredito
            where persona = '.$_SESSION["userLogin"][0]["idUser"]
        );
        return count($data) > 0
               ? $data
               : false;
    }

    public  function getProductoCarrito( $product )
    {
        $user = $_SESSION["userLogin"][0]["idUser"];
        $data = DataBase::consulta('
            select * from productos pr
                inner join productosEmpresa pe on pr.idProducto = pe.idProducto
                inner join empresa e on pe.idEmpresa = e.idEmpresa
                inner join persona p on p.empresa = e.idEmpresa
                inner join user u on u.iduser = e.idempresa
                inner join contacto c1 on c1.idUsuario1 = u.idUser
                where   ((c1.idUsuario1 = '.$user.') or (c1.idusuario2 = '.$user.'))
                        and (c1.aceptadoUsuario1 = 1 and c1.aceptadoUsuario2 = 1)
                        and pe.referencia = "'.$product.'"
                group by pe.referencia'
        );

        return count($data) > 0
               ? $data
               : false;
    }
}