<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/ciudades.css">
    <title>Document</title>
</head>
<body>
    <?php 
    include "../php/conexion.php";
    ?>
<nav class="navbar navbar-expand-lg navbar-light bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand" href="./pais.php">Ver Paises</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="./Ciudades.php">Ver Ciudades</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="./Oficina_Registro.php">Ver oficinas de registro</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="./Edades.php">ver edades</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="./Nivel_academico.php" tabindex="-1" aria-disabled="true">Ver nivel academico</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="./Areas_Conocimiento.php" tabindex="-1" aria-disabled="true">Ver areas de conocimiento</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<?php 

$sql7=$conexion->query("SELECT Ciudad_de_Residencia, count(*) FROM colombianos_registrados_en_el_exterior_20240927
where Pais='Venezuela'
group by Ciudad_de_Residencia");
 $arreglo2=array();
        
        while ($data = mysqli_fetch_array($sql7)) {
          $arreglo2[]=$data;
      
          

        
        }
?>

<label for="validationCustom04" class="form-label">Seleccionar País</label>
<select class="form-select" id="validationCustom03" onchange="TomarCiudad()" required>
    <option selected disabled value="" id="NombrePais">Choose...</option>
        <?php
        $sqlPais=$conexion->query("SELECT Pais, count(*) FROM colombianos_registrados_en_el_exterior_20240927
        group by Pais");
    while ($data = $sqlPais->fetch_object()) {
      
        ?>
         
          <option><?=$data->Pais?></option>
<?php } 
?>
 </select>

<div class="contenedor_infor">
    <p>En el siguiente grafico podremos apreciar, información de la población colombiana. Residente y registrada en el exterior. En este caso la información mostrada por el grafico de abajo refleja la cantidad de colombianos registrados en cada ciudad.</p>
<div id="Grafico">
  
</div>




<p>Aunque la gráfica muestre la información de manera compacta y buena, abajo, en forma de tabla dejamos de igual manera la información correspondiente a los colombianos en el exterior. </p>
<button onclick="TablaCiudad()">Click para ver los datos representados en una tabla</button>
<div class="container">
  <div class="row">
    <div class="col">
    <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Ciudad</th>
      <th scope="col">Colombianos registrados</th>
    </tr>
  </thead>
 
  <tbody id="tabla">
   

      
  </tbody>
</table>
    </div>
  </div>
</div>
</div>
</body>
<script src="https://fastly.jsdelivr.net/npm/echarts@5.5.1/dist/echarts.min.js"></script>


<script>
  function TomarCiudad() {
        Pais= document.getElementById("validationCustom03").value;
        console.log(Pais);
      var parametros = {
        "Pais": Pais,
        "telefono": "123456789"
      };
      $.ajax({
        data: parametros,
        url: '../php/ajaxCiudad.php',
        type: 'POST',

        beforeSend: function() {
          $('#Grafico').html("Mensjae antes de enviar");

        },
        success: function(mensaje_mostrar) {
          $('#Grafico').html(mensaje_mostrar);
          

        }
      });
    }
</script>

<script>
  function TablaCiudad() {
        Pais= document.getElementById("validationCustom03").value;
        console.log(Pais);
      var parametros = {
        "Pais": Pais,
        "telefono": "123456789"
      };
      $.ajax({
        data: parametros,
        url: '../php/ajaxTablaCiudad.php',
        type: 'POST',

        beforeSend: function() {
          $('#tabla').html("Mensjae antes de enviar");

        },
        success: function(mensaje_mostrar) {
          $('#tabla').html(mensaje_mostrar);

        }
      });
    }
</script>

<script src="./js/Apache_ciudades.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</html>