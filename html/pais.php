<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/index.css">
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
$sql4=$conexion->query("SELECT Pais,count(*) from colombianos_registrados_en_el_exterior_20240927
group by Pais");
$sql7=$conexion->query("SELECT Ciudad_de_Residencia, count(*) FROM colombianos_registrados_en_el_exterior_20240927
where Pais='Venezuela'
group by Ciudad_de_Residencia");
 $arreglo=array();
        
        while ($data = mysqli_fetch_array($sql4)) {
          $arreglo[]=$data;
        ?>
          

        <?php
        }
        while ($data = mysqli_fetch_array($sql7)) {
          $arreglo2[]=$data;
      
          

        
        }
?>

<label for="validationCustom04" class="form-label">State</label>
    <select class="form-select" id="validationCustom04" required>
      <option selected disabled value="">Choose...</option>
      <option>...</option>
    </select>
<div class="contenedor_infor">
    <p>En el siguiente grafico podremos apreciar, información de la población colombiana. Residente y registrada en el exterior. En este caso la información mostrada por el grafico de abajo refleja la cantidad de colombianos registrados en cada pacís.</p>
<div id="Grafico">
  
</div>




<p>Aunque la gráfica muestre la información de manera compacta y buena, abajo, en forma de tabla dejamos de igual manera la información correspondiente a los colombianos en el exterior. </p>
<div class="container">
  <div class="row">
    <div class="col">
    <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Pais</th>
      <th scope="col">Colombianos registrados</th>
    </tr>
  </thead>
 
  <tbody>
    <?php 
   $sql9=$conexion->query("SELECT Pais,count(*) as 'num_reg' from colombianos_registrados_en_el_exterior_20240927
group by Pais");
$cont=0;
    while ($data = $sql9->fetch_object()) {
      $cont=$cont+1;
        ?>
           <tr>
            <th scope="row"><?=$cont?></th>
            <td><?=$data->Pais?></td>
            <td><?=$data->num_reg?></td>
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

<script>
var datosproductos = <?php echo json_encode($arreglo); ?>;
var cod_of = [];
var num_emp = [];
var pieData = [];

for (var i = 0; i < datosproductos.length; i++) {
    pieData.push({value: datosproductos[i][1], name: datosproductos[i][0]});
    cod_of.push(datosproductos[i][0]);
    num_emp.push(datosproductos[i][1]);
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
            name: 'País',
            nameLocation: 'middle',
            nameTextStyle: {
                fontWeight: 'bold',
                fontSize: 14,
                padding: 10
            },
            data: cod_of,
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
            data: num_emp
        }
    ]
};

if (option && typeof option === 'object') {
    myChart.setOption(option);
}

window.addEventListener('resize', myChart.resize);
</script>
<script src="./js/Apache_ciudades.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</html>