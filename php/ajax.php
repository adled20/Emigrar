<?php
include "./conexion.php";
$hola=$_POST['busqueda'];
$sql4=$conexion->query("SELECT Ciudad_de_Residencia, count(*) FROM new_schema.colombianos_registrados_en_el_exterior_20240927
where Pais='$hola'
group by Ciudad_de_Residencia");
while ($data = $sql4->fetch_object()) {
   ?>

    <option><?=$data->Ciudad_de_Residencia?></option>
<?php
}
?>

