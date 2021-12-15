<?php
include_once "Producto.php";

function accionBorrar ($npro){    
    $db = AccesoDatos::getModelo();
    $tproduct = $db->borrarproductoNo($npro);
}

function accionTerminar(){
    AccesoDatos::closeModelo();
    session_destroy();
}
 
function accionAlta(){
    $product = new Producto();
    $product->PRODUCTO_NO  = "";
    $product->DESCRIPCION   = "";
    $product->PRECIO_ACTUAL   = "";
    $product->STOCK_DISPONIBLE = "";
    $orden= "Nuevo";
    include_once "layout/formulario.php";
}

function accionDetalles($npro){
    $db = AccesoDatos::getModelo();
    $product = $db->getproductoNO($npro);
    $orden = "Detalles";
    include_once "layout/formulario.php";
}


function accionModificar($npro){
    $db = AccesoDatos::getModelo();
    $product = $db->getproductoNo($npro);
    $orden="Modificar";
    include_once "layout/formulario.php";
}

function accionPostAlta(){
    limpiarArrayEntrada($_POST); //Evito la posible inyección de código
    $product = new Producto();
    $product->PRODUCTO_NO  = $_POST['PRODUCTO_NO'];
    $product->DESCRIPCION   = $_POST['DESCRIPCION'];
    $product->PRECIO_ACTUAL   = $_POST['PRECIO_ACTUAL'];
    $product->STOCK_DISPONIBLE = $_POST['STOCK_DISPONIBLE'];
    $db = AccesoDatos::getModelo();
    $db->addproductoNo($product);
    
}

function accionPostModificar(){
    limpiarArrayEntrada($_POST); //Evito la posible inyección de código
    $product = new Producto();
    $product->PRODUCTO_NO  = $_POST['PRODUCTO_NO'];
    $product->DESCRIPCION   = $_POST['DESCRIPCION'];
    $product->PRECIO_ACTUAL   = $_POST['PRECIO_ACTUAL'];
    $product->STOCK_DISPONIBLE = $_POST['STOCK_DISPONIBLE'];
    $db = AccesoDatos::getModelo();
    $db->modproductoNo($product);
    
}

