<?php

namespace App\Controllers\Usuario;

use App\Controllers\BaseController;
use Config\Services;
use CodeIgniter\API\ResponseTrait;

use App\Models\ModelUsuario;
use App\Entities\EntityUsuario;
use App\Libraries\Response\ResponseAPI;
use CodeIgniter\I18n\Time;
use App\Libraries\Emails\Saludo;
use App\Libraries\Autenticacion\Random;
use App\Libraries\Emails\RecuperacionDePassWord;
use App\Libraries\Autenticacion\AutenticacionJWT;

class Autenticacion extends BaseController
{

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

    function __construct()
    {
        $this->model = new ModelUsuario();
        $this->entity = new EntityUsuario();
    }

    /** Nuevo usuario POST 'api/authentication/sigout'
     * Endpoin para que un usuario se registre
     * Type: FormData
     * Arguments:
     *      nombre
     *      apellido
     *      correo
     *      contrasena
     */
    public function NuevoUsuario()
    {
        //Datos post
        $arrayDataPost = [
            "nombre" => $this->request->getVar("nombre"),
            "apellido" => $this->request->getVar("apellido"),
            "correo" => $this->request->getVar("correo"),
            "contrasena" => password_hash($this->request->getVar("contrasena"), PASSWORD_BCRYPT)
        ];

        //Validacion de datos 
        $boolValidationDataPost = $this->validate([
            "nombre" => "required|alpha_numeric_es|max_length[30]",
            "apellido" => "required|alpha_numeric_es|max_length[30]",
            "correo" => "required|no_space|valid_email|is_unique[usuarios.correo]",
            "contrasena" => "required|min_length[8]|max_length[12]",
            "confirmar_contrasena" => "required|min_length[8]|max_length[12]|matches[contrasena]"
        ]);

        if (!$boolValidationDataPost) {
            return $this->respond(ResponseApi::ResponseApiNotas(400, "Error en la validacion de datos.", [$this->validator->getErrors()], ["status" => false]), 400, ResponseApi::HTTP_Code(400));
        }

        //Asignacion de datos a la entidad usuatio 'entity'
        $this->entity->fill($arrayDataPost);
        //Guardando el nuevo usuario
        $boolResgister = $this->model->insert($this->entity);

        //Enviar email de bienbenida
        if ($boolResgister) {
            $saludar = new Saludo($this->entity->correo, $this->entity->nombre . ' ' . $this->entity->apellido);
            $saludar->Enviar();
        }
        //Retorno de la respuesta
        return $this->respond(ResponseApi::ResponseApiNotas(200, "Se ha registrado correctamente.", [], ["status" => true]), 200, ResponseApi::HTTP_Code(200));
    }

    /** Iniciar secion POST 'api/authentication/login'
     * Endpoin para iniciar sesion
     * Type: FormData
     * Arguments:
     *      correo
     *      contraseña
     */
    public function IniciarSesion()
    {
        //Datos post
        $arrayPostInicio = [
            "correo" => $this->request->getVar("correo"),
            "contrasena" => $this->request->getVar("contrasena")
        ];

        //Validacion
        $boolValidationDataPost = $this->validate([
            "correo" => "required|no_space|valid_email",
            "contrasena" => "required|min_length[8]|max_length[12]"
        ]);

        if (!$boolValidationDataPost) {
            return $this->respond(ResponseAPI::ResponseApiNotas(401, "correo o contraseña incorrectos.", [],["status"=>false]), 401, ResponseApi::HTTP_Code(401));
        }

        //buscando el usuario y asignandolo a la entity
        $this->entity = $this->model->where("correo", $arrayPostInicio["correo"])->first();
        //Linea 116

        if($this->entity==null){
            return $this->respond(ResponseAPI::ResponseApiNotas(401, "correo o contraseña incorrectos.", [], ["status" => false]), 401, ResponseApi::HTTP_Code(401));
        }

        //comprobando si tiene contraseña de recuperacion
        if (!$this->entity->rcp_contrasena == null) {
            if (!password_verify($arrayPostInicio["contrasena"], $this->entity->rcp_contrasena)) {
                return $this->respond(ResponseAPI::ResponseApiNotas(401, "correo o contraseña incorrectos.", [], ["status" => false]), 401, ResponseApi::HTTP_Code(401));
            }
            return $this->respond(ResponseAPI::ResponseApiNotas(200, "Escriba su nueva contraseña.", [], ["status" => false, "nueva_contrasena" => true]), 200, ResponseApi::HTTP_Code(200));
        }

        //verifivando contraseña actual
        if (!password_verify($arrayPostInicio["contrasena"], $this->entity->contrasena)) {
            return $this->respond(ResponseAPI::ResponseApiNotas(401, "correo o contraseña incorrectos.", [], ["status" => false]), 401, ResponseApi::HTTP_Code(401));
        }

        //Iniciando servicios de secion
        /*
        $session = Services::session();
        $session->start();
        $arrayDataSession = [
            "id" => $this->entity->id,
            "usuario" => $this->entity->correo,
            "nombre" => $this->entity->nombre,
            "apellido" => $this->entity->apellido
        ];
        $session->set($arrayDataSession);
        */
        $arrayDataSession = [
            "id" => $this->entity->id,
            "usuario" => $this->entity->correo,
            "nombre" => $this->entity->nombre,
            "apellido" => $this->entity->apellido
        ];

        $autJWT = new AutenticacionJWT();

        $token = $autJWT->GetEncode($this->entity->correo,$arrayDataSession);
        //Retornando respuestas
        return $this->respond(ResponseAPI::ResponseApiNotas(201, "Ha iniciado secion.", [], ["status" => true,"token" => $token, "user" => ["nombre" => $this->entity->nombre,"apellido" => $this->entity->apellido]]), 201, ResponseApi::HTTP_Code(201));
    }
    /** Cerrar sesion GET Path 'api/authentication/logout'
     * Endpoin para cerrar secion
     */
    public function CerrarSecion()
    {
        //Creando intancia de la clase de secion
        /*$session = Services::session();
        $session->destroy(); //destruyendo la secion
        $session->close(); //cerrando secion
        return $this->respond(ResponseAPI::ResponseApiNotas(200, "Ha cerrado secion.", [], ["status" => false]), 200, ResponseApi::HTTP_Code(200));*/
    }

    /** Recuperar contraseña POST 'api/authentication/recoverypassword'
     * Endpoin para recuperar contraseña, se enviara correo con nueva contraseña de un solo uso
     * Type: FormData
     * Arguments:
     *      correo
     */
    public function RecuperarContrasena()
    {
        //Datos del post
        $arrayPost = [
            "correo" => $this->request->getVar("correo")
        ];

        //Validacion en una sola linea
        if (!$this->validate(["correo" => "required|no_space|valid_email"])) return $this->respond(ResponseAPI::ResponseApiNotas(400, "Usuario no existe", [], ["status" => false]), 400, ResponseApi::HTTP_Code(400));

        //Asignando usuario a la clase entidad 'entity'
        $this->entity = $this->model->where("correo", $arrayPost["correo"])->first();

        //Verificando si el usuario existe
        if ($this->entity == null) {
            return $this->respond(ResponseAPI::ResponseApiNotas(400, "Usuario no existe", [], ["status" => false]), 400, ResponseApi::HTTP_Code(400));
        }

        //generando contraseña de 8 caracteres
        $random = new Random();
        $random->SetLongitud(8);
        $random->Run();
        $strAleatorio = $random->GetSalida();

        //Asignando contraseña de un solo uso
        $this->entity->rcp_contrasena = password_hash($strAleatorio, PASSWORD_BCRYPT); //numero tiene que ser aleatorio
        $this->entity->rcp_date = Time::now(); //Asignando tiempo en que fue creado

        $status = $this->model->save($this->entity);

        //Enviando correo con clave de un solo uso
        if ($status) {
            $recuperarPassword = new RecuperacionDePassWord($this->entity->correo, $this->entity->nombre . " " . $this->entity->apellido, $strAleatorio);
            $recuperarPassword->Enviar();

        }

        //Retornando respuesta
        return $this->respond(ResponseAPI::ResponseApiNotas(201, "Se ha enviado correo de recuperacion, revise su bandeja de entrada.", [], ["status" => true]), 201, ResponseApi::HTTP_Code(201));
    }

    /** Nueva contraseña POST 'api/authentication/newpassword'
     * Enpoind para recuperar contraseña
     * Type: FormData
     * Arguments:
     *      correo
     *      rcp_contrasena
     *      nueva_contrasena
     *      confirmar_contrasena
     */
    public function NuevaContrasena()
    {
        //Datos post
        $arrayPost = [
            "correo" => $this->request->getVar("correo"),
            "rcp_contrasena" => $this->request->getVar("rcp_contrasena"),
            "contrasena" => $this->request->getVar("nueva_contrasena"),
            "confirmar_contrasena" => $this->request->getVar("confirmar_contrasena")
        ];

        //Validacion
        if (!$this->validate([
            "correo" => "required|no_space|valid_email|is_not_unique[usuarios.correo]",
            "rcp_contrasena" => "required|min_length[8]|max_length[12]",
            "nueva_contrasena" => "required|min_length[8]|max_length[12]",
            "confirmar_contrasena" => "required|min_length[8]|max_length[12]|matches[nueva_contrasena]",
        ])) {
            return $this->respond(ResponseApi::ResponseApiNotas(400, "No se pudo cambiar contraseña, intente nuevamente.", [$this->validator->getErrors()], ["status" => false]), 400, ResponseApi::HTTP_Code(400));
        }

        //Asignacion del usuario a la clase 'entity'
        $this->entity = $this->model->where("correo", $arrayPost["correo"])->first();

        //Verificando contraseña de recuperacion
        if (!password_verify($arrayPost["rcp_contrasena"], $this->entity->rcp_contrasena)) {
            return $this->respond(ResponseApi::ResponseApiNotas(400, "Contraseña de recuperacion invalida.", [], ["status" => false]), 400, ResponseApi::HTTP_Code(400));
        }

        //validar duracion de 24 horas para cambiar contraseña.
        //codigo aqui ... pendiente funcion

        //Cambiando contraseña
        $this->entity->rcp_contrasena = null; //Eliminando contraseña de recuperacion
        $this->entity->rcp_date = null; //Eliminando fecha
        $this->entity->contrasena = password_hash($arrayPost["contrasena"], PASSWORD_BCRYPT);
        $this->model->save($this->entity);
        return $this->respond(ResponseAPI::ResponseApiNotas(200, "Se cambio contraseña, vuelva a iniciar secion.", [], ["status" => true]), 200, ResponseAPI::HTTP_Code(200));
    }
}
