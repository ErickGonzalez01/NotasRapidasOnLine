<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Config\Services;
use App\Libraries\Response\ResponseAPI;
use \CodeIgniter\API\ResponseTrait;

class Autenticacion implements FilterInterface
{
    use ResponseTrait;
    protected $response;// = Services::response();

    public function __construct()
    {
        $this->response = Services::response();
    }


    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script
     * execution will end and that Response will be
     * sent back to the client, allowing for error pages,
     * redirects, etc.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return mixed
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        //
        $session = Services::session();
        //$response = Services::response();

        if($session->has("usuario")==false and $session->has("nombre")==false and $session->has("apellido")==false){

            return $this->respond(ResponseAPI::ResponseApiNotas(401,"Primero debe iniciar secion.",[],["status"=>false]),401,ResponseAPI::HTTP_Code(401));
        }
    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return mixed
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
