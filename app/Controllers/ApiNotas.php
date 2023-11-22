<?php namespace App\Controllers;

use App\Entities\EntityNotas;
use App\Libraries\QuillPHP\QuillPHP;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\I18n\Time;

class ApiNotas extends BaseController{

    use ResponseTrait;

    function ListarNotas(){
        helper("usuario");

        $model = QuillPHP::Get();
        $arrayDataModel=$model->where("id_usuario",GetInfoUsuario()["id"])->orderBy("id","desc")->findAll();

        return $this->respond($arrayDataModel);
    }

    function CrearNotas(){
        helper("usuario");
        $arrayData=[
            "id_usuario"    =>  GetInfoUsuario()["id"], 
            "fecha_creado"  =>  Time::now(),
            "titulo"        =>  $this->request->getJsonVar("titulo"),
            "contenido"     =>  json_encode($this->request->getJsonVar("contenido"))
        ];

        $arrayDataRules = [
            "titulo"    =>  "required|max_length[20]|alpha_numeric_space",
            "contenido" =>  "required|valid_json"
        ];
        $boolValidateData= $this->validateData($arrayData,$arrayDataRules);

        if(!$boolValidateData){
            return $this->respond([
                "msg"=>"Ocurrio un erro con los datos ingresados, intente nuevamente",
                "error"=>$this->validator->getErrors(),
                "body"=>$this->request->getJSON()
            ],404,"empty");
        }

        $entityNotas = new EntityNotas($arrayData);
        $quill = new QuillPHP($entityNotas);
        $quill->Save();
        return $this->respondCreated(["Se creo una nota"]);
    }

}

