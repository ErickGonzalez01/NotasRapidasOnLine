<?php 

namespace App\Libraries\Autenticacion;

use App\Libraries\Autenticacion\Interfaces\IAutJWT;
use App\Libraries\Autenticacion\Interfaces\IConfigJWT;
use App\Libraries\Autenticacion\Interfaces\IObjetoJwt;

use App\Libraries\Autenticacion\App\DecodeJWT;
use App\Libraries\Autenticacion\App\EncodeJWT;
use App\Libraries\Autenticacion\App\ObjetoJwt;
use App\Libraries\Autenticacion\Config\AuthJWT;
use Exception;

class AutenticacionJWT{

    private IAutJWT $decode;
    private IAutJWT $encode;
    private IConfigJWT $configuracion;
    private IObjetoJwt $objetoJWT;
    private $request;
    private ?string $token;
    private ?array $data;

    public function __construct(IConfigJWT $configuracio = null)
    {
        $this->configuracion = new AuthJWT;
        $this->request = service("request");
        $this->token = explode(" ",$this->request->header("Authorization") ?? "")[2] ?? "";
    }

    public function GetDecode()
    {

        $this->decode = new DecodeJWT($this->configuracion,$this->token);
        $objeto = $this->decode->Get();
        /*if(ENVIRONMENT == "development"){
            if($objeto->getError()!=null){
                throw new Exception("Error al decodificar el token: ".$objeto->getError());
            }
        }*/

        if($objeto->getError()!=null){
            return $objeto->getError();
        }else{
            return (array)$objeto->getBody()["data"];
        }
        
    }

    public function GetEncode(string $correo,array $data){
        $this->encode = new EncodeJWT($this->configuracion,$data,$correo);
        $objeto=$this->encode->Get();
        if($objeto->getError()!=null && ENVIRONMENT == "development"){
            throw new Exception("Ocurrio un error al crear el token.");
        }
        return $objeto->getBody();
    }

}