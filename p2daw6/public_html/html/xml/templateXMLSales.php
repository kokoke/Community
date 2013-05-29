<?php
 //creo cabeceras desde PHP para decir que devuelvo un XML

header('Content-disposition: attachment; filename="newfile.xml"');
header('Content-type: "text/xml"; charset="utf8"');
readfile('newfile.xml');

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
echo '<title>Pedidos</title>';
echo "<link>http:/".HOME."</link>";
echo "<description>Listado productos</description>";
echo "<language>es-es</language>";
echo "<copyright>Sergio Mora, PioPio".utf8_decode ("®")."</copyright>\n";

//para cada registro encontrado en la base de datos
//tengo que crear la entrada RSS en un item
//pd($datas[0]["pedido"]);

echo '<Empresa>';
echo '<FormaPago>'.$datas[0]["formaPago"].'</FormaPago>';
echo '<Comprador>'.$datas[0]["comprador"].'</Comprador>';
echo '<Denominacion>'.$datas[0]["denominacion"].'</Denominacion>';
echo '<Direccion>'.$datas[0]["direccion"].'</Direccion>';
echo '<Telefono>'.$datas[0]["telefono"].'</Telefono>';

	echo '<Pedido id="'.$datas[0]["pedido"].'">';
		foreach ($datas as  $value) {
			echo '<Producto>';
			    echo '<Nombre red="'.$value["referencia"].'">'.$value["producto"].'</Nombre>';
			    echo '<Cantidad>'.$value["cantidad"].'</Cantidad>';
		    echo '</Producto>';
	    }
    echo "</Pedido>";

echo "</Empresa>";


//cierro las etiquetas del XML
echo "</channel>";
echo "</rss>";
