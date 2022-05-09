<?php
include "conexion.php";

$hora_atras = 1;
$hora_siguientes = 3;
$ahora = time();
$desde = $ahora - ($hora_atras * 60 * 60); // en segundos
$hasta  = $ahora + ($hora_siguientes * 60 * 60); // en segundos
	
$sql  = "SELECT R.room_name AS sala, start_time AS hora_ini, end_time AS hora_fin, name AS actividad_breve, E.description AS actividad, E.status AS estado, A.area_name AS area ";
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
		    echo htmlentities (" $data->actividad_breve ($hora_ini - $hora_fin)"); 
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