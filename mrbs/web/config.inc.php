<?php // -*-mode: PHP; coding:utf-8;-*-
namespace MRBS;

/**************************************************************************
 *   MRBS Configuration File
 *   Configure this file for your site.
 *   You shouldn't have to modify anything outside this file.
 *
 *   This file has already been populated with the minimum set of configuration
 *   variables that you will need to change to get your system up and running.
 *   If you want to change any of the other settings in systemdefaults.inc.php
 *   or areadefaults.inc.php, then copy the relevant lines into this file
 *   and edit them here.   This file will override the default settings and
 *   when you upgrade to a new version of MRBS the config file is preserved.
 **************************************************************************/

/**********
 * Timezone
 **********/
// The timezone your meeting rooms run in. It is especially important
// to set this if you're using PHP 5 on Linux. In this configuration
// if you don't, meetings in a different DST than you are currently
// in are offset by the DST offset incorrectly.
//
// Note that timezones can be set on a per-area basis, so strictly speaking this
// setting should be in areadefaults.inc.php, but as it is so important to set
// the right timezone it is included here.
//
// When upgrading an existing installation, this should be set to the
// timezone the web server runs in.  See the INSTALL document for more information.
//
// A list of valid timezones can be found at http://php.net/manual/timezones.php
// The following line must be uncommented by removing the '//' at the beginning
//$timezone = "Europe/London";
$timezone = "America/Araguaina";

/*******************
 * Database settings
 ******************/
// Which database system: "pgsql"=PostgreSQL, "mysql"=MySQL
$dbsys = "mysql";
// Hostname of database server. For pgsql, can use "" instead of localhost
// to use Unix Domain Sockets instead of TCP/IP. For mysql "localhost"
// tells the system to use Unix Domain Sockets, and $db_port will be ignored;
// if you want to force TCP connection you can use "127.0.0.1".
$db_host = "172.17.0.2";
// If you need to use a non standard port for the database connection you
// can uncomment the following line and specify the port number
$db_port = 3306;
// Database name:
$db_database = "mrbs";
// Schema name.  This only applies to PostgreSQL and is only necessary if you have more
// than one schema in your database and also you are using the same MRBS table names in
// multiple schemas.
//$db_schema = "public";
// Database login user name:
$db_login = "fcyt";
// Database login password:
$db_password = 'fcytadmin21+';
// Prefix for table names.  This will allow multiple installations where only
// one database is available
$db_tbl_prefix = "mrbs_";
// Set $db_persist to TRUE to use PHP persistent (pooled) database connections.  Note
// that persistent connections are not recommended unless your system suffers significant
// performance problems without them.   They can cause problems with transactions and
// locks (see http://php.net/manual/en/features.persistent-connections.php) and although
// MRBS tries to avoid those problems, it is generally better not to use persistent
// connections if you can.
$db_persist = FALSE;


/* Add lines from systemdefaults.inc.php and areadefaults.inc.php below here
   to change the default configuration. Do _NOT_ modify systemdefaults.inc.php
   or areadefaults.inc.php.  */


//Definicion de Usuarios
$auth["admin"][] = "mtoso";
$auth["session"] = "php";
$auth["type"] = "config";
$auth["user"]["mtoso"] = "fcytadmin";

$auth["admin"][] = "alumnado";
$auth["user"]["alumnado"] = "alum123";

//Decaro nombre de la Compania.
$mrbs_company = "Facultad de Ciencia y Tecnolog&iacute;a";

//Defino LOGO
$mrbs_company_logo = "logo.png";

//Invierto ejes de graficos
$times_along_top = TRUE;

//Definicion de Administrador
$mrbs_admin = "Area Informatica";
$mrbs_admin_mail = "fcyt_taller@uader.edu.ar";

//Definicion de TYPES
unset($booking_types);
$booking_types[] = "I";
$vocab_override["es"]["type.I"] = "P. MATEMATICA";
$booking_types[] = "F";
$vocab_override["es"]["type.F"] = "P. FISICA";
$booking_types[] = "Q";
$vocab_override["es"]["type.Q"] = "P. QUIMICA";
$booking_types[] = "T";
$vocab_override["es"]["type.T"] = "P. EDUC.TEC.";
$booking_types[] = "B";
$vocab_override["es"]["type.B"] = "P. BIOLOGIA";
$booking_types[] = "G";
$vocab_override["es"]["type.G"] = "L. BIOLOGIA";
$booking_types[] = "A";
$vocab_override["es"]["type.A"] = "A. SIST.INF.";
$booking_types[] = "L";
$vocab_override["es"]["type.L"] = "T. BALISTICA";
$booking_types[] = "P";
$vocab_override["es"]["type.P"] = "T.PAPILOSCOPIA";
$booking_types[] = "D";
$vocab_override["es"]["type.D"] = "T.DOCUMENTOLOGIA";
$booking_types[] = "S";
$vocab_override["es"]["type.S"] = "L. SIST.INF.";
$booking_types[] = "C";
$vocab_override["es"]["type.C"] = "L.CRIMINALISTICA";
$booking_types[] = "V";
$vocab_override["es"]["type.V"] = "L.ACCIDENTOLOGIA";
$booking_types[] = "E";
$vocab_override["es"]["type.E"] = "EVENTO";
$booking_types[] = "Z";
$vocab_override["es"]["type.Z"] = "COMPARTIDA";

