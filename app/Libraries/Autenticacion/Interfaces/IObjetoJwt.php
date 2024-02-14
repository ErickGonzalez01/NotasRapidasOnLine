<?php 
namespace App\Libraries\Autenticacion\Interfaces; 

interface IObjetoJwt{
    public function getBody():string|array;
    public function getError():null|string;
}