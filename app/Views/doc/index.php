<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NotasRapidasOnline</title>
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
            <li class="breadcrumb-item active" aria-current="page">
                <a class="text-white" href="<?=base_url("doc")?>">Inicio</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">
                <a href="<?=base_url("doc/authentication")?>">Autenticación</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">
                <a href="<?=base_url("doc/notes")?>">Notas</a>
            </li>
        </ol>
    </section>
    <main class="container">
        <article class="bg-nota card rounded p-3 mb-2">
            <h4 class="p-font">Documentacion para usar la api de NotasRapidasOnline</h4>
            <p class="p-font">En esta documentacion se muetras exactamente como usar nuestra api</p>
            <h5>Documentacion para el modulo <span class="badge text-bg-secondary">Autenticacion</span></h5>
            <h5>Documentacion para el modulo <span class="badge text-bg-secondary">Notas</span></h5>
            <p>Acontinuacion puede hacer click en cualquiera de los dos modulos que dese consultar.</p>
        </article>
        <div class="row gap-2">
            <div class="col-sm-12 col-md bg-nota p-3 card">
                <a href="<?= base_url("doc/authentication") ?>">Autenticacion</a>
            </div>
            <div class="col-sm-12 col-md bg-nota p-3 card">
                <a href="<?= base_url("doc/notes") ?>">Notas</a>
            </div>
        </div>
    </main>
</body>

</html>