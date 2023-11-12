<?php

namespace App\Validation;

class Cadena
{
    // public function custom_rule(): bool
    // {
    //     return true;
    // }
    public function alpha_numeric_es($value):bool
    {
        $stringPatron ='/^[a-zA-Z0-9áéíóúüÁÉÍÓÚÜñÑ\s]+$/';        
        $boolValidacion = preg_match($stringPatron, $value);
        if(!$boolValidacion){
            return $boolValidacion;
        }
        return $boolValidacion;
    }
    function user_name($value):bool
    {
        $stringPatron = '/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ\s.@]+$/';
        $boolValidacion = preg_match($stringPatron, $value);
        if(!$boolValidacion){
            return $boolValidacion;
        }
        return $boolValidacion;
    }
    function no_space($value):bool
    {
        $stringPatron = '/^\S+$/';
        $boolValidacion = preg_match($stringPatron,$value);
        if(!$boolValidacion)
        {
            return $boolValidacion;
        }
        return $boolValidacion;

    }
}
