<?php
include "./conexion.php";
$Pais=$_POST['Pais'];

$sql4=$conexion->query("SELECT 
    SUBSTRING_INDEX(Ciudad_de_Residencia, '/', 1) AS Ciudad, 
    COUNT(*) AS residentes 
FROM 
    colombianos_registrados_en_el_exterior_20240927
WHERE 
    Pais = '$Pais'
GROUP BY 
    Ciudad");
$Ciudad=[];
while ($data = mysqli_fetch_array($sql4)) {

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
            name: 'País',
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

