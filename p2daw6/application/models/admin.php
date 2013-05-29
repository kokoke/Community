<?php

class Admin
{

    //Función que recoge los datos del usuario
    public function get($data)
    {
        $pass  = sha1($data['password']);//convierte la contrasñea a "sha1" para luego compararlo con el password del usuario
        $datos_usuarios = DataBase::consulta('
            select * from users
            where user = "'.$data['email'].'" and password = "'.$pass.'"
        ');

        return count($datos_usuarios) > 0
               ? $datos_usuarios
               : false;
    }
}