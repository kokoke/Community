<?php

function vistaListaCarrito()
{
    if ( count($_SESSION["carrito"]) == 0 || !isset($_SESSION["carrito"]) ) {
        $li = '
            <li><span class="cartBlockName"> Sin productos </span></li>
        ';
    }

    $li = "";
    for ( $i = 0 ; $i < count($_SESSION["carrito"]); $i++ ) {

        $data = AJAX::getProductoCarrito($_SESSION["carrito"][$i]["Producto"]);
        $data = $data[0]; //Para evitarnos tener que poner $data[0]["stock"] (duplicidades en el resultado)
        $cantidad = $_SESSION["carrito"][$i]["Cantidad"];
        $precioTotal = $data["precio"] * $cantidad;
        
        if ( strlen($cantidad) == 1 ) {
            $cantidad = '0' . $cantidad;
        }

        $li .='
            <li id="' . $_SESSION["carrito"][$i]["Producto"] . '">
                <span class="quantity"> ' . $cantidad . ' x</span>
                <a href="" class="cartBlockName">' . $_SESSION["carrito"][$i]["Producto"] . '</a>
                <span class="removeListProduct">
                    <a id="' . $data["referencia"] . '" href="' . Route::to("pos@delProduct", array($data["referencia"])) . '" rel="nofollow" class="ajax_cart_block_remove_link"> </a>
                </span>
                <span class="price">' . $precioTotal . '&euro;</span>
            </li>
        ';
    }
  
    return $li;
}


function vistaDetalladaProductosCarrito( $data )
{
    $code = vistaContentPos($data);
    return $code;
}

function vistaContentPos( $data )
{
    $html = getContentPos();
    $html = loadDetallesCarrito($data, $html);
    return $html;
}

function getContentPos()
{
        $file = 'public_html/html/pos/detallesCompra.html';
        $template = file_get_contents($file);
        return $template;
}

function loadDetallesCarrito( $data, $html )
{
    $codi = "";
    $precioTotal = 0;
    foreach ( $data as $value ) {
       $codi  .= "
            <tr>
                <td>" . $value["denominacion"] . "</td>
                <td>" . $value["producto"] . "</td>
                <td>" . $value["referencia"] . "</td>
                <td>" . $value["precio"] . "&euro;</td>
                <td>" . $value["cantidadSolicitada"] . "</td>
                <td>" . $value["cantidadSolicitada"] * $value["precio"] . "&euro;</td>
            </tr>

       ";
       $precioTotal = $precioTotal + ($value["cantidadSolicitada"] * $value["precio"]);
    }

    $html = str_replace('{listaDetallesProductosCarrito}', $codi, $html);
    $html = str_replace('{precioTotalCarrito}', $precioTotal . '&euro;', $html);
    $html = str_replace('{volverListaProductos}', HOME . "cpanel/pos", $html);
    return $html;
}