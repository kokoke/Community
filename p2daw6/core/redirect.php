<?php

class Redirect {

    public static function to($where)
    {
        header("Location:" . $where);
    }

    public static function to_prev()
    {
        return Redirect::to($_SERVER['HTTP_REFERER']);
    }

    public static function to_route($controllerAction, $arguments = array())
    {
        return Redirect::to(Route::to($controllerAction, $arguments));
    }

}
