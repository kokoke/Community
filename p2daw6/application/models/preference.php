<?php

class Preference
{

    public static function saveProfileUserDate( $data )
    {
        if ( $data["editProfileImage"] != "" ) {
            DataBase::insertar('
              update user set
              userName      = "'.$data["editProfileUserName"].'",
              email         = "'.$data["editProfileEmail"].'",
              password      = "'.sha1($data["editProfilePassword"]).'",
              avatar        = "'.$data["editProfileImage"].'"
              where idUser  = '.$_SESSION["userLogin"][0]["idUser"]
        );
        } else {
            DataBase::insertar('
              update user set
              userName      = "'.$data["editProfileUserName"].'",
              email         = "'.$data["editProfileEmail"].'",
              password      = "'.sha1($data["editProfilePassword"]).'"
              where idUser  = '.$_SESSION["userLogin"][0]["idUser"]
            );
        }
    }

    public static function getDateUser()
    {
        $datosUser = DataBase::consulta('
          select * from user u
          inner join persona p  on p.idPersona  = u.idUser
          inner join empresa pe on pe.idEmpresa = p.empresa
          where idUser = '.$_SESSION["userLogin"][0]["idUser"]
        );
        return $datosUser;
    }

    public static function getTarget()
    {
      $data = DataBase::consulta('
        select * from targetasCredito
        where persona = '.$_SESSION["userLogin"][0]["idUser"]
      );
      return count($data) > 0
               ? $data
               : false;
    }

    public static function getTargetEspecifica( $target )
    {
      $data = DataBase::consulta('
        select * from targetasCredito
        where idTargeta = '.$target.' and persona = '.$_SESSION["userLogin"][0]["idUser"]
      );
      return count($data) > 0
               ? $data
               : false;
    }

    public static function delTarget($dataTarget)
    {
        DataBase::insertar('
          delete from targetasCredito
          where idTargeta = '.$dataTarget.' and persona = '.$_SESSION["userLogin"][0]["idUser"]
        );
    }

    public static function getContactList($nivel)
    {
      $data = DataBase::consulta('
        select * from user u
        inner join persona p on p.idPersona = u.idUser
        inner join empresa e on e.idEmpresa = p.empresa
        where u.nivelUser ='.$nivel
      );
      return count($data) > 0
               ? $data
               : false;
    }

    public static function setContact( $idContact )
    {
        DataBase::insertar('
          insert into contacto (idUsuario1, idUsuario2, aceptadoUsuario1, aceptadoUsuario2)
          values ('.$_SESSION["userLogin"][0]["idUser"].', '.$idContact.', 1, 0)'
        );
    }

    public static function getProducts()
    {
        $data = DataBase::consulta('
          select * from productos p
          inner join productosEmpresa pe on pe.idproducto = p.idProducto
          inner join empresa e on e.idEmpresa = pe.idempresa
          inner join persona on persona.empresa = e.idEmpresa
          inner join user u on u.idUser = persona.idPersona'
        );
        return $data;
    }

    public static function getPreferenceContactList( $aceptado )
    {
      $user = $_SESSION["userLogin"][0]["idUser"];
      $data = DataBase::consulta('
        select (usu1.idUser) as usuario1, aceptadoUsuario1, p1.`nombre` as nombreUsu1, e1.denominacion as empresa1,
               (usu2.idUser) as usuario2, aceptadoUsuario2, p2.`nombre` as nombreUsu2, e2.denominacion as empresa2
        from contacto c
        inner join user usu1 on c.idUsuario1 = usu1.idUser
        inner join user usu2 on c.idUsuario2 = usu2.idUser
        left join persona p1 on p1.idPersona = usu1.idUser
        left join persona p2 on p2.idPersona = usu2.idUser
        left join empresa e1 on e1.idEmpresa = p1.empresa
        left join empresa e2 on e2.idEmpresa = p2.empresa
        where usu1.idUser = '.$user.'  and aceptadoUsuario1 = '.$aceptado.'
        or    usu2.idUser = '.$user.'  and aceptadoUsuario2 = '.$aceptado
      );

      return count($data) > 0
                ? $data
                : false;

    }

    public static function updateAceptContact( $contactoAceptado )
    {
      $user = $_SESSION["userLogin"][0]["idUser"];
      DataBase::insertar('
        update contacto set aceptadoUsuario2 = 1
        where idUsuario1 = '.$contactoAceptado.' and idUsuario2 = '.$user
      );
    }

    public static function delContact( $contacto )
    {
       DataBase::insertar('
          delete from contacto
          where idUsuario1 = '.$_SESSION["userLogin"][0]["idUser"].' and idUsuario2 = '.$contacto.'
          or idUsuario2 = '.$_SESSION["userLogin"][0]["idUser"].' and idUsuario2 = '.$contacto
        );
    }
}
