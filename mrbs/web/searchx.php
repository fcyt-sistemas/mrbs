<?php
namespace MRBS;

use MRBS\Form\Form;

require "defaultincludes.inc";

//  function generate_search_nav_html($search_str, $total, $num_records, $search_str);
function generate_search_nav_html($id_aula, $nombre_area, $nombre_aula , $capacidad)
{
  global $day, $month, $year;
  global $search;
  
  $html = '';
  $has_prev = $search_pos > 0;
  $has_next = $search_pos < ($total-$search["count"]);
  if ($has_prev || $has_next)
  {
    $html .= "<div id=\"record_numbers\">\n";
   	$html .= get_vocab("records") . ($search_pos+1) . get_vocab("through") . ($search_pos+$num_records) . get_vocab("of") . $total;
    $html .= "</div>\n";
  
    $html .= "<div id=\"record_nav\">\n";
//    $base_query_string = "search_str=" . urlencode($search_str) . "&amp;" .
	$base_query_string = "nombre_area=" . urlencode($nombre_aula) . "&amp;" .
		                 "nombre_aula=$nombre_aula&amp;" .
                         "capacidad=$capacidad";
    // display a "Previous" button if necessary
    if($has_prev)
    {
      $query_string = $base_query_string . "&amp;search_pos=" . max(0, $search_pos-$search["count"]);
      $html .= "<a href=\"searchx.php?$query_string\">";
    }

    $html .= get_vocab("previous");

    if ($has_prev)
    {
      $html .= "</a>";
    }

    // add a separator for Next and Previous
    $html .= (" | ");

    // display a "Previous" button if necessary
    if ($has_next)
    {
      $query_string = $base_query_string . "&amp;search_pos=" . max(0, $search_pos+$search["count"]);
      $html .= "<a href=\"searchx.php?$query_string\">";
    }

    $html .= get_vocab("next");
  
    if ($has_next)
    {
      $html .= "</a>";
    }
    $html .= "</div>\n";
  }
  
  return $html;
}


//HASTA ACA FUNCION QUE PAGINA




function output_row($row)
{
  global $ajax, $json_data;
  
  $values = array();
  // booking name
  $html_name = htmlspecialchars($row['name']);
  //$values[] = "<span title=\"" . $row['nombre_area'] . "\"></span>";
  // created by
  //$values[] = htmlspecialchars($row['nombre_area']);
    //$values[] = "<span title=\"" . $row['nombre_aula'] . "\"></span>";
  // start time and link to day view
  //$date = getdate($row['start_time']);
  /*$link = "<a href=\"day.php?day=$date[mday]&amp;month=$date[mon]&amp;year=$date[year]&amp;area=".$row['nombre_aula']."\">";
  if(empty($row['enable_periods']))
  {
    $link_str = time_date_string($row['start_time']);
  }
  else
  {
    list(,$link_str) = period_date_string($row['start_time'], $row['area_id']);
  }
  $link .= htmlspecialchars($link_str) ."</a>";*/
  //    add a span with the numeric start time in the title for sorting
  //$values[] = "<span title=\"" . $row['capacidad'] . "\"></span>" . $link;
  // description
   
  //AGREGUE YOOOO
 $values[] = htmlspecialchars($row['nombre_area']);
 
 $values[] = htmlspecialchars($row['nombre_aula']);
  
 $values[] = htmlspecialchars($row['capacidad']);
  
  if ($ajax)
  {
    $json_data['aaData'][] = $values;
  }
  else
  {
    echo "<tr>\n<td>\n";
    echo implode("</td>\n<td>", $values);
    echo "</td>\n</tr>\n";
  }
}



//HASTA ACA FUNCION QUE HACE MUESTRA
  
  
  
// Get non-standard form variables
$search_str = get_form_var('search_str', 'string');
$search_pos = get_form_var('search_pos', 'int');
$total = get_form_var('total', 'int');
$advanced = get_form_var('advanced', 'int');
$ajax = get_form_var('ajax', 'int');  // Set if this is an Ajax request
$datatable = get_form_var('datatable', 'int');  // Will only be set if we're using DataTables


// Get the start day/month/year and make them the current day/month/year
$day = get_form_var('from_day', 'int');
$month = get_form_var('from_month', 'int');
$year = get_form_var('from_year', 'int');


//VARIABLES DECLARADAS ANTERIORMENTE


//ESTO METI YO (OBTENGO VARIABLES DEL FORM)
$inicio = get_form_var('search_ini', 'time');
$fin = get_form_var('search_end', 'time');
$plazas = get_form_var('count', 'int');

//FORMATEO VARIABLES NECESARIAS
	$ini_hora = substr($inicio,0,2);
	$ini_min = substr($inicio,3,5);
	
	$fin_hora = substr($fin,0,2);
	$fin_min = substr($fin,3,5);
	
	$tiempo_ini = mktime($ini_hora, $ini_min, 0, $month, $day, $year);
	$tiempo_fin = mktime($fin_hora, $fin_min, 0, $month, $day, $year);
	
	$tiempo_temprano = mktime(5, 0, 0, $month, $day, $year);
	$tiempo_tarde = mktime(23, 59, 0, $month, $day, $year);




// If we haven't been given a sensible date then use today's
if (!isset($day) || !isset($month) || !isset($year) || !checkdate($month, $day, $year))
{
  $day   = date("d");
  $month = date("m");
  $year  = date("Y");
}

// If we're going to be doing something then check the CSRF token
//if (isset($search_str) && ($search_str !== ''))OOOOOOOOOOOOOOOOOOOOJJJJJJJJJJJJOOOOOOOOOOOOOOOO
if (isset($plazas) && ($plazas !== ''))
{
  Form::checkToken();
}

// Check the user is authorised for this page
checkAuthorised();

// Also need to know whether they have admin rights
$user = getUserName();
$is_admin =  (isset($user) && authGetUserLevel($user)>=2) ;

// Set up for Ajax.   We need to know whether we're capable of dealing with Ajax
// requests, which will only be if (a) the browser is using DataTables and (b)
// we can do JSON encoding.    We also need to initialise the JSON data array.
$ajax_capable = $datatable && function_exists('json_encode');


//COMENTE DESDE DECLARACION DE VARIABLES - HASTA ACA

if ($ajax)
{
  $json_data['aaData'] = array();
}

//if (!isset($search_str))
if (!isset($plazas))
{
  $plazas = '';
}
  
if (!$ajax)
{
  print_header($day, $month, $year, $area, isset($room) ? $room : null, $search_str);

  if (!empty($advanced))
  {  
	
	  
    echo "<form class=\"form_general\" id=\"search_form\" method=\"post\" action=\"searchx.php\">\n";
    echo Form::getTokenHTML() . "\n";
    ?>

      <fieldset>
      <legend><?php echo get_vocab("advanced_search") ?></legend>
      
      
   <!--ESTO COMENTE
         
        <div id="div_search_str">
          <label for="search_str"><?php /* echo get_vocab("search_for") */?> </label>
          <input type="search" id="search_str" name="search_str" required autofocus>
        </div>   
      <div id="div_search_from">
          <?php
          /*
          echo "SEARCH X";
	      echo "<label>" . get_vocab("from") . "</label>\n";
          genDateSelector ("from_", $day, $month, $year);
          */?> 
        </div> 
        
        HASTA ACAA-->
        
  
<!--ESTO AGREGUE - DIBUJO FORM-->
        
        <div id="div_search_str">
          <?php
	   echo "<label>Fecha </label>\n";
          genDateSelector ("from_", $day, $month, $year);
          ?>
        </div> 

        <div id="div_search_str">
	      <label for="search_ini">Hora de inicio: </label>
	      <input type="time" id="search_ini" name="search_ini" required>
	    </div>

        <div id="div_search_str">
	      <label for="search_end">Hora de fin: </label>
	      <input type="time" id="search_end" name="search_end" required>
	    </div>

        <div id="div_search_str">
	      <label for="count">Plazas: </label>
	      <input type="search" id="count" name="count" required>
	    </div>

      <!--FIN ESTO AGREGUE -->
      
        <div id="search_submit">
          <input class="submit" type="submit" value="<?php echo get_vocab("search_button") ?>">
        </div>
      </fieldset>
    </form>
    <?php
    output_trailer();
    exit;
 }




// CHEQUEA QUE EL CAMPO OBLIGATORIO CONTENGA DATOS

  if (!isset($plazas) || ($plazas === ''))
  {
    echo "<p class=\"error\">" . get_vocab("invalid_search") . "</p>";
    output_trailer();
	echo "\n";
    exit;
  }
  


  // now is used so that we only display entries newer than the current time
  echo "<h3>";
  echo get_vocab("search_results") . ": ";

/*
//COMENTEEE

  echo "\"<span id=\"search_str\">" . htmlspecialchars($search_str) . "</span>\"";
*/

//AGREGUE  - MUESTRA LEYENDA CON DATOS INGRESADOS

    echo $day . "/" . $month . "/" . $year . 
  	   " entre " . $inicio . " hasta " . $fin . " horas, con espacio para " . $plazas . " alumnos o más.";
	
//FIN AGREGUE	   
	   
  echo "</h3>\n";
  
//COMENTE } 


// if (!$ajax)



// This is the main part of the query predicate, used in both queries:
// NOTE: syntax_caseless_contains() modifies our SQL params for us

// COMENTE 

$sql_params = array();
$sql_pred = "(( " . db()->syntax_caseless_contains("R.capacity", $plazas, $sql_params). ")";



// Also need to search custom fields (but only those with character data,
// which can include fields that have an associative array of options)


// COMENTE

$fields = db()->field_info($tbl_entry);
foreach ($fields as $field)
{
  if (!in_array($field['name'], $standard_fields['entry']))
  {
    // If we've got a field that is represented by an associative array of options
    // then we have to search for the keys whose values match the search string
    if (isset($select_options["entry." . $field['name']]) && 
        is_assoc($select_options["entry." . $field['name']]))
    {
      foreach($select_options["entry." . $field['name']] as $key => $value)
      {
        // We have to use strpos() rather than stripos() because we cannot
        // assume PHP5
        if (($key !== '') && (strpos(utf8_strtolower($value), utf8_strtolower($plazas)) !== FALSE))
        {
          $sql_pred .= " OR (R." . db()->quote($field['room_name']) . "=?)";
          $sql_params[] = $key;
        }
      }
    }
    elseif ($field['nature'] == 'character')
    {
      $sql_pred .= " OR (" . db()->syntax_caseless_contains("R." . db()->quote($field['room_name']), $plazas, $sql_params).")";
    }
  }
}

$sql_pred .= ") AND (E.end_time > ?)";
$sql_params[] = $now;
$sql_pred .= " AND (E.room_id = R.id) AND (R.area_id = A.id)";

//HASTA ACA




// If we're not an admin (they are allowed to see everything), then we need
// to make sure we respect the privacy settings.  (We rely on the privacy fields
// in the area table being not NULL.   If they are by some chance NULL, then no
// entries will be found, which is at least safe from the privacy viewpoint)



// COMENTE

if (!$is_admin)
{
  if (isset($user))
  {
    // if the user is logged in they can see:
    //   - all bookings, if private_override is set to 'public'
    //   - their own bookings, and others' public bookings if private_override is set to 'none'
    //   - just their own bookings, if private_override is set to 'private'
    $sql_pred .= " AND (
                        (A.private_override='public') OR
                        (A.private_override='none')
                        )
                       )";
    $sql_params[] = $user;
    $sql_params[] = $user;
  }
  else
  {
    // if the user is not logged in they can see:
    //   - all bookings, if private_override is set to 'public'
    //   - public bookings if private_override is set to 'none'
    $sql_pred .= " AND (
                        (A.private_override='public') OR
                        (
                         (A.private_override='none') AND 
                        )
                       )";
  }
}


//HASTA ACA



// The first time the search is called, we get the total
// number of matches.  This is passed along to subsequent
// searches so that we don't have to run it for each page.



/*
if (!isset($total))
{
  $sql = "SELECT count(*)
          FROM $tbl_entry E, $tbl_room R, $tbl_area A
          WHERE $sql_pred";

  $total = db()->query1($sql, $sql_params);
} */

//COMENTE 
/*

if (($total <= 0) && !$ajax)
{
  echo "<p id=\"nothing_found\">" . get_vocab("nothing_found") . "</p>\n";
  output_trailer();
  exit;
}

*/
//HASTA ACA

if(!isset($plazas) || ($search_pos <= 0))
{
  $search_pos = 0;
}
else if($search_pos >= $total)
{
  $search_pos = $total - ($total % $search["count"]);
}




// If we're Ajax capable and this is not an Ajax request then don't ouput
// the table body, because that's going to be sent later in response to
// an Ajax request - so we don't need to do the query


if (!$ajax_capable || $ajax)
{// Now we set up the "real" query
/*  
//SELECT oRIGINAL
  
  $sql = "SELECT E.id AS entry_id, E.create_by, E.name, E.description, E.start_time,
                 R.area_id, A.enable_periods
            FROM $tbl_entry E, $tbl_room R, $tbl_area A
           WHERE $sql_pred
        ORDER BY E.start_time asc"; */


include "../../conexion.php";

//MISELECT
$sql = 	"SELECT DISTINCT R.id AS id_aula, R.room_name AS nombre_aula, R.capacity AS capacidad, A.id AS id_area, A.area_name AS nombre_area
		FROM mrbs_room R, mrbs_area A
		WHERE (R.capacity >= $plazas) AND (R.area_id  = A.id) AND NOT EXISTS
        		(SELECT *
				FROM mrbs_entry E
				WHERE E.room_id = R.id AND
				($tiempo_ini BETWEEN E.start_time AND E.end_time OR 
				 $tiempo_fin BETWEEN E.start_time AND E.end_time))
ORDER BY R.capacity asc";

				
//SELECT CON LEFT JOIN CON DOS TABLAS (DEVUELVE AULAS "NUNCA" OCUPADAS)

/*$sql = "SELECT R.id AS id_aula, R.room_name AS nombre_aula, R.capacity AS capacidad, R.area_id AS area_id,  E.start_time AS inicio_reserva, E.end_time AS fin_reserva, E.name AS nombre_reserva
				FROM $tbl_room R LEFT OUTER JOIN $tbl_entry E ON R.id = E.room_id
				WHERE (R.capacity >= $plazas) AND (E.id IS NULL)		
				ORDER BY R.capacity asc";  */
				
				
//SELECT QUE OTIENE DATOS DE AULAS QUE CUMPLEN CON LA CAPACIDAD	Y ESTAN OCUPADAS EN EL RANGO (FUNCIONA)

/*$sql = "SELECT R.id AS id_aula, R.room_name AS nombre_aula, R.capacity AS capacidad, R.area_id AS area_id, A.area_name AS nombre_area, E.name AS nombre_reserva
		FROM $tbl_room R LEFT JOIN $tbl_area A ON R.area_id = A.id LEFT JOIN $tbl_entry E ON 
				R.id = E.room_id
		WHERE R.capacity >= $plazas AND R.area_id = A.id AND R.id = E.room_id AND
		     (E.start_time > $tiempo_temprano AND E.end_time < $tiempo_tarde) AND
			 ((E.start_time BETWEEN $tiempo_ini AND $tiempo_fin OR E.end_time BETWEEN $tiempo_ini AND $tiempo_fin) OR (E.start_time < $tiempo_ini AND E.end_time > $tiempo_fin))
			 ORDER BY R.capacity asc"; */
		


//OBTIENE TODAS LAS RESERVAS QUE ESTAN FUERA DEL RANGO INGRESADO (FUNCIONA)

/*$sql = "SELECT R.id AS id_aula, R.room_name AS nombre_aula, R.capacity AS capacidad, R.area_id AS area_id, A.id AS id_area, A.area_name AS nombre_area, E.start_time AS inicio_reserva, E.end_time AS fin_reserva, E.name AS nombre_reserva
				FROM $tbl_room R, $tbl_area A, $tbl_entry E
				WHERE R.capacity >= $plazas AND R.area_id = A.id AND E.room_id = R.id AND 
					 (E.start_time > $tiempo_temprano AND E.end_time < $tiempo_tarde) AND
					NOT ((E.start_time BETWEEN $tiempo_ini AND $tiempo_fin OR 
				      E.end_time BETWEEN $tiempo_ini AND $tiempo_fin) OR 
					       (E.start_time < $tiempo_ini AND E.end_time > $tiempo_fin)) 
				ORDER BY R.capacity asc";*/
	
	
//PRUEBA CON 3 TABLAS	
	
/*$sql = "SELECT R.id AS id_aula, R.room_name AS nombre_aula, R.capacity AS capacidad, A.id AS id_area, A.area_name AS nombre_area
		FROM $tbl_room R, $tbl_area A
		WHERE NOT EXISTS 
				(SELECT DISTINCT R.id AS id_aula, R.room_name AS nombre_aula, R.capacity AS capacidad, A.id AS id_area, A.area_name AS nombre_area
				FROM $tbl_room R, $tbl_area A, $tbl_entry E
				WHERE R.area_id = A.id AND E.room_id = R.id AND
				($tiempo_ini BETWEEN E.start_time AND E.end_time OR 
				 $tiempo_fin BETWEEN E.start_time AND E.end_time)
				ORDER BY R.capacity asc))";*/
					
		
$resultado = mysqli_query( $conexion , $sql ) or die ( "Algo Falla en la consulta a la base de datos");

/*	
//MI TABLA

echo "<table class=\admin_table display\>";
				echo "<tr>";
				echo "<td>Nombre del area</td>";
				echo "<td>Nombre del aula</td>";
				//echo "<td>Nombre Materia</td>";
				echo "<td>Capacidad</td>";
				//echo "<td>Hora Inicio Reserva</td>";
 				//echo "<td>Hora Fin Reserva</td>";
				//echo "<td>Fecha Reserva</td>";
				echo "</tr>";
	while ($datos = mysqli_fetch_object( $resultado )){	
				echo "<tr>";
				echo "<td>$datos->nombre_area</td>";
				echo "<td>$datos->nombre_aula</td>";
				//echo "<td>$datos->nombre_reserva</td>";				
				echo "<td>$datos->capacidad</td>";
				//echo "<td>" . date('H:i', $datos->inicio_reserva) . "</td>";
				//echo "<td>" . date('H:i', $datos->fin_reserva) . "</td>";
				//echo "<td>" . date('d-m-Y', $datos->ini_reserva) . "</td>";				
				echo "</tr>";
	
	}
	echo "</table>";
	
*/
	
  // If it's an Ajax query we want everything.  Otherwise we use LIMIT to just get
  // the stuff we want.
 
 

 //COMENTE OJOOOOO 

  if (!$ajax)
  {
    $sql .= " " . db()->syntax_limit($search["count"], $search_pos);
  }

  // this is a flag to tell us not to display a "Next" link
  $result = db()->query($sql, $sql_params);
  $num_records = $result->count();


  
  //HASTA ACA OJOOOOO

}


// COMENTE

if (!$ajax_capable)
{
  //echo generate_search_nav_html($search_pos, $total, $num_records, $search_str);
  //echo generate_search_nav_html($id_aula, $nombre_area, $nombre_aula , $capacidad);
}


if (!$ajax)
{
  echo "<div id=\"search_output\" class=\"datatable_container\">\n";
  echo "<table id=\"search_results\" class=\"admin_table display\"";
  // Put the search parameters as data attributes so that the JavaScript can use them
  echo ' data-nombre_area=" . $datos->nombre_area . "';
  echo ' data-nombre_aula=" . $datos->nombre_aula . "';
  echo ' data-capacidad=" . $datos->capacidad . "';

  
  echo ">\n";
  echo "<thead>\n";
  echo "<tr>\n";
  // We give some columns a type data value so that the JavaScript knows how to sort them
  echo "<th>" . get_vocab("Nombre del area") . "</th>\n";
  echo "<th>" . get_vocab("Nombre del aula") . "</th>\n";
  echo "<th>" . get_vocab("Capacidad") . "</th>\n";
  echo "</tr>\n";
  echo "</thead>\n";
  echo "<tbody>\n";
  echo "\n";
}

// If we're Ajax capable and this is not an Ajax request then don't ouput
// the table body, because that's going to be sent later in response to
// an Ajax request
if (!$ajax_capable || $ajax)
{
  for ($i = 0; ($row = $result->row_keyed($i)); $i++)
  {
    output_row($row);
	echo "\n";
  }
}

if ($ajax)
{
  http_headers(array("Content-Type: application/json"));
  echo json_encode($json_data);
}/*
else
{
  echo "</tbody>\n";
  echo "</table>\n";
  */
//HASTA ACAAAAAAAAAAAAAAAAAAAAAAAAAAA!!  

  
//AGREGUEEE YOOOOOOOOOOOOOOOO


//COMENTE

if (!$ajax_capable)
{
//  echo generate_search_nav_html($search_str, $total, $num_records, $search_str);
  //echo generate_search_nav_html($id_aula, $nombre_area, $nombre_aula , $capacidad);
}

if (!$ajax)
{
  echo "<div id=\"search_output\" class=\"datatable_container\">\n";
  echo "<table id=\"search_results\" class=\"admin_table display\"";
  // Put the search parameters as data attributes so that the JavaScript can use them
  
//HASTA ACA
 
// YYYYYYYYYYYYYYYYYYYYOOOOOOOOOOOOOOOOOOO
/*  echo ' data-search_str="' . htmlspecialchars($search_str) . '"';
  echo ' data-from_day="' . htmlspecialchars($day) . '"';
  echo ' data-from_month="' . htmlspecialchars($month) . '"';
  echo ' data-from_year="' . htmlspecialchars($year) . '"';*/
//HASTA AAAAAAAAAAAAAAACCCCCCCCAAAAAAAAAAAAAAAAAA


//COMENTE

  echo ' data-nombre_area="' . $datos->nombre_area . '"';
  echo ' data-nombre_aula="' . $datos->nombre_aula . '"';
  echo ' data-capacidad="' . $datos->capacidad . '"';


  echo ">\n";
  echo "<thead>\n";
  echo "<tr>\n";

//HASTA ACA

  // We give some columns a type data value so that the JavaScript knows how to sort them
//YOOOOOOOOOOOOOOO
  echo "<th>" . get_vocab("Nombre del area") . "</th>\n";
  echo "<th>" . get_vocab("Nombre del aula") . "</th>\n";
  echo "<th>" . get_vocab("Capacidad") . "</th>\n";
//HASTA ACCCCCCCAAAAAAAAAAAA!!!  
  



//COMENTE

  echo "</tr>\n";
  echo "</thead>\n";
  echo "<tbody>\n";
}

// If we're Ajax capable and this is not an Ajax request then don't ouput
// the table body, because that's going to be sent later in response to
// an Ajax request


//COMENTE

if (!$ajax_capable || $ajax)
{
  for ($i = 0; ($row = $result->row_keyed($i)); $i++)
  {
    output_row($row);
	echo "\n";
  }
}

if ($ajax)
{
  http_headers(array("Content-Type: application/json"));
  echo json_encode($json_data);
}
else
{
  echo "</tbody>\n";
  echo "</table>\n";
  echo "<br>";
  echo "</div>\n";
  output_trailer();
  echo "<br>";
}
}


