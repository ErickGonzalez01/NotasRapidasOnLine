<main class="d-flex justify-content-center">
    
    <form class="card p-3" method="post">
    <h4><?php echo lang("nuevo_usuario.titulo");?></h4>
        <?php 
            if(isset($error)){
                echo '<div class="alert alert-danger" role="alert">';
                foreach($error as $item){                    
                   echo '<p>• ' . $item.'</p>';                    
                }
                echo '</div>';

            }
            if(isset($msg)){
                echo '<div class="alert alert-success" role="alert">';
                echo $msg;
                echo '</div>';
            }
        ?>
        <div class="mb-1">
            <label for="nombre" class="form-label"><?php echo lang("nuevo_usuario.form.nombre");?></label>
            <input type="text" class="form-control" name="nombre" id="nombre" value="<?=$data["nombre"] ?? ""?>">
        </div>
        <div class="mb-1">
            <label for="apellido" class="form-label"><?php echo lang("nuevo_usuario.form.apellido");?></label>
            <input type="text" class="form-control" name="apellido" id="apellido" value="<?=$data["apellido"] ?? ""?>">
        </div>
        <div class="mb-1">
            <label for="nombre_usuario_o_correo" class="form-label"><?php echo lang("nuevo_usuario.form.nombre_de_usuario_o_correo");?></label>
            <input type="text" class="form-control" name="nombre_usuario_o_correo" id="nombre_usuario_o_correo" value="<?=$data["nombre_usuario_o_correo"] ?? ""?>">
        </div>
        <div class="mb-1">
            <label for="contraseña" class="form-label"><?php echo lang("nuevo_usuario.form.contraseña");?></label>
            <input type="password" class="form-control" name="contraseña" id="contraseña" value="<?=$data["contraseña"] ?? ""?>">
        </div>
        <div class="mb-1">
            <label for="confirmar_contraseña" class="form-label"><?php echo lang("nuevo_usuario.form.confirmar_contraseña");?></label>
            <input type="password" class="form-control" name="confirmar_contraseña" id="confirmar_contraseña" value="<?=$data["confirmar_contraseña"] ?? ""?>">
        </div>
        <div class="mb-1 d-flex justify-content-between">            
            <button class="btn btn-primary" type="reset"><?php echo lang("nuevo_usuario.form.cancelar");?></button>
            <button class="btn btn-primary" type="submit"><?php echo lang("nuevo_usuario.form.registrarse");?></button>
        </div>
    </form>
</main>