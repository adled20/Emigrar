<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/index.css">
  <script
  src="https://code.jquery.com/jquery-3.7.1.js"
  integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
  crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
<script>
  $(document).ready( function () {
    $('#MyTable').DataTable({
      "language":{
        "lengthMenu":"Mostrar "+ "<select><option>10</option><option>25</option><option>50</option></select> " +" Registros por página",
        "zeroRecords":"Nada encontrado - disculpa",
        "info":"Mostrando la página _PAGE_ de _PAGES_",
        "infoEmpty":"(Filtrado de _MAX_ registros totales)",
        "search": "Buscar:",
        "paginate":{
          "next":"Siguiente",
          "previous": "Anterior"
        }
      }
    });
} );
</script>
    <title>Ciudades</title>
</head>
<body>
    <?php 
    include "../php/conexion.php";
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $NombrePais = $_REQUEST['NombrePais'];
      $Ciudad = $NombrePais;
    } else {
      echo "No se ha enviado ningún dato.";
    }
    ?>
<nav class="navbar navbar-expand-lg navbar-light bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand" href="./pais.php">Ver Paises</a>
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
          <form action="./Ciudades.php" id="FormPais" method="post">
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
        <li class="nav-item">
          <a class="nav-link active" href="../php/probabilidad.php" tabindex="-1" >Probabilidades</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<?php 

$sql7=$conexion->query("SELECT Ciudad_de_Residencia, count(*) FROM colombianos_exterior
where Pais='Venezuela'
group by Ciudad_de_Residencia");
 $arreglo2=array();
        
        while ($data = mysqli_fetch_array($sql7)) {
          $arreglo2[]=$data;
      
          

        
        }
?>



<div class="contenedor_infor">
    <p>En el siguiente grafico podremos apreciar, información de la población colombiana. Residente y registrada en el exterior. En este caso la información mostrada por el grafico de abajo refleja la cantidad de colombianos registrados en cada ciudad.</p>
<div id="Grafico">
  
</div>




<p>Aunque la gráfica muestre la información de manera compacta y buena, abajo, en forma de tabla dejamos de igual manera la información correspondiente a los colombianos en el exterior. </p>
<div class="container">
  <div class="row">
    <div class="col">
    <table id="MyTable" class="table table-striped table-hover">
  <thead>
    <tr>
      <th scope="col">Ciudad</th>
      <th scope="col">Colombianos registrados</th>
    
    </tr>
  </thead>
 
  <tbody>
    <?php 
   $sql9=$conexion->query("SELECT 
    SUBSTRING_INDEX(Ciudad_de_Residencia, '/', 1) AS Ciudad, 
    COUNT(*) AS residentes 
FROM 
    colombianos_exterior
WHERE 
    Pais = '$Ciudad'
GROUP BY 
    Ciudad");
    while ($data = $sql9->fetch_object()) {
      
        ?>
           <tr>
            <th scope="row"><?=$data->Ciudad?></th>
            <td><?=$data->residentes?></td>
           </tr>
<?php } 
?>

      
  </tbody>
</table>
    </div>
  </div>
</div>
</div>
</body>
<script src="https://fastly.jsdelivr.net/npm/echarts@5.5.1/dist/echarts.min.js"></script>

<?php
$sql1=$conexion->query("SELECT 
    SUBSTRING_INDEX(Ciudad_de_Residencia, '/', 1) AS Ciudad, 
    COUNT(*) AS residentes 
FROM 
    colombianos_exterior
WHERE 
    Pais = '$Ciudad'
GROUP BY 
    Ciudad");
$Ciudad=[];
while ($data = mysqli_fetch_array($sql1)) {

    $Ciudad[]=$data;
   ?>
    
<?php
}

?>

<script>

var DatosCiudades = <?php echo json_encode($Ciudad); ?>;
var Nom_ciudad = [];
var Num_residentes = [];



for (var i = 0; i < DatosCiudades.length; i++) {
    Nom_ciudad.push(DatosCiudades[i][0]);
    console.log(Nom_ciudad);
    Num_residentes.push(DatosCiudades[i][1]);
    console.log(Num_residentes);
}

var dom = document.getElementById('Grafico');
var myChart = echarts.init(dom, null, {
    renderer: 'canvas',
    useDirtyRect: false
});
var app = {};

var option;
let xAxisData = [];
let data1 = [];
let data2 = [];
let data3 = [];
let data4 = [];
for (let i = 0; i < 10; i++) {
  xAxisData.push('Class' + i);
  data1.push(+(Math.random() * 2).toFixed(2));
  data2.push(+(Math.random() * 5).toFixed(2));
  data3.push(+(Math.random() + 0.3).toFixed(2));
  data4.push(+Math.random().toFixed(2));
}
option = {
   
    title: {
        text: 'Número de Colombianos Registrados en el Exterior',
        left: 'center'
    },
    tooltip: {
        trigger: 'axis',
        axisPointer: {
            type: 'shadow'
        }
    },
    grid: {
        left: '10%',
        right: '10%',
        bottom: '15%',
        containLabel: true
    },
    xAxis: [
        {
            type: 'category',
            name: 'Ciudades',
            nameLocation: 'middle',
            nameTextStyle: {
                fontWeight: 'bold',
                fontSize: 14,
                padding: 10
            },
            data: Nom_ciudad,
            axisTick: {
                alignWithLabel: true
            },
            axisLabel: {
                show: false  // Opcional: oculta las etiquetas
            }
        }
    ],
    yAxis: [
        {
            type: 'value',
            name: "",
            nameLocation: 'middle',
            nameTextStyle: {
                fontWeight: 'bold',
                fontSize: 14,
                padding: 10
            }
        }
    ],
    series: [
        {
            name: 'count(*)',
            type: 'bar',
            barWidth: '60%',
            data: Num_residentes
        }
    ]
};

if (option && typeof option === 'object') {
    myChart.setOption(option);
}

window.addEventListener('resize', myChart.resize);
</script>
<script>
  function TomarPais(nombre) {

  document.getElementById('NombrePais').value =nombre;
  document.getElementById("FormPais").submit();
    
  }
</script>


<script src="./js/Apache_ciudades.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</html>