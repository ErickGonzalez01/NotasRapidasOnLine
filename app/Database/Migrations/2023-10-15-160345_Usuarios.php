<?php

namespace App\Database\Migrations;

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
            "correo"=>[
                "type"=>"varchar",
                "constraint"=>45,
                "unique"=>true
            ],
            "contrasena"=>[
                "type"=>"char",
                "constraint"=>60
            ],//
            "rcp_date"=>[
                "type"=>"TIMESTAMP",
                "null"=>true
            ],
            "rcp_contrasena"=>[
                "type"=>"char",
                "constraint"=>60,
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
        $this->forge->addKey("correo",false,true,"correo_key");
        $this->forge->createTable("usuarios",false,["engine"=>"innodb"]);
    }

    public function down()
    {
        //
        $this->forge->dropTable("usuarios");
    }
}
