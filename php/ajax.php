<?php
include "./conexion.php";
$hola=$_POST['busqueda'];
$sql4=$conexion->query("SELECT Ciudad_de_Residencia, count(*) FROM colombianos_exterior
where Pais='$hola'
group by Ciudad_de_Residencia");
while ($data = $sql4->fetch_object()) {
   ?>

    <option><?=$data->Ciudad_de_Residencia?></option>
<?php
}
?>

