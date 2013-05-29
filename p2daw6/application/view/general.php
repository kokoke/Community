<?php

function get_template_ini()
{
    $file = 'public_html/html/template_default.html';
    $template = file_get_contents($file);
    return $template;
}

function vistaDefault()
{
    $html = get_template_ini();
    $html = str_replace('{nav}', viewLoadNavHome(), $html);
    $html = str_replace('{urlRegist}', 'href="'.HOME.'register"', $html);
    $html = str_replace('{sidebar}', "", $html);
    $html = str_replace('{footer}', vistaFooter(), $html);

    return $html;
}

function getNavCpanel()
{
    $file = 'public_html/html/nav/navCpanel.html';
    $template = file_get_contents($file);
    return $template;
}

function getFooter()
{
    $file = 'public_html/html/footer/footer.html';
    $template = file_get_contents($file);
    return $template;
}


function getBreadline()
{
    $file = 'public_html/html/breadline/breadline.html';
    $template = file_get_contents($file);
    return $template;
}

function vistaNavCpanel ()
{
    $html = getNavCpanel();
    return $html;
}

function vista_nav_login ()
{
    $html = get_nav_login();
    return $html;
}

function vistaFooter ()
{
    $html = getFooter();
    $html = str_replace('{urlAbout}', 'href="'.HOME.'contact"', $html);
    return $html;
}

function vistaBreadline ()
{
    $html = getBreadline();
    return $html;
}

function getSidebar()
{
    $file = 'public_html/html/sidebar/sidebar.html';
    $template = file_get_contents($file);
    return $template;
}

function vistaSidebar ()
{
    $html = getSidebar();
    return $html;
}

function getSubSidebar( $seccion )
{
    $file = 'public_html/html/sidebar/sidebar' . $seccion . '.html';
    $template = file_get_contents($file);
    return $template;
}

function vistaSubSidebar ( $seccion )
{
    $html = getSubSidebar($seccion);
    return $html;
}

function get_nav_login()
{
    $file = 'public_html/html/nav/nav_login.html';
    $template = file_get_contents($file);
    return $template;
}

function getUserPrincipalBreadline()
{
    $data = vistaLoadContactList();
    return count($data["Valores"]) > 0
               ? $data["Valores"][0]["receptor"]
               : false;
}

function vistaFooterCpanel ()
{
    $html = getFooterCpanel();
    return $html;
}

function getFooterCpanel()
{
    $file = 'public_html/html/footer/footercpanel.html';
    $template = file_get_contents($file);
    return $template;
}

