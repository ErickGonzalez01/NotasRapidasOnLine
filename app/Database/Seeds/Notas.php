<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

use App\Models\NotasModel;

use Faker\Factory;

class Notas extends Seeder
{
    public function run()
    {
        //
        $this->SeedNotas(20000);
    }

    public function SeedNotas(int $count)
    {
        for ($i = 0; $i <= $count; $i++) {
            $fake = Factory::create();
            $data = [
                "id_usuario" => $fake->numberBetween(1,103),
                "fecha_creado" => $fake->date(),
                "titulo" => $fake->sentence(3),
                "contenido" => json_encode("{
                ops: [
                  {
                    insert: 'Gandalf',
                    attributes: { bold: true }
                  },
                  {
                    insert: ' el '
                  },
                  {
                    insert: 'Gris',
                    attributes: { color: '#cccccc' }
                  }
                ]
              }")
            ];
            $notasModel = new NotasModel();
            $notasModel->insert($data);
        }
    }

}
