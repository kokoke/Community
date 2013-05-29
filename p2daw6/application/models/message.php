<?php

function vistaLoadContactList()
{

    $user = $_SESSION["userLogin"][0]["idUser"];

    $data = DataBase::consulta('
        SELECT idUsuario1, idUsuario2, aceptadoUsuario1, aceptadoUsuario2, u.userName as emisor, u.avatar as emisorAvatar , s.userName as receptor, s.avatar as receptorAvatar FROM `contacto`
        inner join user u on idUsuario1 = u.idUser
        inner join user s on idUsuario2 = s.idUser
        where (idUsuario1 = '.$user.' and aceptadoUsuario1 = 1 and aceptadoUsuario2 = 1)
        or (idUsuario2 = '.$user.' and aceptadoUsuario1 = 1 and aceptadoUsuario2 = 1)
    ');

    if ( count($data) > 0 ) {
        Database::consulta('
            UPDATE mensajeUsers SET  leidoReceptor =  1
            WHERE  idEmisor = '.$data[0]["idUsuario2"].' and idReceptor ='.$user
        );
    }

    $numeroDeMensajes = DataBase::consulta('
        SELECT idEmisor, idReceptor, count(idReceptor) as numeroDeMensajes FROM `mensajeUsers`
        WHERE idReceptor = '.$user.' and  leidoReceptor  = 0 group by idEmisor
    ');

    $resultados = array_merge (array('Valores' => $data), array('Cantidades' => $numeroDeMensajes));

    return (count($resultados) > 0)
                ? $resultados
                : false;

}

function LoadMessage( $data )
{
    $date = DataBase::consulta('
        select * from  mensajeUsers
        inner join mensaje on mensajeUsers.idMensaje = mensaje.idmensaje
        inner join user u1 on u1.idUser = idEmisor
        where (mensajeUsers.idEmisor = '.$data["idUsuario1"].' and idReceptor = '.$data["idUsuario2"].' and verEmisor = 1)
        or (mensajeUsers.idEmisor = '.$data["idUsuario2"].' and idReceptor = '.$data["idUsuario1"].' and verReceptor = 1)
        order by mensaje.idmensaje desc');
    return (count($date) > 0)
                ? $date
                : false;
}

