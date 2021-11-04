<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=chrome">
    <title>C A S I N O</title>
</head>
<body>
    <form method="POST">
        <h2>Cantidad a apostar :</h2><input name="cantidad" type="number"> 
        <br>
        <br>
        <h3>Tipo de apuesta:</h3> 
        <input  type="radio"   name="apuesta" value="PAR"> Par
        <input  type="radio"   name="apuesta" value="IMPAR"> Impar 
        <br>
        <br>
        <button name='apostar' value='apostar'> Apostar</button>
        <button name='dejar'   value='dejar'> Dejar</button>
    </form>
</body>
</html>

<?php
    
    if(isset($_POST['apostar']))
    {
        if($_POST['cantidad'] <= $_SESSION['dinerodisponible'])
        {
            apuesta($_POST['cantidad'],$_SESSION['dinerodisponible'],$_POST['apuesta']);
        }
        else
        {
            echo "Dinero insuficiente";
        }
    }

    if(isset($_POST['dejar']))
    {
        exit();
    }

    function apuesta($cantidadAp,$dinerodisponibleAp,$apuesta)
    {
        $numero = (random_int(1, 100) % 2 == 0) ? "PAR" : "IMPAR";
        $resultado .= " RESULTADO DE LA APUESTA : " . $numero ;
        if ($apuesta == $numero) 
        {
            $resultado .= " GANASTE <br>";
            $dinerodisponibleAp  += $cantidadAp;
        } 
        else 
        {
            $resultado .=" PERDISTE <br>";
            $dinerodisponibleAp  -= $cantidadAp;
        }

        return $resultado;
    }
?>
