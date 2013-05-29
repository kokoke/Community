<?php

class Config {

    public static function get($what)
    {
        $config = require 'application/config/language.php';
        return $config[$what];
    }

    public static function app()
    {
        $config = require 'application/config/app.php';
        return $config;
    }
}
