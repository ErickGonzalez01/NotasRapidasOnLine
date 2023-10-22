<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Notas extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
            "id"=>[
                "type"=>"int",
                "auto_increment"=>true,
                "unsigned"=>true,
            ],
            "id_usuario"=>[
                "type"=>"int",
                "unsigned"=>true
            ],
            "fecha_creado"=>[
                "type"=>"date"
            ],
            "titulo"=>[
                "type"=>"varchar",
                "constraint"=>45
            ],
            "contenido"=>[
                 "type"=>"varchar",
                 "constraint"=>2500
            ]
        ]);

        $this->forge->addKey("id",true,true);
        $this->forge->addKey("titulo",false,false,"titulo");
        $this->forge->addKey("id_usuario",false,false,"id_usuario");
        $this->forge->addForeignKey("id_usuario","usuarios","id","cascade","restricted","id_usuario_usuarios");
        $this->forge->createTable("notas",true,["engine"=>"innodb"]);
    }

    public function down()
    {
        //
    }
}
