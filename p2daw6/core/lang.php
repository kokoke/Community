<?php

class Lang {



    public static function p($key)
    {
        $language = (Session::get('language')) ? Session::get('language') : $GLOBALS['default_language'];

        // La ruta del diccionario siemrpe será la misma
        $diccionario = require'language/' . substr($language, 0, 2) . '/' . $language . '.php';

        if (isset($diccionario[$key])) {
            return $diccionario[$key];
        } else {
            return $key;
        }

    }

    public static function setLanguage($language_code)
    {
        Session::set('language', $language_code);
    }
}