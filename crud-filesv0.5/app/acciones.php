<?php



function accionDetalles($id)
{
    $usuario = $_SESSION['tuser'][$id];
    $nombre  = $usuario[0];
    $login   = $usuario[1];
    $clave   = $usuario[2];
    $comentario=$usuario[3];
    $orden = "Detalles";
    include_once "layout/formulario.php";
    exit();
}

function accionAlta()
{
    $nombre  = "";
    $login   = "";
    $clave   = "";
    $comentario = "";
    $orden= "Nuevo";
    include_once "layout/formulario.php";
    exit();
}

function accionPostAlta()
{
    limpiarArrayEntrada($_POST); //Evito la posible inyección de código
    $existe = false;
    foreach ($_SESSION['tuser'] as $usuario) 
    {
        if ($usuario[1] == $_POST['login']) 
        {
            $existe = true;
            exit;
        }
    }
}

function accionModificar($id)
{
    $usuario = $_SESSION['tuser'][$id];
    $nombre  = $_POST['nombre'];
    $login   = $_POST['login'];
    $clave   = $usuario[2];
    $comentario=$_POST['comentario'];
    $orden = "Modificar";
    include_once "layout/formulario.php";
    exit();
}

function accionPostModificar()
{
    limpiarArrayEntrada($_POST); 
    $usuario = $_SESSION['tuser'];
    /*for ($i=0; $i < ; $i++) 
    { 
        $nombre  = $_POST['nombre'];
        $login   = $_POST['login'];
        $clave   = $usuario[2];
        $comentario=$_POST['comentario'];
    } 
    */
}

function accionBorrar($id)
{
    $usuario = $_SESSION['tuser'][$id];
    $usuario = "";
    $nombre  = "";
    $login   = "";
    $clave   = "";
    $comentario="";
    
}

function accionTerminar()
{
    volcarDatos($_SESSION['tuser']);
    session_destroy;
    $_SESSION['msg']='Datos volcados'
}


