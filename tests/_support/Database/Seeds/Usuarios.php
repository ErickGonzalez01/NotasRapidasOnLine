<?php

namespace Tests\Support\Models;

use CodeIgniter\Database\Seeder;

use Tests\support\Models\ModelUsuario;

use Faker\Factory;

class Usuarios extends Seeder
{
    public function run()
    {
        //
        $this->SeedUsuarios(75);
    }

    public function SeedUsuarios(int $coutn)
    {
        for ($i = 0; $i <= $coutn; $i++) {
            $faker = Factory::create();
            $data = [
                "nombre" => $faker->firstName,
                "apellido" => $faker->lastName,
                "nombre_usuario_o_correo" => $faker->email(),
                "contrasena" => password_hash(1245678, PASSWORD_BCRYPT),
                "secion" => 1
            ];

            $modelUser = new ModelUsuario();
            $modelUser->insert($data);
            /*$dbusuarios = $this->db->table("usuarios");
            $dbusuarios->insert($data);*/
        }

        /*$fabricator = new Fabricator(ModelUsuario::class,$data);
        $fabricator->create();*/
    }
}
