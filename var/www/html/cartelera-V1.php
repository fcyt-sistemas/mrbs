<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html">

<title>Cartelera informativa - FCyT - U.A.D.E.R.</title>

<link href="SmartTab/styles/demo_style.css" rel="stylesheet" type="text/css">
<link href="SmartTab/styles/smart_tab_vertical.css" rel="stylesheet" type="text/css">

<style media="screen">

span.hover_block { 
	display: block; 
	overflow: hidden; 
	height: 285px; 
	width: 320px;
	margin-left: 120px;
	margin-left: 300px;
}
	
span.hover_block p {
	float:left;
	background: #99cc66;
	padding: 10px;
	position: relative;
	text-align: center;

}

span.hover_block p a {
	display: block;
	position: relative;
	overflow: hidden;
	height: 190px;
	width: 270px;
	padding: 15px;
	color: #e5e5e5;
	font: 35px Helvetica, Arial, sans-serif;
	border: 1px solid #000066;
}

span.hover_block p a { text-decoration: none; }

span.hover_block p img {
	position: absolute;
	top: 0;
	left: 0;
	border: 0;
}

#progressPause {
	border: 1px solid ThreedDarkShadow;
	text-align: center;
	width: 50%;
	height: 10px;
	background-color: #E0AA2A;
	margin-right: 0px;
}

.ultimosSegundos {
	color: #990000;
	font-weight: bold;
}

#reload {
	display: none;
	position: absolute; 
	left: 500px; 
	top: 200px; 
	padding: 60px;
	background-color: #99CC66;
	color: White;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 25px;
	border: 1px solid Black;
	text-align: center;
	z-index:1;
}

</style>

<script type="text/javascript" language="javascript" src="SmartTab/js/jquery-1.4.4.js"></script>
<script type="text/javascript" language="javascript" src="SmartTab/js/jquery.jcontent.0.5.js"></script>
<script type="text/javascript" language="javascript" src="SmartTab/js/jquery.easing.1.3.js"></script>
<link href="SmartTab/styles/jcontent.css" rel="stylesheet" type="text/css"/>

<!-- titulo -->
<?php
$fecha = date('d/m/Y');
$horacompleta = date('H : i');

//calculo rango horario
$hactual= date('H');
$minactual= date('i');
$hinirango= date('H')-1;
$hfinrango= date('H')+3;
$rangoini= $hinirango.":".$minactual;
$rangofin= $hfinrango.":".$minactual;

echo "<div align='center'>";
echo "<table ='1200'>";
echo "<tr>";
echo "<td width='50' align='left'><img border='0' width='160px' src='SmartTab/skins/tango/fcyt-logo.jpg'></td>";
echo "<td width='1100'><p align='center' class='titulo_b'>Cartelera Informativa - FCyT - U.A.D.E.R.</p></td>";
echo "<td width='200'><p align='center' class='titulo_b'>" . $fecha . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td width='50'><br/></td>";
echo "<td width='1100'><p class='titulo'>&nbsp;&nbsp;Actividades en curso y comprendidas entre:&nbsp;" 
						. $rangoini . " y " . $rangofin . ". </p></td>";
echo "<td width='200'><p align='center' class='titulo'>" . $horacompleta . "</td>";
echo "</tr>";
echo "</table>";

//echo "<div> &nbsp;</div>";
?>

<html>
<head>
<script type="text/JavaScript">
<!--
function timedRefresh(timeoutPeriod) {
	setTimeout("location.reload(true);",timeoutPeriod);
}
//   -->
</script>
</head>
<body onload="JavaScript:timedRefresh(1 * 60000);"><!--actualiza cada 1 minuto-->
</body>
</html>

<script type="text/javascript">

	//intervaloNoticias = 15; // segundos entre noticia y noticia
	intervaloRecarga = 5 * 60; // 5 minutos (segundos para volver a recargar la pÃ¡gina) 
	paginaVencida = false; // determina si la pÃ¡gina ha caducado (si ha superado el intervaloRecarga)

    $(document).ready(function(){
    	// Smart Tab0
//  		$('#tabs').smartTab({autoProgress: true,transitionEffect:'fade',progressInterval: intervaloNoticias * 1000});
			
		setTimeout (recargarPagina, intervaloRecarga * 1000 );
		
		function recargarPagina() {
		paginaVencida = true;
		}

		$(function() {
			$('span.hover_block').hover(function(){
				$(this).find('img').animate({top:'235px'},{queue:false,duration:500});
			}, function(){
				$(this).find('img').animate({top:'0px'},{queue:false,duration:500});
			});
		});		


		jQuery('#carousel_aulas').jcarousel({
			vertical: true,
			scroll: 1,  
			animation: "slow",
			auto: 3,   
			wrap: "last", 
			buttonNextHTML: null,
			buttonPrevHTML: null
		});

	});
		
</script>

<script type="text/javascript" language="javascript" src="SmartTab/lib/jquery.jcarousel.min.js"></script>

<!--jCarousel skin -->
<link rel="stylesheet" type="text/css" href="SmartTab/skins/tango/skin.css" />

</head>
<body>

<div id="reload">Actualizando informaci&oacute;n...</div>

<!-- LA FECHA Y HORA IBA ACA -->

<!--div id="asignacionAulas" class="jContent jc-horizontal"></div-->

 <ul id="carousel_aulas" class="jcarousel jcarousel-skin-tango"> 
  
 <!--div php include('/var/www/data.php') -->

<?php
include "datos.php";
?>

 </ul>

</body>
</html>