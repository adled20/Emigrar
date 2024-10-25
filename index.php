<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./css/index.css">
    <title>Document</title>
</head>
<body>
    <?php 
    include "./php/conexion.php";
    ?>
<nav class="navbar navbar-expand-lg navbar-light bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand" href="./html/pais.php">Ver Paises</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
      <li class="nav-item dropdown">
     
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          Ver ciudades de cada país
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
          <form action="./html/Ciudades.php" id="FormPais" method="post">
          <?php
           $traerpais=$conexion->query("SELECT Pais, count(*) FROM colombianos_exterior
        group by Pais");
          while ($data = $traerpais->fetch_object()) {
      
      ?>

        <li><a class="dropdown-item" href="#" type="submit" name='<?=$data->Pais?>' onclick="TomarPais('<?=$data->Pais?>')"><?=$data->Pais?></a></li>
       
<?php } ?>

<input type="hidden" name="NombrePais" id="NombrePais">

          </form>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="./html/Oficina_Registro.php">Ver oficinas de registro</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="./html/Edades.php">ver edades</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="./html/Nivel_academico.php" tabindex="-1" aria-disabled="true">Ver nivel academico</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="./html/Areas_Conocimiento.php" tabindex="-1" aria-disabled="true">Ver areas de conocimiento</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="./php/probabilidad.php" tabindex="-1" >Probabilidades</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

</body>
<script>
  function TomarPais(nombre) {

  document.getElementById('NombrePais').value =nombre;
  document.getElementById("FormPais").submit();
    
  }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</html>