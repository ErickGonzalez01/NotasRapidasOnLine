<?php 
namespace App\Libraries\Autenticacion;
class Random {
    private $longitud;
    private $caracteres="0123456789AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz";
    private $salida;

    /**
     * Asigna la longitud del has
     * @param int $longitud
     */
    public function SetLongitud(int $longitud){
        $this->longitud=$longitud;
    }

    /**
     * Asigna los caracteres que se usaran para el has
     * por defecto es '0123456789AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz'
     * @param string $caracteres
     */
    public function SetCaracteres(string $caracteres){
        $this->caracteres=$caracteres;
    }

    /**
     * Crea el has
     */
    public function Run(){
        $i=0;
        while($i < $this->longitud){
            $this->salida .= substr($this->caracteres, mt_rand(0, strlen($this->caracteres)-1), 1);
            $i++;
        }
    }

    /**
     * Devuelve el has creado
     * @return string
     */
    public function GetSalida():string{
        return $this->salida;
    }
}