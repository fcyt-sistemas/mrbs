<?php
	// Ejemplo de conexi&oacute;n a base de datos MySQL con PHP.
	//
	// Datos de la base de datos
	$usuario = "root";
	$password = "fcytadmin";
	$servidor = "127.0.0.1";
	$basededatos = "mrbs";

/**
	// creaci&oacute;n de la conexi&oacute;n a la base de datos con mysql_connect()
	$conexion = mysqli_connect( $servidor, $usuario, "" ) or die ("No se ha podido conectar al servidor de Base de datos");
	
**/

$conexion = new mysqli($servidor, $usuario, $password, $basededatos, 3306);
if ($conexion->connect_errno) {
    echo "Fallo al conectar a MySQL: (" . $conexion->connect_errno . ") " . $conexion->connect_error;
}

	// Selecci&oacute;n de la base de datos a utilizar
	$db = mysqli_select_db( $conexion, $basededatos ) or die ( "ERROR! Al conectar a la base de datos" );

// echo $mysqli->host_info . "\n"; 

?>
