<div id="contenedor" class="bg-color-main p-2 inicio-grid-chil inicio-grid"> <!--class="inicio-grid"-->
    <section id="sider" class="card inicio-sider">
        <h2 class="ms-3">Recientes</h2>
    </section>
    <main id="nuevo" class="card">
        <h2 class="ms-3">Notas nuevas</h2>
        <div class="m-3">
            <div class="mb-3">
                <label for="titulo" class="form-label">Titulo</label>
                <input class="form-control" type="text" name="titulo" id="titulo">
            </div>
            <div class="mb-3">
                <label for="contenido" class="form-label">Titulo</label>
                <div id="quilljs"></div>
            </div>
            <div class="mb-3 d-flex justify-content-between">
                <button id="nuevo-cancelar" class="btn btn-color font-color">Cancelar
                    <img src="/img/close.png" alt="enviar">
                </button>
                <button id="guardar" class="btn btn-color font-color">Guardar
                    <img src="/img/enviar-mensaje.png" alt="enviar">
                </button>
            </div>
        </div>
    </main>
    <section id="main" class="flex-fill card">
        <h2 class="ms-3">Vista de notas</h2>
        <div class="card m-1 p-1">
            <div>
                <h4>Titulo</h4>
            </div>
            <div class="card m-1 p-1 inicio-nota-vista">
                <p>ipsum dolor sit amet consectetur adipisicing elit. Quia, ipsam. Officiis aspernatur minima possimus itaque maxime deleniti blanditiis sint officia, consequatur earum vitae quod aut minus illum. Error, tempore quasi?</p>
                <p>ipsum dolor sit amet consectetur adipisicing elit. Quia, ipsam. Officiis aspernatur minima possimus itaque maxime deleniti blanditiis sint officia, consequatur earum vitae quod aut minus illum. Error, tempore quasi?</p>
                <p>ipsum dolor sit amet consectetur adipisicing elit. Quia, ipsam. Officiis aspernatur minima possimus itaque maxime deleniti blanditiis sint officia, consequatur earum vitae quod aut minus illum. Error, tempore quasi?</p>
                <p>ipsum dolor sit amet consectetur adipisicing elit. Quia, ipsam. Officiis aspernatur minima possimus itaque maxime deleniti blanditiis sint officia, consequatur earum vitae quod aut minus illum. Error, tempore quasi?</p>
            </div>
            <div>
                <button id="main-editar" class="btn btn-primary">Editar</button>
                <button id="main-eliminar" class="btn btn-success">Eliminar</button>
                <button id="main-cerrar" class="btn btn-danger">Cerrar</button>
            </div>
        </div>
    </section>
    <section id="list_notes" class="inicio-caja-padre">
        <!--<div class="inicio-caja">Caja 1</div>-->
    </section>
</div>

<div class="inicio-nota-nueva">
    <div>
        <img src="/img/pencil.png" alt="lapiz">
    </div>
</div>

