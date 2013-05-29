<?php


require_once 'application/view/general.php';

function vistaTemplateSales( $action, $producto )
{
    $html = get_template_ini();
    $html = str_replace('{nav}', Controller_General::actionLoadNav(), $html);
    $html = str_replace('{construct}', vistaSales(), $html);
    $html = str_replace('{sidebar}', vistaSidebar(), $html);
    $html = str_replace('{subSidebar}', vistaSubSidebar("Sales"), $html);
    $html = str_replace('{breadLine}', vistaBreadline(), $html);
    
    $cargar = getSales();
    $confirm = Sales::comprobarVentaAccion($producto);

    switch ($action) {
        case 'view':
            $cargar = vistaViewSales($producto);
        break;
        case 'del':
            if($confirm){
                Sales::delSales($producto);
            }
            Redirect::to_route("cpanel@sales");
        break;
        case 'sales':
            $cargar = getSales();
        break;
        default:
            Redirect::to_route("cpanel@sales");
        break;
    }

    $nivel = $_SESSION["userLogin"][0]["nivelUser"];
    if($nivel == 1){
        $CatalegPos = "productos";
        $urlCatalegPos = "cataleg";
        $SalesBuy = "Ventas";
        $urlSalBuy = "sales";
    } else {
        $CatalegPos = "pos";
        $urlCatalegPos = "pos";
        $SalesBuy = "Compras";
        $urlSalBuy = "buy";
    }

    $html = str_replace('{imgAvatar}',  RutaImagenAvatar . $_SESSION["userLogin"][0]["avatar"], $html);
    $html = str_replace('{CatalegPos}', ucwords($CatalegPos), $html);
    $html = str_replace('{nameUser}',   $_SESSION["userLogin"][0]["userName"], $html);
    $html = str_replace('{urlDash}',    HOME . "cpanel/administrator", $html);
    $html = str_replace('{urlCatPos}',  HOME . "cpanel/" . $urlCatalegPos, $html);
    $html = str_replace('{urlSalBuy}',  HOME . "cpanel/" . $urlSalBuy, $html);
    $html = str_replace('{SalesBuy}',   $SalesBuy, $html);
    $html = str_replace('{urlMes}',     HOME . "cpanel/message", $html);
    $html = str_replace('{messages}',   "Mensajes", $html);
    $html = str_replace('{urlPre}',     HOME . "cpanel/preference" , $html);
    $html = str_replace('{preferences}', "Preferencias", $html);
    //BREADLINE
    $html = str_replace('{urlPaginaActual}', HOME . "cpanel/sales", $html);
    $html = str_replace('{raiz}', "Ventas", $html);
    $html = str_replace('{urlAccionPagina}', "#", $html);
    //Sidebar - Seleccionado
    $html = str_replace('{dash}', "", $html);
    $html = str_replace('{capo}', "", $html);
    $html = str_replace('{sabu}', "menuSelected", $html);
    $html = str_replace('{mess}', "", $html);
    $html = str_replace('{pref}', "", $html);
    
    if($producto == "all" || $producto == "none")
        $subaccion = "";
    else
        $subaccion = $producto;

    $html = str_replace('{accion}', $subaccion , $html);
    
    $html = str_replace('{constructSales}',$cargar , $html);
    $html = str_replace('{listaDeProductos}', vistaListSales(), $html);
    $html = str_replace('{footer}', vistaFooterCpanel(), $html);
    print $html;
}

function vistaSales()
{
    $file = 'public_html/html/cpanel/sales.html';
    $template = file_get_contents($file);
    return $template;
}

function getSales()
{
    $file = 'public_html/html/sales/sales.html';
    $template = file_get_contents($file);
    return $template;
}

function getViewSales()
{
    $file = 'public_html/html/sales/viewSales.html';
    $template = file_get_contents($file);
    return $template;
}

function vistaViewSales( $idPedido )
{
    $html = getViewSales();

    $data = Sales::getDataClientePedido($idPedido);

    if ( $data ) {
        $html = str_replace('{avatarComprador}',RutaImagenAvatar . $data[0]["avatar"] , $html);
        $html = str_replace('{nombreComprador}',$data[0]["comprador"] , $html);
        $html = str_replace('{empresaComprador}',$data[0]["denominacion"] , $html);
        $html = str_replace('{direccionComprador}',$data[0]["direccion"] , $html);
        $html = str_replace('{telefonoComprador}',$data[0]["telefono"] , $html);
        $html = str_replace('{telefonoComprador}',$data[0]["telefono"] , $html);
        $html = str_replace('{listaProductosVendidosPedido}', cargarProductosSales($data), $html);
    }

    return $html;
}

function cargarProductosSales ( $data )
{
    $codi = "";
    $contador = 1;
    foreach ( $data as $value ) {
        $codi .= '<article>
                    <header>
                        <span class="circulo">+</span>
                        <span class="tituloSection">Producto ' . $contador . '</span>
                    </header>
                    <fieldset>
                        <label class="imagenProducto">
                            <img src="' . RutaImagenPos . $value["imagen"] . '"  class="imgMediana">
                        </label>
                        <ul class="infoProductosCompra">
                            <li>
                                <span class="textDetall">Producto</span>
                                <span> ' . $value["producto"] . ' </span>
                            </li>
                            <li>
                                <span class="textDetall">Referencia: </span>
                                <span> ' . $value["referencia"] . ' </span>
                            </li>
                            <li>
                                <span class="textDetall">Cantidad: </span>
                                <span> ' . $value["cantidad"] . ' </span>
                            </li>
                        </ul>
                    </fieldset>
                </article>';
        $contador++;
    }

    return $codi;
}

function vistaListSales()
{
    $data = Sales::getPedidos();
    $html = "";
    
    if ( $data ) {
        foreach ( $data as  $value ) {

            $html .='
                    <tr class="gradeA odd">
                    <td class="  sorting_1">' . $value["pedido"] . '</td>
                    <td class=" ">' . $value["comprador"] . '</td>
                    <td class=" ">' . $value["fechaCompra"] . '</td>
                    <td class=" ">' . $value["formaPago"] . '</td>
                    <td class=" ">' . $value["importe"] . '</td>
                    <td class="tableActs">
                        <a href="' . Route::to("sales@view", array($value["pedido"])) . '" class="tablectrl_small bDefault tipS icons" original-title="Edit">
                            <span class="iconb icoView">
                                <img src="' . HOME . 'public_html/img/ico/icon-view.png">
                            </span>
                        </a>
                        <a  href="' . Route::to("sales@xml", array($value["pedido"])) . '" class="tablectrl_small bDefault tipS icons icoDownload" original-title="Download">
                            <span class="iconb icoDown">
                                <img src="' . HOME . 'public_html/img/ico/icon-pdf.png">
                            </span>
                        </a>
                    </td>
                </tr>';
        }
    }

   return $html;
}

function vistaTemplateXMLSales($datas) 
{
	//pd($datas);
    require_once 'public_html/html/xml/templateXMLSales.php';
}