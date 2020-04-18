<?php

namespace Epys\Wis;


class Console
{

    const LOGS = 0;


    const ERROR = 1000;
    const ERROR_REQUIRED = 1100;
    const ERROR_VALIDATION = 1200;
    const ERROR_VALIDATION_DIR = 1210;
    const ERROR_VALIDATION_JSON = 1220;

    // Rutas de escritura
    private static $_path = '/tmp';
    private static $_path_wis = '/wis';
    private static $_path_logs = '/logs';
    private static $_path_input = '/input';
    private static $_path_error = '/error';

    private static $_console = [];

    /**
     * Método que define path de logs
     * @param codigo Código del mensaje que se desea escribir (Clase con códigos de logs o errores)
     * @param msg Mensaje que se desea escribir
     * @author Adonías Vásquez (adonias.vasquez[at]epys.cl)
     * @version 2020-04-14
     */
    public static function setPath($path = null)
    {

        // Path de escritura
        if (!$path)
            throw new Exception('Debe indicar el Path de escritura.', self::ERROR_REQUIRED);

        $path = rtrim($path, '/');

        if (!is_dir($path))
            throw new Exception('El Path no es valido.', self::ERROR_VALIDATION_DIR);

        // Defino Path de los logs
        self::$_path = $path;

    }

    /**
     * Método que escribe un mensaje en los logs
     * @param codigo Código del mensaje que se desea escribir (Clase con códigos de logs o errores)
     * @param msg Mensaje que se desea escribir
     * @author Adonías Vásquez (adonias.vasquez[at]epys.cl)
     * @version 2020-04-18
     */
    public static function log($msg = null, $codigo = false)
    {

        if (!$msg)
            return;

        // Formateo mensaje
        $msg = date("Y-m-d H:i:s") . "\tPID" . getmypid() . "\t\t" . $msg;

        // Guardo console
        if ($codigo)
            self::$_console['log'][$codigo] = $msg;
        else
            self::$_console['log'][] = $msg;

        // Guardo registros
        self::_putContents(self::$_path_logs . date("/Y/m"), $msg, $codigo);

    }

    /**
     * Método que escribe un mensaje en los logs pero de formato input (json)
     * @param $codigo Código del mensaje que se desea escribir (Clase con códigos de logs o errores)
     * @param $json Lo que recepciona PHP en input
     * @author Adonías Vásquez (adonias.vasquez[at]epys.cl)
     * @version 2020-04-18
     */
    public static function input($json = null, $codigo = false)
    {

        if (!$json)
            return;

        // Guardo console
        if ($codigo)
            self::$_console['input'][$codigo] = $json;
        else
            self::$_console['input'][] = $json;

        // Guardo registros
        self::_putContents(self::$_path_input . date("/Y/m"), json_encode($json), $codigo);

    }

    /**
     * Método que escribe un mensaje en los logs pero de formato error
     * @param codigo Código del mensaje que se desea escribir (Clase con códigos de logs o errores)
     * @param msg Mensaje que se desea escribir
     * @author Adonías Vásquez (adonias.vasquez[at]epys.cl)
     * @version 2020-04-18
     */
    public static function error($msg = null, $codigo = false)
    {

        if (!$msg)
            return;

        // Formateo mensaje
        $msg = date("Y-m-d H:i:s") . "\tPID" . getmypid() . "\t\t" . $msg;

        // Guardo console
        if ($codigo)
            self::$_console['log'][$codigo] = $msg;
        else
            self::$_console['log'][] = $msg;

        // Guardo registros
        self::_putContents(self::$_path_error . date("/Y/m"), $msg, $codigo);

    }

    /**
     * Método que crea un archivo
     * @param $filepath Código del mensaje que se desea escribir (Clase con códigos de logs o errores)
     * @param $str Mensaje que se desea escribir
     * @param $name Nombre del archivo
     * @author Adonías Vásquez (adonias.vasquez[at]epys.cl)
     * @version 2020-04-18
     */
    private static function _putContents($filepath, $str, $name = false)
    {

        // Si el archivo no tiene nombre
        if (!$name)
            $name = date('d');

        // Actualizo la ruta de los logs
        $filepath = rtrim(self::$_path . self::$_path_wis . $filepath, '/');
        if (!is_dir($filepath))
            mkdir($filepath, 0777, true);

        // Guardo contenido
        @file_put_contents($filepath . "/" . $name . ".log", $str . PHP_EOL, FILE_APPEND);

    }


    /**
     * Método que imprime la consola
     * @author Adonías Vásquez (adonias.vasquez[at]epys.cl)
     * @version 2020-04-18
     */
    public static function print()
    {
        print_r(self::$_console);
    }

    /**
     * Método que imprime la consola
     * @author Adonías Vásquez (adonias.vasquez[at]epys.cl)
     * @version 2020-04-18
     */
    public static function dump()
    {
        var_dump(self::$_console);
    }


}
