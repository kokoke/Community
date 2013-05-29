<?php

function getContact()
{
    $file = 'public_html/html/cpanel/contact.html';
    $template = file_get_contents($file);
    return $template;
}

function getClients()
{
    $file = 'public_html/html/contact/seeContact.html';
    $template = file_get_contents($file);
    return $template;
}



function vistaTemplateContact()
{
    $html = get_template_ini();
    $html = str_replace('{nav}', Controller_General::actionLoadNav(), $html);
    $html = str_replace('{construct}', vistaContact(), $html);
    $html = str_replace('{sidebar}', vistaSidebar(), $html);

    $html = str_replace('{subSidebar}', vistaSubSidebar("Contact"), $html);
    $html = str_replace('{breadLine}', vistaBreadline(), $html);
    $html = str_replace('{constructContact}', vistaClients(), $html);

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

    $html = translateContact($html);

    $html = str_replace('{footer}', vistaFooterCpanel(), $html);

    print $html;
}

function vistaClients()
{
    $html = getClients();
    return $html;
}


function vistaContact ()
{
    $html = getContact();
    return $html;
}



function translateContact($codigo)
{
    $codigo = str_replace('{Language:}', Lang::p("Language:"), $codigo);
    $codigo = str_replace('{conversations}', Lang::p("conversations"), $codigo);
    $codigo = str_replace('{breadLine}', Lang::p("breadLine"), $codigo);

    return $codigo;
}
