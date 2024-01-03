<?php

namespace App\Controllers\Usuario;

use App\Controllers\BaseController;
use Config\Services;
use CodeIgniter\API\ResponseTrait;

use App\Models\ModelUsuario;
use App\Entities\EntityUsuario;
use App\Libraries\Response\ResponseAPI;
use CodeIgniter\I18n\Time;

class Autenticacion extends BaseController{

    use ResponseTrait;

    /**
     * Modelo de base de datos de Usuario
     */
    private $model;

    /**
     * Entidad de usuario
     */
    private $entity;

    /** Ayudante de usuario 
     * @var array $helpers
     */
    protected $helpers = ['usuario'];
    
    function __construct(){
        $this->model = new ModelUsuario();
        $this->entity = new EntityUsuario();
    }

    /** Nuevo usuario POST Path 'api/authentication/sigout'
     * Endpoin para que un usuario se registre
     * Type: FormData
     * Arguments:
     *      nombre
     *      apellido
     *      correo
     *      contrasena
    */
    public function NuevoUsuario(){
        $arrayDataPost=[
            "nombre"=>$this->request->getVar("nombre"),
            "apellido"=>$this->request->getVar("apellido"),
            "correo"=>$this->request->getVar("correo"),
            "contrasena"=>password_hash($this->request->getVar("contrasena"),PASSWORD_BCRYPT)
        ];
        $boolValidationDataPost=$this->validate([
            "nombre"=>"required|alpha_numeric_es|max_length[30]",
            "apellido"=>"required|alpha_numeric_es|max_length[30]",
            "correo"=>"required|no_space|valid_email|is_unique[usuarios.correo]",
            "contrasena"=>"required|min_length[8]|max_length[12]",
            "confirmar_contrasena"=>"required|min_length[8]|max_length[12]|matches[contrasena]"
        ]);
        if(!$boolValidationDataPost){
            return $this->respond(ResponseApi::ResponseApiNotas(400,"Error en la validacion de datos.",[$this->validator->getErrors()],["status"=>false]),400,ResponseApi::HTTP_Code(400));
        }

        $this->entity->fill($arrayDataPost);        
        $this->model->insert($this->entity);
        return $this->respond(ResponseApi::ResponseApiNotas(200,"Se ha registrado correctamente.",[],["status"=>true]),200,ResponseApi::HTTP_Code(200));
    }

    /** Iniciar secion POST Path 'api/authentication/login'
     * Endpoin para iniciar sesion
     * Type: FormData
     * Arguments:
     *      correo
     *      contraseña
     */
    public function IniciarSesion(){
        $arrayPostInicio=[
            "correo"=>$this->request->getVar("correo"),
            "contrasena"=>$this->request->getVar("contrasena")
        ];

        $boolValidationDataPost=$this->validate([
            "correo"=>"required|no_space|valid_email",
            "contrasena"=>"required|min_length[8]|max_length[12]"
        ]);

        if(!$boolValidationDataPost){
            return $this->respond(ResponseAPI::ResponseApiNotas(401,"correo o contraseña incorrectos.",[]),401,ResponseApi::HTTP_Code(401));
        }

        $this->entity = $this->model->where("correo",$arrayPostInicio["correo"])->first();

        if(!$this->entity->rcp_contrasena == null){
            if(!password_verify($arrayPostInicio["contrasena"],$this->entity->rcp_contrasena)){
                return $this->respond(ResponseAPI::ResponseApiNotas(401,"correo o contraseña incorrectos.",[],["status"=>false]),401,ResponseApi::HTTP_Code(401));
            } 
            return $this->respond(ResponseAPI::ResponseApiNotas(200,"Escriba su nueva contraseña.",[],["status"=>false,"nueva_contrasena"=>true]),200,ResponseApi::HTTP_Code(200));
        }

        if(!password_verify($arrayPostInicio["contrasena"],$this->entity->contrasena)){
            return $this->respond(ResponseAPI::ResponseApiNotas(401,"correo o contraseña incorrectos.",[],["status"=>false]),401,ResponseApi::HTTP_Code(401));
        }        

        $session = Services::session();
        $arrayDataSession=[
            "id"=>$this->entity->id,
            "usuario"=>$this->entity->correo,
            "nombre"=>$this->entity->nombre,
            "apellido"=>$this->entity->apellido
        ];
        $session->set($arrayDataSession);
        return $this->respond(ResponseAPI::ResponseApiNotas(201,"Ha iniciado secion.",[],["status"=>true,"user"=>GetInfoUserName()]),201,ResponseApi::HTTP_Code(201));
    }
    /** Cerrar sesion GET Path 'api/authentication/logout'
     * Endpoin para cerrar secion
     */
    public function CerrarSecion(){
        $session = Services::session();
        $session->destroy();
        $session->close();
        //return $this->failResourceGone("Sesion serrada");
        return $this->respond(ResponseAPI::ResponseApiNotas(200,"Ha cerrado secion.",[],["status"=>false]),200,ResponseApi::HTTP_Code(200));
    
    }

    /** Recuperar contraseña POST Path 'api/authentication/recoverypassword'
     * Endpoin para recuperar contraseña, se enviara correo con nueva contraseña de un solo uso
     * Type: FormData
     * Arguments:
     *      correo
     */
    public function RecuperarContrasena(){
        $arrayPost =[
            "correo"=>$this->request->getVar("correo")
        ];

        if(!$this->validate(["correo"=>"required|no_space|valid_email"])) return $this->respond(ResponseAPI::ResponseApiNotas(400,"Usuario no existe",[],["status"=>false]),400,ResponseApi::HTTP_Code(400));
        
        $this->entity = $this->model->where("correo",$arrayPost["correo"])->first();

        if($this->entity==null){
            return $this->respond(ResponseAPI::ResponseApiNotas(400,"Usuario no existe",[],["status"=>false]),400,ResponseApi::HTTP_Code(400));
        }

        $this->entity->rcp_contrasena = password_hash("45454545",PASSWORD_BCRYPT); //numero tiene que ser aleatorio

        $this->entity->rcp_date = Time::now();

        $this->model->save($this->entity);

        return $this->respond(ResponseAPI::ResponseApiNotas(201,"Se ha enviado correo de recuperacion, revise su bandeja de entrada.",[],["status"=>true]),201,ResponseApi::HTTP_Code(201));
    }

    /** Nueva contraseña POST Path 'api/authentication/newpassword'
     * Enpoind para recuperar contraseña
     * Type: FormData
     * Arguments:
     *      password_uso_unico
     *      password_new
     *      password_confirm
     */
    public function NuevaContrasena(){
        $arrayPost = [
            "correo"=>$this->request->getVar("correo"),
            "rcp_contrasena" => $this->request->getVar("rcp_contrasena"),
            "contrasena"=>$this->request->getVar("nueva_contrasena"),
            "confirmar_contrasena"=>$this->request->getVar("confirmar_contrasena")
        ];

        if(!$this->validate([
            "correo"=>"required|no_space|valid_email",
            "rcp_contrasena"=>"required|min_length[8]|max_length[12]",
            "nueva_contrasena"=>"required|min_length[8]|max_length[12]",
            "confirmar_contrasena"=>"required|min_length[8]|max_length[12]|matches[nueva_contrasena]",
        ])){
            return $this->respond(ResponseApi::ResponseApiNotas(400,"No se pudo cambiar contraseña, intente nuevamente.",[$this->validator->getErrors()],["status"=>false]),400,ResponseApi::HTTP_Code(400)); 
        }
        //
        $this->entity = $this->model->where("correo",$arrayPost["correo"])->first();

        if(!password_verify($arrayPost["rcp_contrasena"], $this->entity->rcp_contrasena)){
            return $this->respond(ResponseApi::ResponseApiNotas(400,"Contraseña de recuperacion invalida.",[],["status"=>false]),400,ResponseApi::HTTP_Code(400)); 
        }

        //validar duracion de 24 horas para cambiar contraseña.
        //codigo aqui ...

        $this->entity->rcp_contrasena = null;
        $this->entity->rcp_date=null;
        $this->entity->contrasena=password_hash($arrayPost["contrasena"],PASSWORD_BCRYPT);
        $this->model->save($this->entity);
        return $this->respond(ResponseAPI::ResponseApiNotas(200,"Se cambio contraseña, vuelva a iniciar secion.",[],["status"=>true]),200,ResponseAPI::HTTP_Code(200));
    }
}
