<?php
include "./conexion.php";
$Pais=$_POST['Pais'];
?>
<?php 
$sql9=$conexion->query("SELECT 
    SUBSTRING_INDEX(Ciudad_de_Residencia, '/', 1) AS Ciudad, 
    COUNT(*) AS residentes 
FROM 
    colombianos_registrados_en_el_exterior_20240927
WHERE 
    Pais = '$Pais'
GROUP BY 
    Ciudad;");
$cont=0;
 while ($data = $sql9->fetch_object()) {
   $cont=$cont+1;
     ?>
        <tr>
         <th scope="row"><?=$cont?></th>
         <td><?=$data->Ciudad?></td>
         <td><?=$data->residentes?></td>
        </tr>
<?php } 
?>