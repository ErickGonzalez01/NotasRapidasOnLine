<?php

namespace App\Controllers\Notas;

use CodeIgniter\RESTful\ResourceController;
use App\Models\NotasModel;
use CodeIgniter\I18n\Time;
use App\Libraries\Response\ResponseAPI;

class ApiNotas extends ResourceController
{

    protected $modelName = NotasModel::class;
    protected $format    = 'json';
    protected $helpers   = ["usuario"];

    /** Obtener notas GET 'api/user/notes?page=1'
     * Metodo para obtener notas de usuario especifico
     * Arguments
     *      page 
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

    /** Crearnota POST /api/user/notes
     * Metodo para crear una nota nueva
     * Type: FormData
     * Arguments
     *      titulo
     *      contenido
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

        //Validacion
        if (!$validation_dataPost) {
            return $this->respond(ResponseAPI::ResponseApiNotas(400, "Campos vacios", $this->validator->getErrors()), 400, ResponseAPI::HTTP_Code(400));
        }
        //codigo para guardar
        $id = $this->model->insert($dataPost);
        return $this->respond(ResponseAPI::ResponseApiNotas(200, "Se ha guardado correctamente", [], ['id' => $id]), 200, ResponseAPI::HTTP_Code(200));
    }

    /** Obtener notas por id GET '/api/user/notes/{id}'
     * Metodo para obtener una nota por el id por medio de segmento de url 
     */
    public function show($segment = 0)
    {
        $datos = $this->model->notascol()->where("id_usuario",idUsuario())->find($segment);
        //$json = json_decode($datos->contenido);
        return $this->respond(ResponseAPI::ResponseApiNotas(200, '', [], [$datos]), 200, ResponseAPI::HTTP_Code(200));
    }

    /** Actualizar o modificar nota PUT PATH /api/user/notes/{id}
     * Metodo para actualizar una nota
     * Type: x-www-form-urlencoded
     * Arguments
     *      titulo
     *      contenido
     * ademas se le para el id parmedio de la url
    */
    public function update($segment = 0)
    {
        //Obtener el metod PUT o PATCH
        $strMethodHttp = $this->request->getMethod();

        //Obteniendo la nota especificada
        $entityNota = $this->model->where("id_usuario",idUsuario())->find($segment); //filtrar por usuario pendiente 'where'

        //Obtener datos put y patch
        $strPutTitulo = $this->request->getRawInput()["titulo"] ?? null;
        $strPutContenido = $this->request->getRawInput()["contenido"] ?? null;

        //Estado de la actualizacion
        $status=false;

        //Comprobando si la nota existe
        if($entityNota == null){
            return $this->respond(ResponseApi::ResponseApiNotas(200,"No se puede actualizar, nota no existe.",[],["status"=>$status]),200,ResponseAPI::HTTP_Code(200));
        }

        //Switch para si la solicitud es put o si es patch
        switch($strMethodHttp){

            case "put": //Actualiza toda la nota

                //Coprobar si los argumentos enviados existen
                if($strPutContenido==null && $strPutTitulo==null) return $this->respond(ResponseApi::ResponseApiNotas(201,"Nada que actualizar.",[],["status"=>$status]),200,ResponseApi::HTTP_Code(200));
                
                //Validacion
                if($this->validateData([
                        "titulo"    =>  $strPutTitulo,
                        "contenido" =>  $strPutContenido
                    ],[
                        "titulo"    =>  "required|alpha_numeric_es|max_length[45]",
                        "contenido" =>  "required|valid_json"
                    ])){
                        
                        $is_not_equals=$entityNota->IsNotEqualsUpdate(["titulo"=>$strPutTitulo, "contenido"=>$strPutContenido]);

                        if($is_not_equals){
                            $entityNota->titulo     =   $strPutTitulo;
                            $entityNota->contenido  =   $strPutContenido;
                            $status = $this->model->save($entityNota);
                        }
                        
                        return $this->respond(ResponseApi::ResponseApiNotas(201,"Se actualizo esta nota.",[],["status"=>$status]),200,ResponseAPI::HTTP_Code(200));
                    }
                    return $this->respond(ResponseApi::ResponseApiNotas(200,"Datos incompletos.",[$this->validator->getErrors()],["status"=>$status]),200,ResponseApi::HTTP_Code(200));

                break;

            case "patch": // Se actualisa solo el titulo o solo la nota

                //Actualiza el titulo
                if(!$strPutTitulo==null){
                    if($this->validateData(["titulo"=>$strPutTitulo],["titulo"=>"required|alpha_numeric_es|max_length[45]"])){
                        
                        if($entityNota->IsNotEqualsUpdateTitulo(["titulo"=>$strPutTitulo])){
                            $entityNota->titulo = $strPutTitulo;
                            $entityNota->CorregitJson();
                            $status =$this->model->save($entityNota);
                        }                        
                        return $this->respond(ResponseApi::ResponseApiNotas(201,"Se actualizo el titulo.",[],["status"=>$status]),200,ResponseApi::HTTP_Code(200));
                    }
                    return $this->respond(ResponseApi::ResponseApiNotas(201,"Datos incompletos.",[$this->validator->getErrors()],["status"=>$status]),200,ResponseApi::HTTP_Code(200));
                }
                
                //Actualiza el contenido
                if(!$strPutContenido==null){
                    if($this->validateData(["contenido"=>$strPutContenido],["contenido"=>"required|valid_json"])){
                
                        $is_not_exist=$entityNota->IsNotEqualsUpdateContenido(["contenido"=>$strPutContenido]);
                        
                        if($is_not_exist){
                            $entityNota->contenido = $strPutContenido;
                            $status = $this->model->save($entityNota);
                        }

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
