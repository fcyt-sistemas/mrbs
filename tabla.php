<?php 
include "conexion.php";
echo "<div align='center' style='background-color: #FDFEFE'>";
echo "<table>";
echo "<tr>";
echo "<td width='1090'><img width='120%' border='0' src='SmartTab/skins/tango/barra-fcyt.png'>";
echo "<td rowspan='2' width='200'><p align='center'" . $fecha . "</td>";
echo "</tr>";
echo "</table>";
$hora_atras = 1;
$hora_siguientes = 2;
$ahora = time();
//$desde = date("d")+date('G');
$desde = mktime(0, 0, 0, date('n'), date('j'), date('Y')); //$ahora;- ($hora_atras * 60 * 60); // en segundos
$hasta  = mktime(23, 59, 0, date('n'), date('j'), date('Y'));//$ahora + ($hora_siguientes * 60 * 60); // en segundos

date_default_timezone_set('America/Araguaina');
//date_default_timezone_set("UTC");
$fecha = date('d/m/Y');
$horacompleta = date('H : i');
$hactual= date('H');
$minactual= date('i');
$hinirango= date('H')-1;
$hfinrango= date('H')+2;
if ($hfinrango == "24")
	{$hfinrango= "00";}
$rangoini= $hinirango.":".$minactual;
$rangofin= $hfinrango.":".$minactual;

$sql  = "SELECT R.room_name AS sala, start_time AS hora_ini, end_time AS hora_fin, name AS actividad_breve, E.description AS actividad, E.status AS estado, A.area_name AS area, E.type ";
$sql .= "FROM mrbs_entry E, mrbs_room R, mrbs_area A ";
$sql .= "WHERE E.room_id = R.id AND ";
$sql .= "R.area_id = A.id AND ";
//$sql .=  "timestamp >= '2022-06-08 00:00:00' AND timestamp <= '2022-06-08 23:59:00'";
$sql .= "((start_time > $desde AND start_time < $hasta) OR (end_time > $desde AND end_time < $hasta) OR ";
$sql .= "(start_time < $desde AND end_time > $hasta)) ORDER BY start_time";

$resultado = mysqli_query( $conexion , $sql ) or die ( "Algo Falla en la consulta a la base de datos");

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZwv-model-vue1T" crossorigin="anonymous">
  
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"> 
  
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    
    
    <title>HORARIOS</title>
    <style>
        table {
            color: black;
            border-color:black;
            border-collapse: collapse;
        }
        th {
            text-align: center;
            color: rgb(232, 228, 237);
            font: condensed 120% sans-serif;
            font-size: large;
            background-color:rgb(43, 82, 133);
        }
        <?php if ($data->estado == "4") {echo "<span class='ausente'> (SUSPENDIDO)</span>"; ?>
        td{
            text-align: center;
            color: red;
            font: bold 90%;
        }
        <?php } ?>

        td{
            text-align: center;
            color: black;
            font: bold 90%;
        }
        .contenedor {
            width:100%;
            max-width: 3000px;
            min-width: none;
            margin:0 auto;
            overflow:hidden;
        }
        body {
            margin-top: 12px;
            margin-right: 12px;
            margin-bottom: 8px;
            margin-left: 12px;
        }
    </style>
</head>
<body>
<img width='200px' src='SmartTab/skins/tango/fcyt-logo.jpg'></img>
<?php 
//echo "<b align='center' class='titulo_b'>" . $fecha . "</b>";
echo "<h2 align='center' class='titulo'>&nbsp;&nbsp;Actividades en curso en el dia $fecha</h2>" ;
?>
<TABLE BORDER ALIGN="center" width="100%">
   
    <TR color="red">
		<TH>HORA ENTRADA</TH>
		<TH>MATERIA</TH>
		<TH>CARRERA</TH>
        <TH>AULA</TH>
	</TR>
    <?php while ($data = mysqli_fetch_object($resultado)){ ?>
    <TR>
         <TD>
            <?php 
                $hora_ini = date('H:i', $data->hora_ini);
                $hora_fin = date('H:i', $data->hora_fin);	
                echo "($hora_ini)";
            ?>
        </TD>
        <TD>
            <?php 
              echo htmlentities (" $data->actividad_breve ");  		
            ?>
        </TD>
        <TD>
        <?php
            if ($data->type == "E") 
            {echo "<span class='titulo_actividad'> - (EVENTO EXTERNO) - </span>";}
            else {
                switch ($data->type) {
                  case "I":

                    echo " P. Matemática ";
                     break;
                 case "F":

                     echo " P. Física ";
                     break;
                    case "Q":

                     echo " P. Química ";
                     break;
                 case "T":

                     echo " P. Edu.Tecnológica ";
                     break;
                 case "B":

                    echo " P. Biología ";
                     break;
                 case "G":

                     echo " Lic. Biología ";
                     break;
                    case "A":

                     echo " Analista en Sistemas ";
                     break;
                 case "L":

                     echo " T. Balística ";
                     break;
                 case "P":

                     echo " T. Papiloscopía";
                     break;
                 case "D":

                     echo " T. Documentología ";
                     break;
                 case "S":

                    echo " Lic. en Sistemas de Información ";
                     break;
                 case "C":

                     echo " Lic. Criminalística ";
                     break;
                    case "V":

                     echo " Lic. Accidentología V. ";
                     break;
                 case "Z":

                     echo " Carreras Compartidas ";
                     break;
                }
            }  
        ?>
        
        </TD>
        <TD><?php echo htmlentities($data->sala); 
            if ($data->estado == "4") {echo "<span class='ausente'> (SUSPENDIDO)</span>";} 
            ?>
        
        </TD>
    </TR>
    <?php } ?>
</TABLE>
</body>
</html>
