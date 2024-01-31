<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\EntityNotas;
class NotasModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'notas';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = EntityNotas::class;
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ["id","id_usuario","fecha_creado","titulo","contenido"];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = ["JsonToArray"];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    // Methods

    public function notascol(){
        $this->builder()->select("id, titulo, contenido");
        return $this;
    }

    //Callbacks
    public function JsonToArray($data){
        $dataBase=$data["data"];
        if(is_array($dataBase)){
            $d=[];
            foreach($dataBase as $enty){
                $json = json_decode($enty->contenido,null,);
                $enty->contenido = $json;
                $d[] = $enty;            
            }
            $data["data"]=$dataBase;
            return $data;
        }

        if(is_null($dataBase)){
            return $data;
        }

        $json = json_decode($dataBase->contenido);
        $data["data"]->contenido=$json;
        return $data;        
    }
}
