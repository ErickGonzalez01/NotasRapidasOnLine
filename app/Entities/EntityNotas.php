<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class EntityNotas extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];

    /**
     * Metodo comprueba si los campos a modificar son diferentes a los ingresados en la base de datos,
     * se debe actualizar este metodo antes de usar "model->save($data);" para evitar exception "Nada que actualizar"
     */
    public function IsNotEqualsUpdate(array $data):bool
    {
        if($this->titulo === $data["titulo"] && $this->contenido === $data["contenido"]){
            return false;
        }
        return true;
    }

    public function IsNotEqualsUpdateTitulo(array $data):bool
    {
        if($this->titulo === $data["titulo"]){
            return false;
        }
        return true;
    }
    public function IsNotEqualsUpdateContenido(array $data):bool
    {
        //$this->CorregitJson();
        
        if($this->contenido === $data["contenido"]){
            return false;
        }
        
        return true;
    }

    /**
     * Metodo usado cuando se va a actualizar un registro y el campo conntenido no se modifica, 
     * obligatoriamente este metodo tiene que ejecutarse antes de "model->save($data);"
     * de lo contradio obtendra una exception 
     */
    public function CorregitJson(){
        $this->contenido = json_encode($this->contenido);
    }
}
