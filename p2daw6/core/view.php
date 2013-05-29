<?php

class View {

    public $view_url;
    public $data;

    /**
     * Método que carga una vista pasada por parámetro
     * @param  String $vista La ruta de la vista dentro de la carpeta /views sin la extensión
     * @return void
     */

    public function load($vista, $data = array()) {

        $this->view_url = 'application/views/' . $vista . '.html';
        $this->data = $data;

        return $this;

    }

}