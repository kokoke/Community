<?php

require_once 'application/view/general.php';

function get_login()
{
    $file = 'public_html/html/login/login.html';
    $template = file_get_contents($file);
    return $template;
}

function getRemember()
{
    $file = 'public_html/html/login/remember.html';
    $template = file_get_contents($file);
    return $template;
}

function vista_template_login ()
{
    $html = get_template_ini();
    $html = str_replace('{nav}', Controller_General::actionLoadNav(), $html);
    $html = str_replace('{construct}', vista_login(), $html);

    $html = str_replace('{sidebar}', "", $html);//Login no aparece y hay que quitarlo de "template"

    if ( isset($_SESSION["userLogin"]) && $_SESSION["userLogin" ]== false ) {
        $html = str_replace('{display}', 'style=display:block', $html);
    } else {
        $html = str_replace('{display}', 'style=display:none', $html);
    }

    $html = str_replace('{footer}', vistaFooterCpanel(), $html);
    $html = translateLogin($html);

    print $html;
}

function vista_login()
{
    $html = get_login();
    return $html;
}

function translateLogin($codigo){

    $codigo = str_replace('{Language:}', Lang::p("Language:"), $codigo);
    $codigo = str_replace('{errorUserValid}', Lang::p("errorUserValid"), $codigo);
    $codigo = str_replace('{fieldRequired}', Lang::p("fieldRequired"), $codigo);
    $codigo = str_replace('{emailError}', Lang::p("emailError"), $codigo);
    $codigo = str_replace('{remember}', Lang::p("remember"), $codigo);
    $codigo = str_replace('{Email}', Lang::p("Email"), $codigo);
    $codigo = str_replace('{Password}', Lang::p("Password"), $codigo);
    $codigo = str_replace('{Login}', Lang::p("Login"), $codigo);

    return $codigo;

}

function vista_template_remember()
{
    $html = get_template_ini();
    $html = str_replace('{nav}', Controller_General::actionLoadNav(), $html);
    $html = str_replace('{construct}', getRemember(), $html);

    $html = str_replace('{sidebar}', "", $html);//Login no aparece y hay que quitarlo de "template"
    $html = str_replace('{footer}', vistaFooterCpanel(), $html);
    print($html);
}
