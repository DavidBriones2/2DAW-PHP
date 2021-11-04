
<form method="GET">
    <p>Selecciona la fruta: </p> 
    <select name="frutitas">
        <option>Naranja</option> 
        <option>Limón</option> 
        <option>Plátano</option>
        <option>Manzanas</option>
    </select>
<br>
<form method="POST">
    <p>Cantidad:</p>
    <select name="cantidad">
        <option value="1">1</option> 
        <option value="2">2</option> 
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
    </select>
    <input type="submit" name="anotar" value="Anotar"> 
    <input type="submit" name="anotar" value="Terminar"> 
</form>

<?php
    $contadorNaranja=0; $contadorLimon=0; $contadorPlatano=0; $contadorManzana=0;
    session_start();
    switch($_REQUEST['anotar'])
    {
        
        case "Anotar":
        
         if(!$_SESSION['productos']) 
         { 
            $_SESSION['productos'] = array(); 
         }
        
         $_SESSION['productos'][] = $_GET['frutitas'];
         
         $num= $_REQUEST['cantidad'];
         print_r($num);


         if ($_GET['frutitas'] == "Naranja") 
         {
            $contadorNaranja = $contadorNaranja + $num;
            echo "$contadorNaranja";
         }
         if ($_GET['frutitas'] == "Limón") 
         {
            $contadorLimon = $contadorLimon + $num;
            echo "$contadorLimon";
         }
         if ($_GET['frutitas'] == "Plátano") 
         {
            $contadorPlatano = $contadorPlatano +$num;
            echo "$contadorPlatano";
         }
         if ($_GET['frutitas'] == "Manzana") 
         {
            $contadorManzana = $contadorManzana + $num;
            echo "$contadorManzana";
         }
        break;

        case "Terminar":
            session_destroy();
        break;
    }   
 
?>

<p> 
    Este es su pedido:
    <p>Naranjas: <?echo $contadorNaranja;?></p>
    <p>Limónes: <?printf($contadorLimon);?></p>
    <p>Plátanos: <?printf($contadorPlatano);?></p>
    <p>Manzanas: <?printf($contadorManzana);?></p>
</p>
