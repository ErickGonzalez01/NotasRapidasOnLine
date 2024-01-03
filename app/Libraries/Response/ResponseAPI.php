<?php

namespace App\Libraries\Response;

class ResponseAPI{
private static $http_codes = array(
    100 => 'Continuar',
    101 => 'Cambiando protocolos',
    200 => 'Correcto',
    201 => 'Creado',
    202 => 'Aceptado',
    203 => 'Información no autorizada',
    204 => 'Sin contenido',
    205 => 'Contenido restablecido',
    206 => 'Contenido parcial',
    300 => 'Múltiples opciones',
    301 => 'Movido permanentemente',
    302 => 'Encontrado',
    303 => 'Ver otro',
    304 => 'No modificado',
    305 => 'Usar proxy',
    306 => '(No utilizado)',
    307 => 'Redirección temporal',
    400 => 'Solicitud incorrecta',
    401 => 'No autorizado',
    402 => 'Pago requerido',
    403 => 'Prohibido',
    404 => 'No encontrado',
    405 => 'Método no permitido',
    406 => 'No aceptable',
    407 => 'Se requiere autenticación de proxy',
    408 => 'Tiempo de espera de la solicitud',
    409 => 'Conflicto',
    410 => 'Desaparecido',
    411 => 'Longitud requerida',
    412 => 'Falló la condición previa',
    413 => 'Entidad de solicitud demasiado grande',
    414 => 'URI de solicitud demasiado largo',
    415 => 'Tipo de medio no soportado',
    416 => 'Rango solicitado no satisfactorio',
    417 => 'Falló la expectativa',
    500 => 'Error interno del servidor',
    501 => 'No implementado',
    502 => 'Puerta de enlace incorrecta',
    503 => 'Servicio no disponible',
    504 => 'Tiempo de espera de la puerta de enlace',
    505 => 'Versión HTTP no compatible'
);


    /**
     * Metodo para respuestas api
     * @param int $status recibe un codigo http
     * @param string $mensaje mensaje relacionado a la respuesta
     * @param array $error array para poner solo errores
     * @param array $data array para cargar datos de la respuesta
     * @return array
     */
    public static function ResponseApiNotas(int $status=200,string $mensaje="",array $error=[],array $data=[]){
        return [
            "status"=>$status,
            "message"=>$mensaje,
            "errors"=>$error,
            "data"=>$data
        ];
    }

    public static function HTTP_Code(int $status){
        if(!array_key_exists($status,self::$http_codes)){
            throw new \Exception("El argumento ingresado no es valido");
        }
        return self::$http_codes[$status];
    }
}