<?php

require_once 'core/WriteHTML.php';
require_once 'lib/dompdf/dompdf_config.inc.php';

function vistaTemplateBuy()
{
    $html = get_template_ini();
    $html = str_replace('{nav}', Controller_General::actionLoadNav(), $html);
    $html = str_replace('{construct}', vistaBuy(), $html);
    $html = str_replace('{sidebar}', vistaSidebar(), $html);
    $html = str_replace('{subSidebar}', vistaSubSidebar("Buy"), $html);
    $html = str_replace('{breadLine}', vistaBreadline(), $html);

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
    
    //Sidebar - Seleccionado
    $html = str_replace('{dash}', "", $html);
    $html = str_replace('{capo}', "", $html);
    $html = str_replace('{sabu}', "menuSelected", $html);
    $html = str_replace('{mess}', "", $html);
    $html = str_replace('{pref}', "", $html);

    //BREADLINE
    $html = str_replace('{urlPaginaActual}', HOME . "cpanel/buy", $html);
    $html = str_replace('{raiz}', "Compras", $html);
    $html = str_replace('{urlAccionPagina}', "#", $html);
    $html = str_replace('{accion}', "", $html);
    
    $html = str_replace('{constructbuy}', vistaContentBuy(), $html);
    //pd("ent1r2a");
    $html = str_replace('{listaDeCompras}', vistaListCompras(), $html);
    
    $html = str_replace('{backBuy}',  HOME.'cpanel/buy', $html);
    
    $html = str_replace('{footer}', vistaFooterCpanel(), $html);

    print $html;
}

function vistaBuy()
{
    $html = getbuy();
    return $html;
}

function getbuy()
{
    $file = 'public_html/html/cpanel/buy.html';
    $template = file_get_contents($file);
    return $template;
}

function getListBuy()
{
    $file = 'public_html/html/buy/listbuy.html';
    $template = file_get_contents($file);
    return $template;
}

function vistaContentBuy()
{
    $html = getListBuy();
    return $html;
}



function vistaListCompras()
{
	
    $data = Buy::getListaCompras();
    $code = "";
    
    if ( $data ) {

        foreach ( $data as $value ) {
            $pedido = (string)$value["idPedido"].'';
            //pd(route::to("buy@viewDetallePedido", array($value["idPedido"])));
            $code .= '
                    <tr class="gradeA odd">
                        <td class="  sorting_1">' . $value["idPedido"] . '</td>
                        <td class=" ">' . $value["fecha"] . '</td>
                        <td class=" ">' . $value["targeta"] . '</td>
                        <td class=" ">' . $value["precioTotal"] . '€</td>
                        <td class="tableActs">
                            <a href="'.route::to("buy@viewDetallePedido", array($value["idPedido"])).'" class="tablectrl_small bDefault tipS icons" original-title="Edit">
                                <span class="iconb icoView">
                                    <img src="'.HOME.'/public_html/img/ico/icon-view.png">
                                </span>
                            </a>
                            <a  href="'.route::to("buy@PDF", array($value["idPedido"])).'" class="tablectrl_small bDefault tipS icons icoDownload" original-title="Download">
                                <span class="iconb icoDown">
                                    <img src="'.HOME.'/public_html/img/ico/icon-pdf.png">
                                </span>
                             </a>
                        </td>
                    </tr>';
        }
    }
    return $code;
}


function vistaDetalleCompra( $data )
{
    $html = get_template_ini();
    $html = str_replace('{nav}', Controller_General::actionLoadNav(), $html);
    $html = str_replace('{construct}', vistaBuy(), $html);
    $html = str_replace('{sidebar}', vistaSidebar(), $html);
    $html = str_replace('{subSidebar}', vistaSubSidebar("Buy"), $html);
    $html = str_replace('{breadLine}', vistaBreadline(), $html);
    //BREADLINE
    $html = str_replace('{urlPaginaActual}', HOME . "cpanel/buy", $html);
    $html = str_replace('{raiz}', "Compras", $html);
    $html = str_replace('{urlAccionPagina}', "#", $html);
    $html = str_replace('{accion}', $data[0]["idPedido"], $html);

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


    $html = str_replace('{constructbuy}', vistaContentBuyDetall(), $html);
    $html =  constructorListaProductos($data, $html);

    $html = str_replace('{backBuy}',  	HOME."cpanel/buy", $html);

    $html = str_replace('{footer}', vistaFooterCpanel(), $html);

    print $html;
}

function vistaContentBuyDetall()
{
    $html = getbuyDetall();
    return $html;
}

function getbuyDetall()
{
    $file = 'public_html/html/buy/detallbuy.html';
    $template = file_get_contents($file);
    return $template;
}

function constructorListaProductos( $data, $html )
{
    $codi = "";
    $precioTotal = 0;

    foreach ( $data as $value ) {
       $codi .= "
            <tr>
                <td>" . $value["denominacion"] . "</td>
                <td>" . $value["producto"] . "</td>
                <td>" . $value["referencia"] . "</td>
                <td>" . $value["precio"] . "&euro;</td>
                <td>" . $value["cantidad"] . "</td>
                <td>" . $value["cantidad"] * $value["precio"] . "&euro;</td>
            </tr>

       ";
       $precioTotal = $precioTotal + ($value["cantidad"] * $value["precio"]);

    }


    $precioTotal .= "&euro;";

    $html = str_replace('{precioTotalCarrito}', $precioTotal, $html);
    $html = str_replace('{listaDetallesProductosCarrito}', $codi, $html);


    return $html;
}

function vistaTemplatePDF( $pedido )
{
	
	$html = getTemplatePDF();
	$html = str_replace('{ContenidoPedidoRealizado}', loadPedidoPDF($pedido) , $html);
	
	//se crea una nueva instancia al DOMPDF
	$dompdf = new DOMPDF();
	//se carga el codigo html
	$dompdf->load_html($html);
	//aumentamos memoria del servidor si es necesario
	ini_set("memory_limit","32M"); 
	//lanzamos a render
	$dompdf->render();
	//guardamos a PDF
	$dompdf->stream("mipdf.pdf");
	
	//print($html);
		
}


function getTemplatePDF(){
	$file = 'public_html/html/pdf/buyTemplate.html';
    $template = file_get_contents($file);
    return $template;
}

function loadPedidoPDF ($pedido) {
	$codi = "";
	$precio = 0;
	if( count($pedido) > 0) {
		foreach($pedido as $value) { 
			$codi .= '
			<tr>
	            <td>' . $value["denominacion"] . ' </td>
	            <td>' . $value["nombre"] . '</td>
	            <td>' . $value["referencia"] . '</td>
	            <td>' . $value["precio"] . '&euro;</td>
	            <td>' . $value["cantidad"] . '</td>
	            <td>' . $value["precio"] * $value["cantidad"] . '&euro;</td>
            </tr>
            '; 
            $precio = $precio + ($value["precio"] * $value["cantidad"]);
		}
	}	
	
	$codi .= '
		<tr>
            <td id="targetNumber" colspan="2">{formadePago}</td>
            <td></td>
            <td></td>
            <td id="total">Total:</td>
            <td>'.$precio.'&euro;</td>
        </tr>';
        
	return $codi;
}