<?php
$host = "127.0.0.1";
$user = "aatrox";
$psw = "ianelperro123";
$bd = "estadistica";

$conexion = mysqli_connect($host, $user, $psw, $bd);
if (!$conexion) {
	die("Problemas con la conexión" . mysql_connect_error());
}

?>