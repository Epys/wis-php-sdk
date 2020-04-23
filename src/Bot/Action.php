<?php


namespace Epys\Wis\Bot;


class Action
{

    /**
     * Create __construct
     */
    public function __construct($token = false, $options = [])
    {

    }

    /**
     * Create __call
     */
    public function __call($method, $args)
    {
        if (isset($this->$method)) {
            $func = $this->$method;
            return call_user_func_array($func, $args);
        }
    }

    public
    static function codi($codi)
    {
        // Verifico que esten cargados los datos
        \Epys\Wis\Client::isLoad(['database']);

        return \Epys\Wis\Client::$database->where(["CODI_ACCION" => $codi, "ACTIVO" => 1])
            ->get("WI.WIT_ACCION")->result()[0];
    }


    public
    static function blob($codi)
    {
        // Verifico que esten cargados los datos
        \Epys\Wis\Client::isLoad(['database']);

        return (self::codi($codi))->BLOB_ACCION;

    }

}