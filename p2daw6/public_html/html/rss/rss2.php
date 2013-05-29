<?php
 //creo cabeceras desde PHP para decir que devuelvo un XML
header("Content-type: text/xml");

//comienzo a escribir el código del RSS
echo "<?xml version='1.0'"." encoding='ISO-8859-1'?>";

$data = DataBase::consulta('
	select * from user u
	inner join persona p on p.idPersona = u.idUser
	inner join empresa e on p.empresa   = e.idEmpresa
');

//Cabeceras del RSS
echo '<rss version="2.0">';
//Datos generales del Canal. Edítalos conforme a tus necesidades
echo "<channel>\n";
echo '<title>Sindicaci'.utf8_decode ("ó").'n Community</title>';
echo "<link>http:/".HOME."</link>";
echo "<description>Sindicacion de los clientes registrados en Community</description>";
echo "<language>es-es</language>";
echo "<copyright>Sergio Mora, PioPio".utf8_decode ("®")."</copyright>\n";

//para cada registro encontrado en la base de datos
//tengo que crear la entrada RSS en un item
//pd($data);
echo "<Empresas>";
foreach ($data as  $value) {

    echo "<Empresa>\n";
    echo "<Denominacion>".$value["denominacion"]."</Denominacion>\n";
    echo "<Contacto>".$value["userName"]."</Contacto>\n";
    echo "<Web>".$value["web"]."</Web>\n";
    echo "</Empresa>\n";

}
echo "</Empresas>";

//cierro las etiquetas del XML
echo "</channel>";
echo "</rss>";
