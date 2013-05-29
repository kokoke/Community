<?php

require_once 'application/view/general.php';
require_once 'application/view/cpanel/cataleg.php';

function getPos()
{
    $file = 'public_html/html/cpanel/pos.html';
    $template = file_get_contents($file);
    return $template;
}

function getContentPos()
{
    $file = 'public_html/html/pos/contentPos.html';
    $template = file_get_contents($file);
    return $template;
}

function vistaTemplatePos ($action)
{
    $html = get_template_ini();
    $html = str_replace('{nav}', Controller_General::actionLoadNav(), $html);
    $html = str_replace('{construct}', vistaPos(), $html);
    $html = str_replace('{sidebar}', vistaSidebar(), $html);
    $html = str_replace('{subSidebar}', vistaSubSidebar("Pos"), $html);
    $html = str_replace('{breadLine}', vistaBreadline(), $html);
    
    $vista = "";
    switch ($action) {
        case 'pos':
            $vista = vistaContentPos();
        break;
    }

    $nivel = $_SESSION["userLogin"][0]["nivelUser"];
    if ( $nivel == 1 ) {
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
    $html = str_replace('{capo}', "menuSelected", $html);
    $html = str_replace('{sabu}', "", $html);
    $html = str_replace('{mess}', "", $html);
    $html = str_replace('{pref}', "", $html);

    //BREADLINE
    $html = str_replace('{urlPaginaActual}', HOME . "cpanel/pos", $html);
    $html = str_replace('{raiz}', "Terminal punto de venta", $html);
    $html = str_replace('{urlAccionPagina}', "#", $html);
    $html = str_replace('{accion}', "Productos", $html);

    $targetas = Pos::getTarjetas();

    if($targetas){
        $html = str_replace('{constructPos}', $vista, $html);
    } else {
        $html = str_replace('{constructPos}', vistaError(), $html);
    }

    $html = str_replace('{listTargetPay}',loadTargetPay(), $html);
    $html = str_replace('{footer}', vistaFooterCpanel(), $html);

    print $html;

}

function vistaPos ()
{

    $html = getPos();
    return $html;
}

function vistaContentPos()
{
    $html = getContentPos();
    $html = str_replace('{listPosProducts}', cargarListaDeProductos($html), $html);

    return $html;
}

function loadTargetPay()
{
    $data = Pos::getTargetPay();
    $code = "";

    if ( $data ) {
        foreach ( $data as $value ) {
            $code .='
                <label>
                    <input type="radio" name="target" class="target" value="' . $value["idTargeta"] . '"> <span>' . $value["targeta"] . '</span>
                </label>
            ';
        }
    }

    return $code;
}

function cargarListaDeProductos()
{
    $dataProductList = Pos::getPosListaProductos();
    $codigo = "";

    if ( $dataProductList ) {
        foreach ( $dataProductList as $value ) {
            $codigo .='
                <li>
                    <div class="contentProduct">
                        <img src="' . RutaImagenPos . $value["imagen"] . '" class="imgGrande">
                        <label>
                            <h2 class="productName" style="color: #24546b!important;"><span>' . $value["producto"] . '</span>
                            <span style="font-size:10px;color: black!important;">(' . $value["referencia"] . ')</span></h2>
                            <span>' . $value["denominacion"] . '</span>
                            <span class="price">' . $value["precio"] . '&euro;</span>
                        </label>
                        <fieldset>
                             <span>Cantidad:</span><input type="text">
                             <span class="blackBtn btnAddCart" id="' . $value["referencia"] . '">Añadir</span>
                        </fieldset>
                        </div>
                </li>
            ';
        }
    }
    return $codigo;
}

function getContentPosError()
{
    $file = 'public_html/html/pos/errorPos.html';
    $template = file_get_contents($file);
    return $template;
}

function vistaError()
{
    $html = getContentPosError();
    return $html;
}
