window.onload=function(){
    console.log("Hola mundo");
    $("#sider").hide();
    $("#main").hide();
    $("#nuevo").hide();    
    $("#contenedor").css("grid-template-columns","auto");}

$(".inicio-caja").on("click",(e)=>{
    $(".inicio-caja-padre").hide();
    $("#main").show();
    $("#contenedor").removeAttr("style");
    $("#sider").show();
})

$("#nuevo-cancelar").on("click",(e)=>{
    $("#nuevo").hide();
    $(".inicio-caja-padre").show();
    $("#sider").hide();
    $("#contenedor").css("grid-template-columns","auto");
    $(".inicio-nota-nueva").show();
});

$("#guardar").on("click",()=>{
    alert("Se guardo una nueva nota");
    $("#nuevo").hide();
    $(".inicio-caja-padre").show();
    $("#sider").hide();
    $("#contenedor").css("grid-template-columns","auto");
    $(".inicio-nota-nueva").show();
});

$("#main-cerrar").on("click",()=>{
    $("#main").hide();
    $(".inicio-caja-padre").show();
    $("#sider").hide();
    $("#contenedor").css("grid-template-columns","auto");
});

$(".inicio-nota-nueva").on("click",()=>{
    $(".inicio-caja-padre").hide();
    $("#nuevo").show();
    $("#main").hide();
    $("#contenedor").removeAttr("style");
    $("#sider").show();
    $(".inicio-nota-nueva").hide();
});

//nav-menu
$(".nav-menu").on("click",()=>{
    $("#sider").addClass("sider-show");
})
