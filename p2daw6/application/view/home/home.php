<?php

require_once 'application/view/general.php';

function getNavHome()
{
    $file = 'public_html/html/nav/navHome.html';
    $template = file_get_contents($file);
    return $template;
}

function getHome()
{
    $file = 'public_html/html/home/home.html';
    $template = file_get_contents($file);
    return $template;
}

function getContact()
{
    $file = 'public_html/html/home/contact.html';
    $template = file_get_contents($file);
    return $template;
}

function getService()
{
    $file = 'public_html/html/home/service.html';
    $template = file_get_contents($file);
    return $template;
}

function getRegister()
{
    $file = 'public_html/html/home/register.html';
    $template = file_get_contents($file);
    return $template;
}

function vistaTemplateHome ()
{
    $html = vistaDefault();
    $html = str_replace('{construct}', vistaHome(), $html);
    $html = str_replace('{activeIni}', 'activeMenu', $html);
    $html = str_replace('{activeWho}', '', $html);
    $html = str_replace('{urlIni}', 'href="' . HOME . '"' , $html);
    $html = str_replace('{urlabout}', 'href="' . HOME . 'contact"', $html);
    $html = translateHome($html);

    print $html;
}

function vistaTemplateService ()
{
    $html = vistaDefault();
    $html = str_replace('{construct}', vistaService(), $html);

    $html = translateHome($html);

    print $html;
}

function vistaTemplateContact ()
{
    $html = vistaDefault();
    $html = str_replace('{construct}', vistaContact(), $html);
    $html = str_replace('{activeIni}', '', $html);
    $html = str_replace('{activeWho}', 'activeMenu', $html);
    $html = str_replace('{urlIni}', 'href="' . HOME . '"' , $html);
    $html = str_replace('{urlabout}', 'href="' . HOME . 'contact"', $html);

    $html = translateHome($html);

    print $html;

}

function vistaTemplateErrorPage()
{
    $html = get_template_ini();
    $html = str_replace('{nav}',vista_nav_errorPage() , $html);
    $html = str_replace('{construct}', vistaErrorPage(), $html);
    $html = str_replace('{urlGranda}', HOME . '/public_html/img/404.png', $html);
    $html = str_replace('{sidebar}', "", $html);
    $html = str_replace('{subSidebar}', "", $html);
    $html = str_replace('{breadLine}', "", $html);
    $html = str_replace('{footer}', vistaFooterCpanel(), $html);

    $html = str_replace('{urlIni}', 'href="' . HOME . '"' , $html);
    $html = str_replace('{urlabout}', 'href="' . HOME .'contact"', $html);

    print $html;
}

function vistaErrorPage()
{
    $html = getErrorPage();
    return $html;
}

function vista_nav_errorPage()
{
    $html = get_nav_errorPage();
    return $html;
}

function get_nav_errorPage()
{
    $file = 'public_html/html/nav/nav_error.html';
    $template = file_get_contents($file);
    return $template;
}


function getErrorPage()
{
    $file = 'public_html/html/error/404.html';
    $template = file_get_contents($file);
    return $template;
}

function vistaTemplateRegister ()
{
    $html = vistaDefault();
    $html = str_replace('{construct}', vistaRegister(), $html);
    $html = str_replace('{urlIni}', 'href="'.HOME.'"' , $html);
    $html = str_replace('{urlabout}', 'href="'.HOME.'contact"', $html);
    $html = translateHome($html);

    print $html;
}

function viewLoadNavHome ()
{
    $html = getNavHome();
    return $html;
}

function vistaHome ()
{
    $html = getHome();
    return $html;
}

function vistaService ()
{
    $html = getService();
    return $html;
}

function vistaRegister ()
{
    $html = getRegister();
    return $html;
}

function vistaContact ()
{
    $html = getContact();
    return $html;
}


function translateHome($codigo)
{
    $codigo = str_replace('{Language:}', Lang::p("Language:"), $codigo);
    $codigo = str_replace('{conversations}', Lang::p("conversations"), $codigo);
    $codigo = str_replace('{breadLine}', Lang::p("breadLine"), $codigo);
    return $codigo;
}

function vistaTemplateRSS()
{
    $html = vistaRSS();
    print $html;
}


