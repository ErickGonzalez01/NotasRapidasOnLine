<?php namespace App\Libraries\QuillPHP;

use App\Models\NotasModel;
use App\Entities\EntityNotas;

class QuillPHP{

    private static NotasModel $model;

    private EntityNotas $entity;

    function __construct(EntityNotas $notas){
        $this->entity=$notas;
    }
    public function Save():void {
        self::$model = new NotasModel();
        self::$model->insert($this->entity);
    }

    public static function Get():NotasModel {
        self::$model = new NotasModel();
        return self::$model;
    }
}