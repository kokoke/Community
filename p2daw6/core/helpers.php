<?php

/**
 * Archivo que contendrá algunas funciones para ayudarnos!
 */

/**
 * Función que printa y muere (Print and Die) un array u objeto
 * @param  [type] $array [description]
 * @return [type]        [description]
 */

function pd($array)
{
    echo '<pre>';
        print_r($array);
    echo '</pre>';
    exit;
}

function pd2($array, $array2)
{
    echo '<pre>';
        print_r($array);
    echo '</pre>';
    echo '<pre>';
        print_r($array2);
    echo '</pre>';
    exit;
}