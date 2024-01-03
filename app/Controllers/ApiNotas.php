<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\NotasModel;
use CodeIgniter\I18n\Time;
use App\Libraries\Response\ResponseAPI;

class ApiNotas extends ResourceController
{

    protected $modelName = NotasModel::class;
    protected $format    = 'json';
    protected $helpers   = ["usuario"];

    /** GET Path 'api/user/notes?page=1'
     * Parametros get 'int page' para la paginacion 
     */
    public function index()
    {
        $notas = $this->model->notascol()->where("id_usuario", idUsuario())->paginate(25);
        $pager = $this->model->pager;
        $numeroDePaginas = $pager->getPageCount();

        $datos = [
            "notas" => $notas,
            "pagerOptions" => [
                "numeroDePaginas" => $numeroDePaginas
            ]
        ];
        return $this->respond(ResponseAPI::ResponseApiNotas(200, '', [], [$datos]), 200, ResponseAPI::HTTP_Code(200));
    }

    /** POST /api/user/notes
     * Metodo para crear una nota nueva
     * recibe dos parametros post 'titulo y contenido
     */
    public function create()
    {
        $dataPost = [
            "id_usuario"    =>  idUsuario(),
            "fecha_creado"  =>  Time::now(),
            "titulo"        =>  $this->request->getVar("titulo"),
            "contenido"     =>  $this->request->getVar("contenido")
        ];

        $validation_dataPost = $this->validate([
            "titulo"        => "required|alpha_numeric_es|max_length[45]",
            "contenido"     => "required|valid_json"
        ]);

        if (!$validation_dataPost) {
            return $this->respond(ResponseAPI::ResponseApiNotas(400, "Campos vacios", $this->validator->getErrors()), 400, ResponseAPI::HTTP_Code(400));
        }
        //codigo para guardar
        $id = $this->model->insert($dataPost);
        return $this->respond(ResponseAPI::ResponseApiNotas(200, "Se ha guardado correctamente", [], ['id' => $id]), 200, ResponseAPI::HTTP_Code(200));
    }

    /** GET /api/user/notes/{id}
     * Metodo para obtener una nota por el id por medio de segmento de url 
     */
    public function show($segment = 0)
    {
        return $this->respond(ResponseAPI::ResponseApiNotas(200, '', [], [$this->model->notascol()->where("id_usuario",idUsuario())->find($segment)]), 200, ResponseAPI::HTTP_Code(200));
    }

    /** PUT PATH /api/user/notes/{id}
     * Metodo para actualizar una nota recibe dos argumentos post 'titulo' y 'contenido'
     * ademas se le para el id parmedio de la url
    */
    public function update($segment = 0)
    {
        $strMethodHttp = $this->request->getMethod();
        $entityNota = $this->model->where("id_usuario",idUsuario())->find($segment); //filtrar por usuario pendiente 'where'
        $strPutTitulo = $this->request->getRawInput()["titulo"] ?? null;
        $strPutContenido = $this->request->getRawInput()["contenido"] ?? null;
        $status=false;
        if($entityNota == null){
            return $this->respond(ResponseApi::ResponseApiNotas(200,"No se puede actualizar, nota no existe.",[],["status"=>$status]),200,ResponseAPI::HTTP_Code(200));
        }
        switch($strMethodHttp){
            case "put":
                if($strPutContenido==null && $strPutTitulo==null) return $this->respond(ResponseApi::ResponseApiNotas(201,"Nada que actualizar.",[],["status"=>$status]),200,ResponseApi::HTTP_Code(200));
                    if($this->validateData([
                        "titulo"    =>  $strPutTitulo,
                        "contenido" =>  $strPutContenido
                    ],[
                        "titulo"    =>  "required|alpha_numeric_es|max_length[45]",
                        "contenido" =>  "required|valid_json"
                    ])){
                        $entityNota->titulo     =   $strPutTitulo;
                        $entityNota->contenido  =   $strPutContenido;
                        $status = $this->model->save($entityNota);
                        return $this->respond(ResponseApi::ResponseApiNotas(201,"Se actualizo esta nota.",[],["status"=>$status]),200,ResponseAPI::HTTP_Code(200));
                    }
                    return $this->respond(ResponseApi::ResponseApiNotas(200,"Datos incompletos.",[$this->validator->getErrors()],["status"=>$status]),200,ResponseApi::HTTP_Code(200));

                break;
            case "patch":
                if(!$strPutTitulo==null){
                    if($this->validateData(["titulo"=>$strPutTitulo],["titulo"=>"required|alpha_numeric_es|max_length[45]"])){
                        $entityNota->titulo = $strPutTitulo;
                        $status =$this->model->save($entityNota);
                        return $this->respond(ResponseApi::ResponseApiNotas(201,"Se actualizo el titulo.",[],["status"=>$status]),200,ResponseApi::HTTP_Code(200));
                    }
                    return $this->respond(ResponseApi::ResponseApiNotas(201,"Datos incompletos.",[$this->validator->getErrors()],["status"=>$status]),200,ResponseApi::HTTP_Code(200));
                }
                
                if(!$strPutContenido==null){
                    if($this->validateData(["contenido"=>$strPutContenido],["contenido"=>"required|valid_json"])){
                        $entityNota->contenido = $strPutContenido;
                        $status = $this->model->save($entityNota);
                        return $this->respond(ResponseApi::ResponseApiNotas(201,"Se actualizo el contenido.",[],["status"=>$status]),200,ResponseApi::HTTP_Code(200));
                    }
                    return $this->respond(ResponseApi::ResponseApiNotas(201,"Datos incompletos.",[$this->validator->getErrors()],["status"=>$status]),200,ResponseApi::HTTP_Code(200));
                }

                return $this->respond(ResponseApi::ResponseApiNotas(201,"Nada que actualizar.",[],["status"=>$status]),200,ResponseApi::HTTP_Code(200));
                break;
        }
     }

    /** DELETE /api/user/notes/{id}
     * Metodo para eliminar una nota, recibe un segmento id
     */
    public function delete($segment = 0)
    {
        $status=false;
        $status=$this->model->where("id_usuario",idUsuario())->delete($segment);
        return $this->respond(ResponseAPI::ResponseApiNotas(200, "Eliminando nota",[],["status"=>$status]), 200, ResponseAPI::HTTP_Code(200));
    }
}
