<?php
include "conexion.php";

$hora_atras = 1;
$hora_siguientes = 2;
$ahora = time();
$desde = $ahora - ($hora_atras * 60 * 60); // en segundos
$hasta  = $ahora + ($hora_siguientes * 60 * 60); // en segundos
	
$sql  = "SELECT R.room_name AS sala, start_time AS hora_ini, end_time AS hora_fin, name AS actividad_breve, E.description AS actividad, E.status AS estado, A.area_name AS area, E.type ";
$sql .= "FROM mrbs_entry E, mrbs_room R, mrbs_area A ";
$sql .= "WHERE E.room_id = R.id AND ";
$sql .= "R.area_id = A.id AND ";
$sql .= "((start_time > $desde AND start_time < $hasta) OR (end_time > $desde AND end_time < $hasta) OR ";
$sql .= "(start_time < $desde AND end_time > $hasta)) ORDER BY start_time";

$resultado = mysqli_query( $conexion , $sql ) or die ( "Algo Falla en la consulta a la base de datos");


while ($data = mysqli_fetch_object( $resultado )){
    $hora_ini = date('H:i', $data->hora_ini);
    $hora_fin = date('H:i', $data->hora_fin);	
	
			echo "<li>";
			echo "<span class='titulo_actividad'>";
		    echo htmlentities (" $data->actividad_breve ");
			if ($data->type == "E") 
				{echo "<span class='titulo_actividad'> - (EVENTO EXTERNO) - </span>";}
				else {
					switch ($data->type) {
 					 case "I":
			        	echo "- (P. Matemática) - ";
         				break;
					 case "F":
         				echo " - P. Física) - ";
         				break;
   					 case "Q":
         				echo " - (P. Química) - ";
         				break;
					 case "T":
         				echo " - (P. Edu.Tecnológica) - ";
         				break;
					 case "B":
			        	echo " - (P. Biología) - ";
         				break;
					 case "G":
         				echo " - (Lic. Biología) - ";
         				break;
   					 case "A":
         				echo " - (A. Sist.Inf.) - ";
         				break;
					 case "L":
         				echo " - (T. Balística) - ";
         				break;
					 case "P":
         				echo " - (T. Papiloscopía) - ";
         				break;
					 case "D":
         				echo " - (T. Documentología) - ";
         				break;
					 case "S":
			        	echo " - (Lic. Sist.Inf) - ";
         				break;
					 case "C":
         				echo " - (Lic. Criminalística) - ";
         				break;
   					 case "V":
         				echo " - (Lic. Accidentología V.) - ";
         				break;
					 case "Z":
         				echo " - (Carreras Compartidas) - ";
         				break;
					 }
				  }
			echo "($hora_ini - $hora_fin)";	  
			echo "</span>";
			if ($data->estado == "4") {echo "<span class='ausente'> (SUSPENDIDO)</span>";}
			echo "<p class='detalle actividad'>";
		    echo htmlentities($data->area);	
			echo " - ";		
		    echo htmlentities($data->sala);
		    echo ", a cargo de ";
		    echo htmlentities($data->actividad);
			echo "</p>";
			echo "</li>";
}
	
mysqli_free_result($resultado);

	
	// cerrar conexi&oacute;n de base de datos
	mysqli_close( $conexion );
	
?>