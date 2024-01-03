<main>
    <div class="d-flex justify-content-center">
        <form class="card p-2" method="post">
        <h4>Inicio de sesión</h4>
            <?php
                if(isset($error)){
                    echo '<div class="alert alert-danger" role="alert">';                  
                    echo '<p>' . $error.'</p>';                   
                    echo '</div>';
                }
                if(isset($msg)){
                    echo '<div class="alert alert-success" role="alert">';
                    echo $msg;
                    echo '</div>';
                }
            ?>
            <div>
                <label class="form-label" for="nombre_usuario_o_correo">Nombre de usuario o correo:</label>
                <input class="form-control" name="nombre_usuario_o_correo" id="nombre_usuario_o_correo">
            </div>
            <div>
                <label class="form-label" for="contraseña">contraseña</label>
                <input class="form-control" type="password" name="contraseña" id="contraseña">
            </div>
            <div>
                <a href="<?=base_url("nuevo")?>">¿No tines cuenta? registrate</a>
            </div>
            <div>
                <button class="btn btn-primary" type="reset">Cancelar</button>
                <button class="btn btn-primary" type="submit">Iniciar secion</button>
            </div>
        </form>
    </div>

</main>