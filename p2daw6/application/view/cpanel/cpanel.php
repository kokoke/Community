<?php

require_once 'application/view/general.php';

function getDashboard()
{
    $file = 'public_html/html/cpanel/dashboard.html';
    $template = file_get_contents($file);
    return $template;
}

function vistaTemplateCpanel ()
{
    $html = get_template_ini();
    $html = str_replace('{nav}', Controller_General::actionLoadNav(), $html);
    $html = str_replace('{construct}', vistaCpanel(), $html);
    $html = str_replace('{sidebar}', vistaSidebar(), $html);
    $html = str_replace('{subSidebar}', "", $html);
    $html = str_replace('{breadLine}', vistaBreadline(), $html);

    $nivel = $_SESSION["userLogin"][0]["nivelUser"];

    //MENU
    if($nivel == 1){
        $CatalegPos = "{Productos}";
        $urlCatalegPos = "cataleg";
        $SalesBuy = "{Ventas}";
        $urlSalBuy = "sales";
    } else {
        $CatalegPos = "{Pos}";
        $urlCatalegPos = "pos";
        $SalesBuy = "{Compras}";
        $urlSalBuy = "buy";
    }

    //Sidebar - Enlaces
    $html = str_replace('{imgAvatar}',  RutaImagenAvatar . $_SESSION["userLogin"][0]["avatar"], $html);
    $html = str_replace('{CatalegPos}', ucwords($CatalegPos), $html);
    $html = str_replace('{nameUser}',   $_SESSION["userLogin"][0]["userName"], $html);
    $html = str_replace('{urlDash}',    HOME . "cpanel/administrator", $html);
    $html = str_replace('{urlCatPos}',  HOME . "cpanel/" . $urlCatalegPos, $html);
    $html = str_replace('{urlSalBuy}',  HOME . "cpanel/" . $urlSalBuy, $html);
    $html = str_replace('{SalesBuy}',   $SalesBuy, $html);
    $html = str_replace('{urlMes}',     HOME . "cpanel/message", $html);

    $html = str_replace('{urlPre}',     HOME . "cpanel/preference" , $html);

    $html = str_replace('{dash}', "menuSelected", $html);
    $html = str_replace('{capo}', "", $html);
    $html = str_replace('{sabu}', "", $html);
    $html = str_replace('{mess}', "", $html);
    $html = str_replace('{pref}', "", $html);

    //BREADLINE
    $html = str_replace('{urlPaginaActual}', HOME . "cpanel", $html);
    $html = str_replace('{raiz}', "Dashboard", $html);
    $html = str_replace('{urlAccionPagina}', "#", $html);
    $html = str_replace('{accion}', "Página principal", $html);

    $html = configMenu($html);

    $html = translateCpanel($html);

    $html = str_replace('{footer}', vistaFooterCpanel(), $html);

    print $html;
}

function vistaCpanel ()
{
    $html = getDashboard();
    return $html;
}


function configMenu($code)
{
        if($_SESSION["userLogin"][0]["nivelUser"] == 1){
            $urlCatalegPos = HOME . "cpanel/cataleg";
            $imgCatalegPos = HOME . "public_html/img/ico/icoCataleg.png";
            $spanCatalegPos = "Catalogo";
            $urlCompraVenta = HOME . "cpanel/sales";
            $imgCompraVenta = HOME . "public_html/img/ico/icoSales.png";
            $spanCompraVenta = "Ventas";
        } else {
            $urlCatalegPos = HOME . "cpanel/pos";
            $imgCatalegPos = HOME . "public_html/img/ico/icoPos.png";
            $spanCatalegPos = "Terminal Punto Venta";
            $urlCompraVenta = HOME . "cpanel/buy";
            $imgCompraVenta = HOME . "public_html/img/ico/icoBuy.png";
            $spanCompraVenta = "Compras";
        }

        $code = str_replace('{urlCatalegPos}', $urlCatalegPos , $code);
        $code = str_replace('{imgCatalegPos}', $imgCatalegPos, $code);
        $code = str_replace('{spanCatalegPos}', $spanCatalegPos, $code);
        $code = str_replace('{urlCompraVenta}', $urlCompraVenta , $code);
        $code = str_replace('{imgCompraVenta}', $imgCompraVenta, $code);
        $code = str_replace('{spanCompraVenta}', $spanCompraVenta, $code);
        $code = str_replace('{urlMensajes}', HOME . "cpanel/message" , $code);
        $code = str_replace('{imgMensajes}', HOME . "public_html/img/ico/icoMessage.png", $code);
        $code = str_replace('{spanMensajes}', "Mensajes", $code);
        $code = str_replace('{urlPreference}', HOME . "cpanel/preference" , $code);
        $code = str_replace('{imgPreference}', HOME . "public_html/img/ico/icoConfig.png", $code);
        $code = str_replace('{spanPreference}', "Preferencias", $code);
        $code = str_replace('{urlContact}', HOME . "contact" , $code);
        $code = str_replace('{imgContact}', HOME . "public_html/img/ico/icoContact.png", $code);
        $code = str_replace('{spanContact}', "Contacto", $code);

        $code = str_replace('{urlCataleg}', "vistaBreadline", $code);
        $code = str_replace('{urlCataleg}', "vistaBreadline", $code);
        return $code;
}

function translateCpanel( $codigo )
{
    $codigo = str_replace('{Language:}', Lang::p("Language:"), $codigo);
    $codigo = str_replace('{conversations}', Lang::p("conversations"), $codigo);
    $codigo = str_replace('{breadLine}', Lang::p("breadLine"), $codigo);
    $codigo = str_replace('{welcome}', Lang::p("welcome"), $codigo);
    $codigo = str_replace('{catalog}', Lang::p("catalog"), $codigo);
    $codigo = str_replace('{products}', Lang::p("products"), $codigo);
    $codigo = str_replace('{categories}', Lang::p("categories"), $codigo);
    $codigo = str_replace('{monitoring}', Lang::p("monitoring"), $codigo);
    $codigo = str_replace('{contacts}', Lang::p("contacts"), $codigo);
    $codigo = str_replace('{adminContact}', Lang::p("adminContact"), $codigo);
    $codigo = str_replace('{searchContact}', Lang::p("searchContact"), $codigo);
    $codigo = str_replace('{Posts}', Lang::p("Posts"), $codigo);
    $codigo = str_replace('{rightNow}', Lang::p("rightNow"), $codigo);
    $codigo = str_replace('{Posts}', Lang::p("Posts"), $codigo);
    $codigo = str_replace('{products}', Lang::p("products"), $codigo);
    $codigo = str_replace('{sent}', Lang::p("sent"), $codigo);
    $codigo = str_replace('{NumberOfProducts}', Lang::p("NumberOfProducts"), $codigo);
    $codigo = str_replace('{NumberOfDistributors}', Lang::p("NumberOfDistributors"), $codigo);
    $codigo = str_replace('{distributors}', Lang::p("distributors"), $codigo);
    $codigo = str_replace('{received}', Lang::p("received"), $codigo);
    $codigo = str_replace('{sales}', Lang::p("sales"), $codigo);
    $codigo = str_replace('{pendingReview}', Lang::p("pendingReview"), $codigo);
    $codigo = str_replace('{unRead}', Lang::p("unRead"), $codigo);
    $codigo = str_replace('{stockProducts}', Lang::p("stockProducts"), $codigo);
    $codigo = str_replace('{blackList}', Lang::p("blackList"), $codigo);
    $codigo = str_replace('{search}', Lang::p("search"), $codigo);
    $codigo = str_replace('{nameUser}', Lang::p("nameUser"), $codigo);
    $codigo = str_replace('{myProfile}', Lang::p("myProfile"), $codigo);
    $codigo = str_replace('{logout}', Lang::p("logout"), $codigo);
    $codigo = str_replace('{preferences}', Lang::p("preferences"), $codigo);
    $codigo = str_replace('{others}', Lang::p("others"), $codigo);
    $codigo = str_replace('{Productos}', Lang::p("Productos"), $codigo);
    $codigo = str_replace('{Cataleg}', Lang::p("Cataleg"), $codigo);
    $codigo = str_replace('{Sales}', Lang::p("Sales"), $codigo);
    $codigo = str_replace('{Pos}', Lang::p("Pos"), $codigo);
    $codigo = str_replace('{Compras}', Lang::p("Compras"), $codigo);
    $codigo = str_replace('{messages}', Lang::p("Messages"), $codigo);
    $codigo = str_replace('{Ventas}', Lang::p("Ventas"), $codigo);

    return $codigo;
}
