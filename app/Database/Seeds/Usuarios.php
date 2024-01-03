<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

use CodeIgniter\Test\Fabricator;

use App\Models\ModelUsuario;

use Faker\Factory;

class Usuarios extends Seeder
{
    public function run()
    {
        //
        $this->SeedUsuarios(100);
    }

    public function SeedUsuarios(int $coutn)
    {
        $faker = Factory::create();
        for ($i = 0; $i <= $coutn; $i++) {

            $fake_correo= $faker->email();

            $data = [
                "nombre" => $faker->firstName,
                "apellido" => $faker->lastName,
                "correo" => $fake_correo,
                "contrasena" => password_hash(12345678, PASSWORD_BCRYPT)
            ];

            $modelUser = new ModelUsuario();

            $entity = $modelUser->where("correo",$fake_correo)->first();

            if(!$entity == null){
                continue;
            }

            $modelUser->insert($data);
        }

        /*$fabricator = new Fabricator(ModelUsuario::class,$data);
        $fabricator->create();*/
    }
}
