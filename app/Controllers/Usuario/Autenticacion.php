<?php

namespace App\Controllers\Usuario;

use App\Controllers\BaseController;
use App\Models\ModelUsuario;
use Config\Services;

class Autenticacion extends BaseController{
    public function NuevoUsuario(){
        if($this->request->is("get")){
            return $this->RenderView("autenticacion/nuevo");
        }
        $arrayDataPost=[
            "nombre"=>$this->request->getVar("nombre"),
            "apellido"=>$this->request->getVar("apellido"),
            "nombre_usuario_o_correo"=>$this->request->getVar("nombre_usuario_o_correo"),
            "contrasena"=>password_hash($this->request->getVar("contraseña"),PASSWORD_BCRYPT)
        ];
        $boolValidationDataPost=$this->validate([
            "nombre"=>"required|alpha_numeric_es",
            "apellido"=>"required|alpha_numeric_es",
            "nombre_usuario_o_correo"=>"required|user_name|no_space|is_unique[usuarios.nombre_usuario_o_correo]",
            "contraseña"=>"required|min_length[8]|max_length[12]",
            "confirmar_contraseña"=>"required|min_length[8]|max_length[12]|matches[contraseña]"
        ]);
        if(!$boolValidationDataPost){
            return $this->RenderView("autenticacion/nuevo",["error"=>$this->validator->getErrors(),"data"=>$this->request->getPost()]);
        }

        $modelUsuario = new ModelUsuario();
        $modelUsuario->insert($arrayDataPost);
        return $this->RenderView("autenticacion/nuevo",["msg"=>lang("nuevo_usuario.msg")]);        
    }
    public function IniciarSesion(){
        if($this->request->is("get")){
            return $this->RenderView("autenticacion/inicio");
        }
        $arrayPostInicio=[
            "nombre_usuario_o_correo"=>$this->request->getVar("nombre_usuario_o_correo"),
            "contraseña"=>$this->request->getVar("contraseña")
        ];

        $boolValidationDataPost=$this->validate([
            "nombre_usuario_o_correo"=>"required|user_name|no_space",
            "contraseña"=>"required|min_length[8]|max_length[12]"
        ]);

        if(!$boolValidationDataPost){
            return $this->RenderView("autenticacion/inicio",["error"=>"Usuario o contraseña incorrecto"]);
        }

        $modelUsuario = new ModelUsuario();
        $entityUsuario = $modelUsuario->where("nombre_usuario_o_correo",$arrayPostInicio["nombre_usuario_o_correo"])->first();

        if($entityUsuario==null){
            return $this->RenderView("autenticacion/inicio",["error"=>"Usuario o contraseña incorrecto"]);
        }

        if(!password_verify($arrayPostInicio["contraseña"],$entityUsuario->contrasena)){
            return $this->RenderView("autenticacion/inicio",["error"=>"Usuario o contraseña incorrecto"]);
        }

        $session = Services::session();
        $arrayDataSession=[
            "usuario"=>$entityUsuario->nombre_usuario_o_correo,
            "nombre"=>$entityUsuario->nombre,
            "apellido"=>$entityUsuario->apellido
        ];
        $session->set($arrayDataSession);
        return redirect()->route("/");

        //return $this->RenderView("autenticacion/inicio",["msg"=>"Inicio de secion con exito"]);


    }
    public function CerrarSecion(){
        $session = Services::session();
        $session->destroy();
        $session->close();
        return redirect()->route("inicio");
    }
    public function RecuperarContraseña(){

    }
    public function RenderView(string $view,array $data = [],array $options = []):string{
        return view('layout/header').view($view,$data,$options).view("layout/footer");
    }
}
