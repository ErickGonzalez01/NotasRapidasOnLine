<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NotasRapidasOnLine</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css.map">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="shortcut icon" href="/img/notas.png" type="image/png">
</head>

<body class="bg-notas">
    <nav class="bg-navbar ps-3 pe-3">
        <h2 class="c-navbar">NotasRapidasOnLine</h2>
    </nav>
    <section class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item" aria-current="page">
                <a href="<?=base_url("doc")?>">Inicio</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                <a class="text-white" href="<?=base_url("doc/authentication")?>">Autenticación</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">
                <a href="<?=base_url("doc/notes")?>">Notas</a>
            </li>
        </ol>
    </section>
    <main class="container">
        <article class="bg-nota card rounded p-3">
            <h4 class="p-font">Documentacion para usar la api de NotasRapidasOnline</h4>
            <p class="p-font">En esta documentacion se muetras exactamente como usar nuestra api</p>
            <h5>Documentacion para el modulo <span class="badge text-bg-secondary">Autenticacion</span></h5>
            <a href="<?=base_url("doc/notes")?>">Documentacion Modulo ApiNotas</a>
        </article>
        <article class="bg-nota card rounded p-3 mt-2">
            <h4>Nuevo usuario</h4>
            <h5><span class="badge text-bg-warning">POST</span> /api/authentication/sigout</h5>
            <form class="card p-3" action="#">
                <h5>Parametros de la solicitud</h5>
                <p>Solicitud de tipo <span class="badge text-bg-secondary">FormData</span></p>
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <label class="col-form-label" for="nombre">nombre</label>
                    </div>
                    <div class="col-auto">
                        <input class="form-control" type="text" name="nombre" id="nombre">
                    </div>
                </div>
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <label class="col-form-label" for="apellido">apellido</label>
                    </div>
                    <div class="col-auto">
                        <input class="form-control" type="text" name="apellido" id="apellido">
                    </div>
                </div>
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <label class="col-form-label" for="correo">correo</label>
                    </div>
                    <div class="col-auto">
                        <input class="form-control" type="email" name="correo" id="correo">
                    </div>
                </div>
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <label class="form-label" for="contrasena">contrasena</label>
                    </div>
                    <div class="col-auto">
                        <input class="form-control" type="password" name="contrasena" id="contrasena">
                    </div>
                </div>
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <label class="form-label" for="confirmar_contrasena">confirmar_contrasena</label>
                    </div>
                    <div class="col-auto">
                        <input class="form-control" type="passwor" name="confirmar_contrasena" id="confirmar_contrasena">
                    </div>
                </div>
            </form>
            <div class="card p-3">
                <h5>Respuesta exitosa <span class="badge text-bg-success">200</span></h5>
                <p>Respuesta de tipo <span class="badge text-bg-secondary">json</span></p>
                <pre class="bg-notas pre p-3 card">
{
    "status": 200,
    "message": "Se ha registrado correctamente.",
    "errors": [],
    "data": {
        "status": true
    }
}
                </pre>
            </div>
            <div class="p-3 card mt-2">
                <h5>Respuesta con error <span class="badge text-bg-danger">400</span></h5>
                <p>Respuesta de tipo <span class="badge text-bg-secondary">json</span></p>
                <pre class="bg-notas pre p-3 card">
{
    "status": 400,
    "message": "Error en la validacion de datos.",
    "errors": [
        {
            "nombre": "El campo 'nombre' es obligatorio",
            "apellido": "El campo 'apellido' es obligatorio",
            "correo": "El usuario 'correo@example.com' ya exiate",
            "contrasena": "El campo 'contrasena' debe contener almenos 8 caracteres",
            "confirmar_contrasena": "El campo 'confirmar_contrasena' debe contener almenos 8 caracteres"
        }
    ],
    "data": {
        "status": false
    }
}
                </pre>
            </div>
        </article>
        <article class="bg-nota card rounded p-3 mt-2">
            <h4>Iniciar Sesion</h4>
            <h5><span class="badge text-bg-warning">POST</span> /api/authentication/login</h5>
            <p>Autenticacion basada en secion. <span class="badge rounded-pill text-bg-warning">*Se cambio por autenticacion por token.</span></p>
            <form class="card p-3" action="#">
                <h5>Parametros de la solicitud</h5>
                <p>Solicitud de tipo <span class="badge text-bg-secondary">FormData</span></p>
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <label class="col-form-label" for="correo">correo</label>
                    </div>
                    <div class="col-auto">
                        <input class="form-control" type="email" name="correo" id="correo">
                    </div>
                </div>
                <div class="row g-3 aling-items-center">
                    <div class="col-auto">
                        <label class="col-form-label" for="contrasena">contrasena</label>
                    </div>
                    <div class="col-auto">
                        <input class="form-control" type="password" name="contrasena" id="contrasena">
                    </div>
                </div>
            </form>
            <div class="card p-3">
                <h5>Respuesta exitosa o secion iniciasa <span class="badge text-bg-success">201</span></h5>
                <p>Respuesta de tipo <span class="badge text-bg-secondary">json</span></p>
                <pre class="bg-notas pre p-3 card">
{
    "status": 201,
    "message": "Ha iniciado secion.",
    "errors": [],
    "data": {
        "status": true,
        "token": "eyJ0e"
        "user": {
            "nombre": "nombre",
            "apellido": "apellido"
        }
    }
}
                </pre>
            </div>
            <div class="card p-3 mt-2">
                <h5>Respuesta fallida o credenciales incorrecto <span class="badge text-bg-danger">401</span></h5>
                <p>Respuesta de tipo <span class="badge text-bg-secondary">json</span></p>
                <pre class="bg-notas pre p-3 card">
{
    "status": 401,
    "message": "correo o contraseña incorrectos.",
    "errors": [],
    "data": {
        "status": false
    }
}
                </pre>                
            </div>
            <div class="card p-3 mt-2">
                <h5>Respuesta cuando hay una contraseña de un solo uso<span class="badge text-bg-success">200</span></h5>
                <p>Respuesta de tipo <span class="badge text-bg-secondary">json</span></p>
                <pre class="bg-notas pre p-3 card">
{
    "status": 200,
    "message": "Escriba su nueva contraseña.",
    "errors": [],
    "data": {
        "status": false,
        "nueva_contrasena": true
    }
}
                </pre>                
            </div>
        </article>
        <article class="bg-nota card rounded p-3 mt-2">
            <h4>Recuperacion de contraseña</h4>
            <h5><span class="badge text-bg-warning">POST</span> /api/authentication/recoverypassword</h5>
            <p>En esta solicitud se envia un correo de recuperacion de contraseña al usuario con una contraseña de un solo uso.</p>
            <form class="card p-3" action="#">
                <h5>Parametros de la solicitud</h5>
                <p>Solicitud de tipo <span class="badge text-bg-secondary">FormData</span></p>
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <label class="col-form-label" for="correo">correo</label>
                    </div>
                    <div class="col-auto">
                        <input class="form-control" type="email" name="correo" id="correo">
                    </div>
                </div>
            </form>
            <div class="card p-3">
                <h5>Respuesta exitosa <span class="badge text-bg-success">201</span></h5>
                <p>Respuesta de tipo <span class="badge text-bg-secondary">json</span></p>
                <pre class="bg-notas pre p-3 card">
{
    "status": 201,
    "message": "Se ha enviado correo de recuperacion, revise su bandeja de entrada.",
    "errors": [],
    "data": {
        "status": true
    }
}
                </pre>

            </div>
            <!--Respuesta fallida cuando el usuario no existe-->
            <div class="card p-3 mt-2">
                <h5>Respuesta cuando el usuario no existe <span class="badge text-bg-danger">400</span></h5>
                <p>Respuesta de tipo <span class="badge text-bg-secondary">json</span></p>
                <pre class="bg-notas pre p-3 card">
{
    "status": 400,
    "message": "Usuario no existe",
    "errors": [],
    "data": {
        "status": false
    }
}
                </pre>
            </div>
        </article>
        <article class="bg-nota card rounded p-3 mt-2">
            <h4>Nueva contraseña</h4>
            <h5><span class="badge text-bg-warning">POST</span> /api/authentication/newpassword</h5>
            <p>Solicitud para cambiar contraseña</p>
            <form class="card p-3" action="#">
                <h5>Parametros de la solicitud</h5>
                <p>Solicitud de tipo <span class="badge text-bg-secondary">FormData</span></p>
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <label for="correo" class="col-form-label">correo</label>
                    </div>
                    <div class="col-auto">
                        <input class="form-control" type="email" name="correo" id="correo">
                    </div>
                </div>
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <label for="rcp_contrasena" class="col-form-label">rcp_contrasena</label>
                    </div>
                    <div class="col-auto">
                        <input class="form-control" type="password" name="rcp_contrasena" id="rcp_contrasena">
                    </div>
                    <div class="col-auto">
                        <p><span class="text-danger">*</span>rcp_contrasena es la contraseña que se recibio por correo electronico.</p>
                    </div>
                </div>
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <label for="nueva_contrasena" class="col-form-label">nueva_contrasena</label>
                    </div>
                    <div class="col-auto">
                        <input type="password" name="nueva_contrasena" id="nueva_contrasena" class="form-control">
                    </div>
                </div>
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <label for="confirmar_contrasena" class="col-form-label">confirmar_contrasena</label>
                    </div>
                    <div class="col-auto">
                        <input class="form-control" type="password" name="confirmar_contrasena" id="confirmar_contrasena">
                    </div>
                </div>
            </form>
            <div class="card p-3 mt-2">
                <h5>Respuesta exitosa<span class="badge text-bg-success">200</span></h5>
                <p>Respuesta de tipo <span class="badge text-bg-secondary">json</span></p>
                <pre class="bg-notas pre p-3 card">
{
    "status": 200,
    "message": "Se cambio contraseña, vuelva a iniciar secion.",
    "errors": [],
    "data": {
        "status": true
    }
}
                </pre>
            </div>
            <div class="card p-3 mt-2">
                <h5>Respuesta fallida <span class="badge text-bg-danger">400</span></h5>
                <p>Respuesta de tipo <span class="badge text-bg-secondary">json</span></p>
                <pre class="bg-notas pre p-3 card">
{
    "status": 400,
    "message": "No se pudo cambiar contraseña, intente nuevamente.",
    "errors": [
        {
            "correo": "El usuario 'correo@example.com' no existe.",
            "nueva_contrasena": "El campo 'nueva_contrasena' debe contener almenos 8 caracteres",
            "confirmar_contrasena": "El campo 'confirmar_contrasena' no coinside"
        }
    ],
    "data": {
        "status": false
    }
}
                </pre>
            </div>
            <!---->
            <div class="card p-3 mt-2">
                <h5>Respuesta fallida <span class="badge text-bg-danger">400</span></h5>
                <p>Respuesta de tipo <span class="badge text-bg-secondary">json</span></p>
                <pre class="bg-notas pre p-3 card">
                {
    "status": 400,
    "message": "Contraseña de recuperacion invalida.",
    "errors": [],
    "data": {
        "status": false
    }
}
                </pre>
            </div>
        </article>
        <article class="bg-nota card rounded p-3 mt-2 mb-2">
            <h4>Cerrar secion <span class="badge rounded-pill text-bg-warning">*Este metodo se descontinuo.</span></h4>
            <h5><span class="badge text-bg-success">GET</span> /api/user/logout</h5>
            <p>Esta solicitud destruye la secion del usuario</p>
            <section class="card p-3 mt-2">
                <h5>Respuesta exitosa <span class="badge text-bg-success">200</span></h5>
                <p>Respuesta de tipo <span class="badge text-bg-secondary">json</span></p>
                <pre class="bg-notas pre p-3 card">
{
    "status": 200,
    "message": "Ha cerrado secion.",
    "errors": [],
    "data": {
        "status": false
    }
}
                </pre>
            </section>
            <section class="card p-3 mt-2">
                <h5>Respuesta fallida <span class="badge text-bg-danger">401</span></h5>
                <p>Respuesta de tipo <span class="badge text-bg-secondary">json</span></p>
                <p><span class="text-danger">*</span>Sucede cuando se quiere acceder a un recurso sin que el usuario haya iniciado secion.</p>
                <pre class="bg-notas pre p-3 card">
{
    "status": 401,
    "message": "Primero debe iniciar secion.",
    "errors": [],
    "data": {
        "status": false
    }
}
                </pre>
            </section>
        </article>
    </main>
</body>

</html>