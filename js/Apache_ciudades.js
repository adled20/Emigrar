<script>
var datosproductos2 = <?php echo json_encode($arreglo2); ?>;
var nom_ciudad = [];
var num_perso = [];

for (var i = 0; i < datosproductos2.length; i++) {
    nom_ciudad.push(datosproductos2[i][0]);
    num_perso.push(datosproductos2[i][1]);
}

var dom = document.getElementById('chart-containerr');
var myChart = echarts.init(dom, null, {
  renderer: 'canvas',
  useDirtyRect: false
});

var option = {
  title: {
    text: 'Cantidad de Personas por Ciudad',
    subtext: 'Datos de Colombianos Registrados en el Exterior',
    left: 'center'
  },
  tooltip: {
    trigger: 'item',
    formatter: '{b} : {c} ({d}%)', // Muestra información al pasar el mouse
  },
  legend: {
    show: false, // Oculta la leyenda por completo
  },
  series: [
    {
      name: 'Número de Personas',
      type: 'pie',
      radius: '55%',
      center: ['40%', '50%'],
      data: nom_ciudad.map((ciudad, index) => ({
        name: ciudad,
        value: num_perso[index]
      })),
      emphasis: {
        itemStyle: {
          shadowBlur: 10,
          shadowOffsetX: 0,
          shadowColor: 'rgba(0, 0, 0, 0.5)'
        }
      },
      label: {
        show: false, // Oculta las etiquetas en el gráfico
      },
      labelLine: {
        show: false // Oculta las líneas de referencia
      }
    }
  ]
};

if (option && typeof option === 'object') {
  myChart.setOption(option);
}

window.addEventListener('resize', myChart.resize);

</script>
