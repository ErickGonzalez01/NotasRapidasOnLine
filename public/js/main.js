window.onload = function () {
    console.log("Hola mundo");
    $("#sider").hide();
    $("#main").hide();
    $("#nuevo").hide();
    $("#contenedor").css("grid-template-columns", "auto");
    ListaNotas();
}

/*$(".inicio-caja").on("click", (e) => {
    $(".inicio-caja-padre").hide();
    $("#main").show();
    $("#contenedor").removeAttr("style");
    $("#sider").show();
})*/

$("#nuevo-cancelar").on("click", (e) => {
    $("#nuevo").hide();
    $(".inicio-caja-padre").show();
    $("#sider").hide();
    $("#contenedor").css("grid-template-columns", "auto");
    $(".inicio-nota-nueva").show();
});

$("#guardar").on("click", () => {
    EnviarNuevaNota();
    //ListaNotas();
    LimpiarPizarra();
    $("#nuevo").hide();
    $(".inicio-caja-padre").empty();    
    $(".inicio-caja-padre").show();
    
    $("#sider").hide();
    $("#contenedor").css("grid-template-columns", "auto");
    $(".inicio-nota-nueva").show();
    ListaNotas();
});

$("#main-cerrar").on("click", () => {
    $("#main").hide();
    $(".inicio-caja-padre").show();
    $("#sider").hide();
    $("#contenedor").css("grid-template-columns", "auto");
});

$(".inicio-nota-nueva").on("click", () => {
    $(".inicio-caja-padre").hide();
    $("#nuevo").show();
    $("#main").hide();
    $("#contenedor").removeAttr("style");
    $("#sider").show();
    $(".inicio-nota-nueva").hide();
});

//nav-menu
$(".nav-menu").on("click", () => {
    $("#sider").addClass("sider-show");
})


let quill_options = {
    modules: {
        toolbar: [
            [{ header: [1, 2, false] }],
            ['bold', 'italic', 'underline'],
            ['image', 'code-block']
        ]
    },
    placeholder: 'Escriba aqui su nueva nota...',
    theme: 'snow'
};

let quill = new Quill("#quilljs", quill_options);

let url_default = "http://localhost:8080";

function EnviarNuevaNota() {
    //guardar nota
    let request = {
        method: "post",
        body: JSON.stringify({
            titulo: $("#titulo").val(),
            contenido: quill.getContents()
        })
    };
    fetch(url_default + "/api/CrearNotas", request)
        .then(data => data.json())
        .then(onjeto => alert(onjeto))
        .catch(err=>console.log(err));

}

function LimpiarPizarra() {
    $("#titulo").val("");
    let quill_remove = quill.deleteText(0, quill.getLength(), "api");
    quill.setContents(quill_remove);
}

var lista_de_notas={};

async function ListaNotas() {
    await fetch(url_default + "/api/ListarNotas").then(response => response.json()).then((data) => {
        lista_de_notas=data;
        //data.forEach((element) => ShowNewNota(element));
    });
    await lista_de_notas.forEach((element) => ShowNewNota(element));
    await console.log(lista_de_notas);
};

//
$("#titulo").keyup(function(event){
    if(event.getLength==20){
        alert("A superado el maximo de caracteres permitidos.")
    }
});

function ShowNewNota(element) {

    let contenedor = $("#list_notes");

    let lis_notas = $("<div name=\"nnnn\"></div>");
    lis_notas.addClass("inicio-caja");
    lis_notas.html("<p>" + element.titulo + "</p>");
    lis_notas.click(event => EventClick_InicioCaja(event));
    //console.log(lis_notas);

    let quill_notas_contenedor = $("<div></div>");
    quill_notas_contenedor.attr("id", "nota_" + element.id);
    lis_notas.append(quill_notas_contenedor);
    contenedor.append(lis_notas);

    let input_hidden = $("<input>");
    input_hidden.attr({
        type: "hidden",
        value: element.id,
        id: "id"
    });

    lis_notas.append(input_hidden);

    let json_object = JSON.parse(element.contenido);
    let op = {
        modules: {
            toolbar: false
        },
        readOnly: true,
        theme: "snow"
    };
    let editor_id = "#nota_" + element.id;
    let quill_nota = new Quill(editor_id, op);
    quill_nota.setContents(json_object);
}

function EventClick_InicioCaja(element) {
    let id = element.currentTarget.childNodes[2].value;
    //let editor = element.currentTarget.childNodes[2].id;
    //console.log(editor);
    ViewNota();
    InjectContentsQuill(id);
}

function ViewNota() {
    $(".inicio-caja-padre").hide();
    $("#main").show();
    $("#contenedor").removeAttr("style");
    $("#sider").show();
    
}

function InjectContentsQuill(id){
    let op = {
        modules: {
            toolbar: false
        },
        readOnly: true,
        theme: "snow"
    };
    
    let quill_set_for_view = new Quill("#view_quill_container",op);
    //console.log(id);
    let elemento_json = lista_de_notas.find(objeto => objeto.id==id);
    let objeto_ops = JSON.parse(elemento_json.contenido);
    quill_set_for_view.setContents(objeto_ops);
    $("#view_id").text(elemento_json.titulo);
    console.log(id);
}

function AgregarTitulosALaLista(){

}
function AgregarTituloALaLista(){

}
function EventCLick_TituloEnLaLista(){
    
}


