<?php               
 echo "<div align='center' style='background-color: #FDFEFE'>";
 echo "<table ='1200'>";
 echo "<tr>";
 echo "<td rowspan='2' width='50' align='left'><img width='200px' src='SmartTab/skins/tango/fcyt-logo.jpg'></td>";
 echo "<td width='1090'><img width='100%' border='0' src='SmartTab/skins/tango/barra-fcyt.png'>";
 echo "<td rowspan='2' width='200'><p align='center'" . $fecha . "</td>";
 echo "</tr>";
 echo "</table>";
    
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HORARIOS</title>
	
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZwv-model-vue1T" crossorigin="anonymous">
  
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
  
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>
 <body>  
    <div class="container">
        <div class="col p-3 mb-2 bg-info text-white">
        <div class="column-width: auto col-6 p-3 mb-2 bg-info text-white">Hora</div>
        <div class="column-width: auto col-6 p-3 mb-2 bg-info text-white">Nombre Materia</div>
        <div class="column-width: auto col-6 p-3 mb-2 bg-info text-white">Carrera</div>
        <div class="column-width: auto col-6 p-3 mb-2 bg-info text-white">Ala</div>
        <div class="column-width: auto col-6 p-3 mb-2 bg-info text-white">Docente</div>
        <div class="column-width: auto col-6 p-3 mb-2 bg-info text-white">Estado</div>
    </div>
</body>
</html>

<?php
include "datos_p.php";
?>

