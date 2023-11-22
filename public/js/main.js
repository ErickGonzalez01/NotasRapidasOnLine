window.onload = function () {
    console.log("Hola mundo");
    $("#sider").hide();
    $("#main").hide();
    $("#nuevo").hide();
    $("#contenedor").css("grid-template-columns", "auto");
    ListaNotas();
}

$(".inicio-caja").on("click", (e) => {
    $(".inicio-caja-padre").hide();
    $("#main").show();
    $("#contenedor").removeAttr("style");
    $("#sider").show();
})

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
    $(".inicio-caja-padre").show();
    $("#sider").hide();
    $("#contenedor").css("grid-template-columns", "auto");
    $(".inicio-nota-nueva").show();
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
        .then(onjeto => alert(onjeto));
    
}

function LimpiarPizarra(){
    $("#titulo").val("");
    let quill_remove = quill.deleteText(0,quill.getLength(),"api");
    quill.setContents(quill_remove);
}

function ListaNotas(){
    fetch(url_default + "/api/ListarNotas").then(response => response.json()).then((data)=>{
        data.forEach((element) => ShowNewNota(element));
    });
};

function ShowNewNota(element){

    let contenedor = $("#list_notes");

    let lis_notas= $("<div></div>")
    lis_notas.addClass("inicio-caja");
    lis_notas.html("<p>"+element.titulo+"</p>");

    let quill_notas_contenedor = $("<div></div>");
    quill_notas_contenedor.attr("id","nota_"+element.id);
    lis_notas.append(quill_notas_contenedor);
    contenedor.append(lis_notas);

    let op = {
        modules:{
            toolbar:false
        },
        readOnly:true,
        theme: "snow"
    }
    let json_object = JSON.parse(element.contenido);
    quill_nota = new Quill("#nota_"+element.id,op);
    quill_nota.setContents(json_object);
}
