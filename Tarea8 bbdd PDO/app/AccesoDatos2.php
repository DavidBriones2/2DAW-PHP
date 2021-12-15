<?php
include_once "Producto.php";
include_once "config.php";

/*
 * Acceso a datos con BD productos : 
 * Usando la librería PDO
 * Uso el Patrón Singleton :Un único objeto para la clase
 * Constructor privado, y métodos estáticos 
 */
class AccesoDatos {
    
    private static $modelo = null;
    private $dbh = null;
    private $stmt_productos = null;
    private $stmt_productoNo  = null;
    private $stmt_productoBorrar  = null;
    private $stmt_productoMod  = null;
    private $stmt_productoCrear = null;
    
    public static function getModelo(){
        if (self::$modelo == null){
            self::$modelo = new AccesoDatos();
        }
        return self::$modelo;
    }
    
    

   // Constructor privado  Patron singleton
   
    private function __construct(){
        
       try 
       {
           $dsn = "mysql:host=".DB_SERVER.";dbname=EMPRESA;charset=utf8";
           $this->dbh = new PDO($dsn, "root", "root");
           $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       } catch (PDOException $th) 
       {
        exit("Error de conexión ".$th->getMessage());
       }
      

        // Construyo las consultas previamente

        $this->stmt_productos  = $this->dbh->prepare("select * from PRODUCTOS");
        if ( $this->stmt_productos == false) die (__FILE__.':'.__LINE__.$this->dbh->error);

        $this->stmt_productoNo   = $this->dbh->prepare("select * from PRODUCTOS where PRODUCTO_NO=:PRODUCTO_NO");
        if ( $this->stmt_productoNo == false) die ($this->dbh->error);

        $this->stmt_productoBorrar   = $this->dbh->prepare("delete from PRODUCTOS where PRODUCTO_NO=:PRODUCTO_NO");
        if ( $this->stmt_productoBorrar == false) die ($this->dbh->error);

        $this->stmt_productoMod   = $this->dbh->prepare("update PRODUCTOS set DESCRIPCION=:DESCRIPCION, PRECIO_ACTUAL=:PRECIO_ACTUAL, STOCK_DISPONIBLE=:STOCK_DISPONIBLE where PRODUCTO_NO=:PRODUCTO_NO");
        if ( $this->stmt_productoMod == false) die ($this->dbh->error);

        $this->stmt_productoCrear  = $this->dbh->prepare("insert into PRODUCTOS (DESCRIPCION, PRODUCTO_NO, PRECIO_ACTUAL, STOCK_DISPONIBLE) Values(?,?,?,?");
        if ( $this->stmt_productoCrear == false) die ($this->dbh->error);
    }

    // Cierro la conexión anulando todos los objectos relacioanado con la conexión PDO (stmt)
    public static function closeModelo(){
        if (self::$modelo != null)
        {
            $obj = self::$modelo;
            $obj->stmt_productos = null;
            $obj->stmt_productoNo  = null;
            $obj->stmt_productoBorrar  = null;
            $obj->stmt_productoMod  = null;
            $obj->stmt_productoCrear = null;
            // Cierro la base de datos
            $obj->dbh = null;
            self::$modelo = null; // Borro el objeto.
        }
    }


    // SELECT Devuelvo la lista de productos
    public function getproductos ():array {
        $tpro = [];
        
        $this->stmt_productos->setFetchMode(PDO::FETCH_CLASS, 'Producto');

        if ( $this->stmt_productos->execute() )
        {
            while ( $pro = $this->stmt_productos->fetch())
            {
               $tpro[]= $pro;
            }
        }
        return $tpro;
    }
    
    // SELECT Devuelvo un productoNo o false
    public function getproductoNo (String $product) {
        $pro = false;
        
        $this->stmt_productoNo->setFetchMode(PDO::FETCH_CLASS, 'Producto');
        $this->stmt_productoNo->bindValue(':PRODUCTO_NO', $product);
        
        if ( $this->stmt_productoNo->execute())
        {
            if ($obj = $this->stmt_productoNo->fetch()) 
            {
                $pro = $obj;
            }
            
        }
        
        return $pro;
    }
    
    // UPDATE
    public function modproductoNo($product):bool{
      
    
        $this->stmt_productoMod->bindValue(':PRODUCTO_NO',$product->PRODUCTO_NO);
        $this->stmt_productoMod->bindValue(':DESCRIPCION',$product->DESCRIPCION);
        $this->stmt_productoMod->bindValue(':PRECIO_ACTUAL',$product->PRECIO_ACTUAL);
        $this->stmt_productoMod->bindValue(':STOCK_DISPONIBLE',$product->STOCK_DISPONIBLE);
        $this->stmt_productoMod->execute();
        $resu = ($this->stmt_productoMod->rowCount()== 1);
        return $resu;
    }

    //INSERT
    public function addproductoNo($product):bool{
       
        $this->stmt_productoCrear->execute($product->PRODUCTO_NO, $product->DESCRIPCION, $product->PRECIO_ACTUAL, $product->STOCK_DISPONIBLE);
        $resu = ($this->stmt_productoCrear->rowCount()  == 1);
        return $resu;
    }

    //DELETE
    public function borrarproductoNo(String $product):bool {
        $this->stmt_productoBorrar->bind_param(":PRODUCTO_NO", $product);
        $this->stmt_productoBorrar->execute();
        $resu = ($this->stmt_productoBorrar->rowCount()  == 1);
        return $resu;
    }   
    
     // Evito que se pueda clonar el objeto. (SINGLETON)
    public function __clone()
    { 
        trigger_error('La clonación no permitida', E_USER_ERROR); 
    }
}

