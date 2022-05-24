<?php
include "conexion.php";

$hora_atras = 1;
$hora_siguientes = 2;
$ahora = time();
$desde = $ahora - ($hora_atras * 60 * 60); // en segundos
$hasta  = $ahora + ($hora_siguientes * 60 * 60); // en segundos
	
$sql  = "SELECT R.room_name AS sala, start_time AS hora_ini, end_time AS hora_fin, name AS actividad_breve, E.description AS actividad, E.status AS estado, A.area_name AS area, E.type";
$sql .= "FROM mrbs_entry E, mrbs_room R, mrbs_area A ";
$sql .= "WHERE E.room_id = R.id AND ";
$sql .= "R.area_id = A.id AND ";
$sql .= "((start_time > $desde AND start_time < $hasta) OR (end_time > $desde AND end_time < $hasta) OR ";
$sql .= "(start_time < $desde AND end_time > $hasta)) ORDER BY start_time";

$resultado = mysqli_query( $conexion , $sql ) or die ( "Algo Falla en la consulta a la base de datos");
echo "<table border>";
echo "<th><th>Materias</th>  <th>Carrera</th>  <th>Hora</th>  <th>Ala</th>  <th>Docente</th></tr>"; 
echo "</table>";
echo "<table border>";
while ($data = mysqli_fetch_object( $resultado )){
    $hora_ini = date('H:i', $data->hora_ini);
    $hora_fin = date('H:i', $data->hora_fin);	

			//echo "<span class='titulo_actividad'>";
		    echo htmlentities (" $data->actividad_breve ");
			if ($data->type == "E") 
				{echo "<td><span class='titulo_actividad'> - (EVENTO EXTERNO) - </span></td>";}
				else {
					switch ($data->type) {
 					 case "I":
						echo "<TR>";
						echo "<td>";
			        	echo "- (P. Matemática) - ";
						echo "</td>";
						echo "</TR>";
         				break;
					 case "F":
						echo "<TR>";
						echo "<td>";
         				echo " - (P. Física) - ";
						echo "</td>";
						echo "</TR>";
         				break;
   					 case "Q":
						echo "<TR>";
						echo "<td>";
         				echo " - (P. Química) - ";
						echo "</td>";
						echo "</TR>";
         				break;
					 case "T":
						echo "<TR>";
						echo "<td>";
         				echo " - (P. Edu.Tecnológica) - ";
						echo "</td>";
						echo "</TR>";
         				break;
					 case "B":
						echo "<TR>";
						echo "<td>";
			        	echo " - (P. Biología) - ";
						echo "</td>";
						echo "</TR>";
         				break;
					 case "G":
						echo "<TR>";
						echo "<td>";
         				echo " - (Lic. Biología) - ";
						echo "</td>";
						echo "</TR>";
         				break;
   					 case "A":
						echo "<TR>";
						echo "<td>";
         				echo " - (A. Sist.Inf.) - ";
						echo "</td>";
						echo "</TR>";
         				break;
					 case "L":
						echo "<TR>";
						echo "<td>";
         				echo " - (T. Balística) - ";
						echo "</td>";
						echo "</TR>";
         				break;
					 case "P":
						echo "<TR>";
						echo "<td>";
         				echo " - (T. Papiloscopía) - ";
						echo "</td>";
						echo "</TR>";
         				break;
					 case "D":
						echo "<TR>";
						echo "<td>";
         				echo " - (T. Documentología) - ";
						echo "</td>";
						echo "</TR>";
         				break;
					 case "S":
						echo "<TR>";
						echo "<td>";
			        	echo " - (Lic. Sist.Inf) - ";
						echo "</td>";
						echo "</TR>";
         				break;
					 case "C":
						echo "<TR>";
						echo "<td>";
         				echo " - (Lic. Criminalística) - ";
						echo "</td>";
						echo "</TR>";
         				break;
   					 case "V":
						echo "<TR>";
						echo "<td>";
         				echo " - (Lic. Accidentología V.) - ";
						echo "</td>";
						echo "</TR>";
         				break;
					 case "Z":
						echo "<TR>";
						echo "<td>";
         				echo " - (Carreras Compartidas) - ";
						echo "</td>";
						echo "</TR>";
         				break;
					 }
				  }  
			echo "<td>";
			echo "($hora_ini - $hora_fin)";	  
			echo "</td>";
			//echo "</span>";
			if ($data->estado == "4") {echo "<span class='ausente'> (SUSPENDIDO)</span>";}
			echo "<td>";
			echo "<p class='detalle actividad'></p>";
			echo "</td>";
			echo "<td>";
		    echo htmlentities($data->area);	
			echo "</td>";
			echo " - ";	
			echo "<td>";	
		    echo htmlentities($data->sala);
		    echo ", a cargo de ";
		    echo htmlentities($data->actividad);
			echo "</td>";
}
echo "</table>";

	
mysqli_free_result($resultado);

	
	// cerrar conexi&oacute;n de base de datos
	mysqli_close( $conexion );
	
?>