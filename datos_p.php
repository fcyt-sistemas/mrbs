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

            for($j=0; ; $j++){
                $horario[0][$j]=$data->hora_ini->$data->hora_fin;
                $horario[1][$j]=$data->actividad_breve;
			    if ($data->type == "E") 
				    {echo "<span class='titulo_actividad'> - (EVENTO EXTERNO) - </span>";}
				else {
					switch ($data->type) {
 					 case "I":
                        $horario[2][$j]="- (P. Matemática) - ";
         				break;
					 case "F":
                        $horario[2][$j]=" - (P. Física) - ";
         				break;
   					 case "Q":
                        $horario[2][$j]=" - (P. Química) - ";
         				break;
					 case "T":
                        $horario[2][$j]=" - (P. Edu.Tecnológica) - ";
         				break;
					 case "B":
			        	$horario[2][$j]=" - (P. Biología) - ";
         				break;
					 case "G":
                        $horario[2][$j]=" - (Lic. Biología) - ";
         				break;
   					 case "A":
                        $horario[2][$j]=" - (A. Sist.Inf.) - ";
         				break;
					 case "L":
                        $horario[2][$j]=" - (T. Balística) - ";
         				break;
					 case "P":
                        $horario[2][$j]=" - (T. Papiloscopía) - ";
         				break;
					 case "D":
                        $horario[2][$j]=" - (T. Documentología) - ";
         				break;
					 case "S":
			        	$horario[2][$j]=" - (Lic. Sist.Inf) - ";
         				break;
					 case "C":
                        $horario[2][$j]=" - (Lic. Criminalística) - ";
         				break;
   					 case "V":
                        $horario[2][$j]=" - (Lic. Accidentología V.) - ";
         				break;
					 case "Z":
                        $horario[2][$j]=" - (Carreras Compartidas) - ";
         				break;
					}
				}
                $horario[3][$j]=$data->area;
                $horario[4][$j]=$data->actividad;
                $horario[5][$j]=$data->estado;
            }
            for($i=0; $i<6 ; $i++){
                for($j=0; ;$j++){
                    echo $horario[$i][$j];
                }
            }
            
        
    }
        
    mysqli_free_result($resultado);
    
        
        // cerrar conexi&oacute;n de base de datos
        mysqli_close( $conexion );
?>