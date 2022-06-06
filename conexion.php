<?php
	// Ejemplo de conexi&oacute;n a base de datos MySQL con PHP.
	//
	// Datos de la base de datos
	$usuario = 'fcyt';
	$password = 'fcytadmin21+';
	$servidor = '172.17.0.2';
	$basededatos = 'mrbs';


$conexion = new mysqli($servidor, $usuario, $password, $basededatos, 3306);
if ($conexion->connect_errno) {
    echo "Fallo al conectar a MySQL: (" . $conexion->connect_errno . ") " . $conexion->connect_error;
}

	// Selecci&oacute;n de la base de datos a utilizar
	$db = mysqli_select_db( $conexion, $basededatos ) or die ( "ERROR! Al conectar a la base de datos" );

// echo $mysqli->host_info . "\n"; 

?>
