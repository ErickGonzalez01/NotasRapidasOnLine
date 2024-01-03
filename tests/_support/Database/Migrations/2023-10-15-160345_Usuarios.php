<?php

namespace Tests\Support\Database\Migrations;

use CodeIgniter\Database\Migration;

class Usuarios extends Migration
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
            "nombre"=>[
                "type"=>"varchar",
                "constraint"=>30
            ],
            "apellido"=>[
                "type"=>"varchar",
                "constraint"=>30,
            ],
            "nombre_usuario_o_correo"=>[
                "type"=>"varchar",
                "constraint"=>45,
                "unique"=>true
            ],
            "contrasena"=>[
                "type"=>"char",
                "constraint"=>60
            ],
            "secion"=>[
                "type"=>"bool",
                "null"=>true
            ],
            "created_at"=>[
                "type"=>"TIMESTAMP",
                "null"=>true
            ],
            "updated_at"=>[
                "type"=>"TIMESTAMP",
                "null"=>true
            ],
            "deleted_at"=>[
                "type"=>"TIMESTAMP",
                "null"=>true
            ]
        ]);

        $this->forge->addKey("id",true,true);
        $this->forge->addKey("nombre_usuario_o_correo",false,true,"correo");
        $this->forge->createTable("usuarios",false,["engine"=>"innodb"]);
    }

    public function down()
    {
        //
        $this->forge->dropTable("usuarios");
    }
}
