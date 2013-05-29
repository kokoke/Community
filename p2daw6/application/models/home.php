<?php

Class Home
{
    public function insertarNuevoUsuario( $data )
    {
        DataBase::insertar('
            insert into user (userName, email, nivelUser, password, avatar)
            values ("'.$data["camporegistro1"].'", "'.$data["camporegistro2"].'",
                '.$data["camporegistro12"].', "'.sha1($data["camporegistro3"]).'","defaultAvatar.png")
        ');

        $user = DataBase::consulta('
            select idUser from user where email ="'.$data["camporegistro2"].'"
        ');
        
        //Se le inserta el contacot administrador por defecto
        DataBase::insertar('
            insert into contacto (idUsuario2, idUsuario2, aceptadoUsuario1, aceptadoUsuario2) 
            values ('.$user.', 0, 1,1);
        ');
        
        DataBase::insertar('
            insert into empresa (denominacion,cif,web )
            values ("'.$data["camporegistro14"].'","'.$data["camporegistro11"].'",
                "'.$data["camporegistro13"].'");
        ');

        $empresa = DataBase::consulta('
            select idempresa from empresa
            where denominacion ="'.$data["camporegistro14"].'"
        ');

        DataBase::insertar('
            insert into persona (idPersona, nombre,apellidos,direccion,telefono, fechanacimiento, empresa )
            values ('.$user[0]["idUser"].',"'.$data["camporegistro5"].'","'.$data["camporegistro6"].'", "'.$data["camporegistro10"].'",
                "'.$data["camporegistro9"].'", "'.$data["camporegistro8"].'", '.$empresa[0]["idempresa"].');
        ');
    }

    public  function getUser( $email, $pass)
    {
        $pass = sha1($pass);
        $data[0] = DataBase::consulta('
            select * from user where email="'.$email.'" and password="'.$pass.'"
        ');
        return $data;
    }

    public function GetDataSindicationAllUsers()
    {
        $data = DataBase::consulta('
            select * from user u
            inner join persona p on p.idPersona = u.idUser
            inner join empresa e on p.empresa   = e.idEmpresa
        ');

        return count($data) > 0
               ? $data
               : false;
    }
}


