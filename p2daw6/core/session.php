<?php

class Session {

    public static function get($what)
    {
        return (isset($_SESSION[$what]) && $_SESSION[$what] != '')
               ? $_SESSION[$what]
               : false;
    }

    public static function set($what, $value)
    {
        $_SESSION[$what] = $value;
    }

    public static function destroy($what)
    {
        $_SESSION[$what] = '';
        unset($_SESSION[$what]);

    }



}