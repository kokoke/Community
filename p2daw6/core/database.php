<?php

class DataBase {

    public function __construct()
    {
        // Configuración de nuestra base de datos
        $config = array(
            'driver'      => 'mysql',
            'host'        => '146.255.101.232',
            'basededades' => '2daw6_projecte',
            'usuari'      => '2daw6',
            'contrasenya' => 'alumnes',
            'charset'     => 'utf8',
        );

        $this->db = new PDO("{$config['driver']}:host={$config['host']};dbname={$config['basededades']};charset={$config['charset']}", $config['usuari'], $config['contrasenya']);
    }

    /**
     * Método que realiza una consulat sql a la base de datos
     * @param  SQL $consulta La consulta a realizar
     * @return array         Los datos
     */
    public static function consulta($consulta)
    {
        $conexion = new static();
        // Realizamos la consulta
        return (array) $conexion->db->query($consulta)->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function insertar($consulta)
    {
        $conexion = new static();
        return (array) $conexion->db->query($consulta);
    }

}