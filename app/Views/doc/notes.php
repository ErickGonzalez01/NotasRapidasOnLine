<!DOCTYPE html>
<html lang="en">
 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NotasRapidasOnLine</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css.map">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/main.css">
    <script src="/js/bootstrap.min.js"></script>
    <link rel="shortcut icon" href="/img/notas.png" type="image/png">
</head>

<body class="bg-notas">
    <nav class="bg-navbar ps-3 pe-3">
        <h2 class="c-navbar">NotasRapidasOnLine</h2>
    </nav>
    <section class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= base_url("doc") ?>">Inicio</a>
            </li>
            <li class="breadcrumb-item">
                <a href="<?= base_url("doc/authentication") ?>">Autenticación</a>
            </li>
            <li class="breadcrumb-item">
                <a class="text-white" href="<?= base_url("doc/notes") ?>">Notas</a>
            </li>
        </ol>
    </section>
    <main class="container">
        <article class="bg-nota card rounded p-3">
            <h4 class="p-font">Documentacion para usar la api de NotasRapidasOnline</h4>
            <p class="p-font">En esta documentacion se muetras exactamente como usar nuestra api</p>
            <h5>Documentacion para el modulo <span class="badge text-bg-secondary">ApiNotes</span></h5>
            <a href="<?= base_url("doc/authentication") ?>">Documentacion Modulo Autenticacion </a>
        </article>
        <article class="bg-nota card rouded p-3 mt-2">
            <h4>Obtener notas</h4>
            <h5><span class="badge text-bg-success">GET</span> /api/user/notes?paginate={value}</h5>
            <p>Solicitud para obtener notas, el parametro paginate espesifica la pagina que quiere obtener.</p>
            <section class="card p-3 mt-2">
                <h5>Respuesta exitosa <span class="badge text-bg-success">200</span></h5>
                <p>Esta solisitud GET devuelve lotes de 25 notas</p>
                <p>el objeto data.notas.contenido es un objeto delta <a href="https://quilljs.com/docs/delta/" target="_blank">Mas informacion aqui</a></p>
                <pre class="bg-notas pre p-3 card">
{
    "status": 200,
    "message": "",
    "errors": [],
    "data": [
        {
            "notas": [
                {
                    "id": "2930",
                    "titulo": "Nesciunt et perspiciatis.",
                    "contenido":{
                        ops: [
                            {
                                insert: 'Gandalf',
                                attributes: { 
                                    bold: true 
                                }
                            },
                            {
                                insert: ' el '
                            },
                            {
                                insert: 'Gris',
                                attributes: { 
                                    color: '#cccccc' 
                                }
                            }
                        ]
                    }
                }
            ],
            "pagerOptions": {
                "numeroDePaginas": 10
            }
        }
    ]
}
                </pre>
                <p>Este fragmento de codigo especifica el numeo de paginas</p>
                <pre class="bg-notas pre p-3 card">
"pagerOptions": {
    "numeroDePaginas": 10
}
                </pre>
            </section>
        </article>
        <article class="bg-nota card rounded p-3 mt-2">
            <h4>Obtener notas por id</h4>
            <h5><span class="badge text-bg-success">GET</span> /api/user/notes/{id}</h5>
            <section class="card p-3">
                <h5>Respuesta exitosa <span class="badge text-bg-success">200</span></h5>
                <p>Respuesta de tipo <span class="badge text-bg-secondary">json</span></p>
                <pre class="bg-notas pre p-3 card">
{
    "status": 200,
    "message": "",
    "errors": [],
    "data": [
        {
            "id": "18525",
            "titulo": "Eaque nam.",
            "contenido": {
                ops: [
                    {
                        insert: 'Gandalf',
                        attributes: { 
                            bold: true 
                        }
                    },
                    {
                        insert: ' el '
                    },
                    {
                        insert: 'Gris',
                        attributes: {
                            color: '#cccccc'
                        }
                    }
                ]
            }
        }
    ]
}
            </pre>
            </section>
        </article>
        <article class="bg-nota card rounded p-3 mt-2 mb-2">
            <h4>Nueva nota</h4>
            <h5><span class="badge text-bg-warning">POST</span> /api/user/notes</h5>
            <form action="#" class="card p-3">
                <h5>Parametros de la solicitud</h5>
                <p>Solicitud de tipo <span class="badge text-bg-secondary">FormData</span></p>
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <label class="col-form-label" for="titulo">titulo</label>
                    </div>
                    <div class="col-auto">
                        <input class="form-control" type="text" name="titulo" id="titulo">
                    </div>
                </div>
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <label class="col-form-label" for="contenido">contenido</label>
                    </div>
                    <div class="col-auto">
                        <input class="form-control" type="text" name="contenido" id="contenido">
                    </div>
                    <div class="col-auto">
                        <p class="m-0"><span class="badge text-bg-secondary">contenido</span>: tiene que ser un objeto delta valido, para mas informacion <a class="p-0 m-0" href="https://quilljs.com/docs/delta/" target="_blank">Click aqui.</a></p>
                    </div>
                </div>
            </form>
            <section class="card p-3 mt-2">
                <h5>Respuesta exitosa <span class="badge text-bg-success">200</span></h5>
                <p>Respuesta de tipo <span class="badge text-bg-secondary">json</span></p>
                <pre class="bg-notas pre p-3 card">
{
    "status": 200,
    "message": "Se ha guardado correctamente",
    "errors": [],
    "data": {
        "id": "id"
    }
}
                </pre>
            </section>
        </article>
        <article class="bg-nota card p-3 mt-2">
            <h4>Actualizar o modificar una nota, reemplaza toda la nota</h4>
            <h5><span class="badge text-bg-primary">PUT</span> /api/user/notes/{id}</h5>
            <form action="#" class="card p-3">
                <h5>Parametros de la solicitud</h5>
                <p>Solicitud de tipo <span class="badge text-bg-secondary">FormData</span></p>
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <label class="col-form-label" for="titulo">titulo</label>
                    </div>
                    <div class="col-auto">
                        <input class="form-control" type="text" name="titulo" id="titulo">
                    </div>
                </div>
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <label class="col-form-label" for="contenido">contenido</label>
                    </div>
                    <div class="col-auto">
                        <input class="form-control" type="text" name="contenido" id="contenido">
                    </div>
                    <div class="col-auto">
                        <p class="m-0 fs-6 text"><span class="badge text-bg-secondary">contenido</span>: tiene que ser un objeto delta valido, para mas informacion <a class="p-0 m-0" href="https://quilljs.com/docs/delta/" target="_blank">Click aqui.</a></p>
                    </div>
                </div>
            </form>
            <section class=" card p-3 mt-2">
                <h5>Respuesta exitosa<span class="badge text-bg-success">201</span></h5>
                <p>Respuesta de tipo <span class="badge text-bg-secondary">json</span></p>
                <pre class="bg-notas pre p-3 card">
{
    "status": 201,
    "message": "Se actualizo esta nota.",
    "errors": [],
    "data": {
        "status": true
    }
}
                </pre>                
            </section>
            <!--Cuando no los campos van vacios-->
            <section class=" card p-3 mt-2">
                <h5>Respuesta exitosa<span class="badge text-bg-success">201</span></h5>
                <p>Respuesta de tipo <span class="badge text-bg-secondary">json</span></p>
                <p>Esta respuesta sucede cuando se envian datos vacios.</p>
                <pre class="bg-notas pre p-3 card">
{
    "status": 201,
    "message": "Nada que actualizar.",
    "errors": [],
    "data": {
        "status": false
    }
}
                </pre>                
            </section>
            <!--Cuando la nota no existe o se elimino-->
            <section class=" card p-3 mt-2">
                <h5>Respuesta exitosa<span class="badge text-bg-success">200</span></h5>
                <p>Respuesta de tipo <span class="badge text-bg-secondary">json</span></p>
                <p>Esta respuesta sucede la nota no existe o se elimino.</p>
                <pre class="bg-notas pre p-3 card">
{
    "status": 200,
    "message": "No se puede actualizar, nota no existe.",
    "errors": [],
    "data": {
        "status": false
    }
}
                </pre>                
            </section>
        </article>
        <!--Metodo PATCH-->
        <article class="bg-nota card rounded p-3 mt-2">
            <h4>Actualizar parametros individuales</h4>
            <h5><span class="badge text-bg-info">PATCH</span> /api/user/notes/{id}</h5>
            <p>Solicitud para actualizar los compos titulo o contenido, pero no los dos juntos.</p>
            <form class="card p-3" action="#">
                <h5>Parametros de la solicitud, actualizar el titulo.</h5>
                <p>Solicitud de tipo <span class="badge text-bg-secondary">FormData</span></p>
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <label for="titulo" class="col-form-label">titulo</label>
                    </div>
                    <div class="col-auto">
                        <input class="form-control" type="email" name="titulo" id="titulo">
                    </div>
                </div>
            </form>
            <form class="card p-3 mt-2" action="#">
                <h5>Parametros de la solicitud, actualizar el contenido.</h5>
                <p>Solicitud de tipo <span class="badge text-bg-secondary">FormData</span></p>
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <label for="titulo" class="col-form-label">contenido</label>
                    </div>
                    <div class="col-auto">
                        <input class="form-control" type="email" name="contenido" id="contenido">
                    </div>
                </div>
            </form>
            <section class="card p-3 mt-2">
                <h5>Respuesta exitosa<span class="badge text-bg-success">201</span></h5>
                <p>Respuesta de tipo <span class="badge text-bg-secondary">json</span></p>
                <p>Respuesta para cuando se actualiza el titulo.</p>
                <pre class="bg-notas pre p-3 card">
{
    "status": 201,
    "message": "Se actualizo el titulo.",
    "errors": [],
    "data": {
        "status": true
    }
}
                </pre>
            </section>
            <section class="card p-3 mt-2">
                <h5>Respuesta exitosa<span class="badge text-bg-success">201</span></h5>
                <p>Respuesta de tipo <span class="badge text-bg-secondary">json</span></p>
                <p>Respuesta para cuando se actualiza el contenido.</p>
                <pre class="bg-notas pre p-3 card">
{
    "status": 201,
    "message": "Se actualizo el contenido.",
    "errors": [],
    "data": {
        "status": true
    }
}
                </pre>
            </section>
            <section class="card p-3 mt-2">
                <h5>Respuesta exitosa<span class="badge text-bg-success">201</span></h5>
                <p>Respuesta de tipo <span class="badge text-bg-secondary">json</span></p>
                <p>Respuesta para cuando no se envian datos, o estan vacios.</p>
                <pre class="bg-notas pre p-3 card">
{
    "status": 201,
    "message": "Nada que actualizar.",
    "errors": [],
    "data": {
        "status": false
    }
}
                </pre>
            </section>
            <section class="card p-3 mt-2">
                <h5>Respuesta exitosa<span class="badge text-bg-success">200</span></h5>
                <p>Respuesta de tipo <span class="badge text-bg-secondary">json</span></p>
                <p>Respuesta para cuando no la nota no existe o se eliminó.</p>
                <pre class="bg-notas pre p-3 card">
{
    "status": 200,
    "message": "No se puede actualizar, nota no existe.",
    "errors": [],
    "data": {
        "status": false
    }
}
                </pre>
            </section>
        </article>
        <article class="bg-nota card rounded p-3 mt-2 mb-2">
            <h4>Eliminar nota.</h4>
            <h5><span class="badge text-bg-danger">DELETE</span> /api/user/notes/{id}</h5>
            <p>Solocitud para eliminar una nota.</p>
            <section>
                <h5>Respuesta exitosa <span class="badge text-bg-success">200</span></h5>
                <p>Respuesta de tipo <span class="badge text-bg-secondary">json</span></p>
                <p>Respuesta cuando se elimina la nota.</p>
                <pre class="bg-notas pre p-3 card">
{
    "status": 200,
    "message": "Eliminando nota",
    "errors": [],
    "data": {
        "status": true
    }
}
                </pre>
            </section>
        </article>
    </main>
</body>

</html>