<?php
include "conexion.php";
#$sqlprop = "call estadistica.histograma(@MATEMATICAS, @NINGUNA, @NO_INDICA, @ECONOMIA, @COCINA, @CIENCIAS_SOCIALES, @CIENCIAS_SALUD, @CIENCIAS_EDUCACION, @ARTES, @AVIACION, @AGRONOMIA, @INGENIERIA);
#";
     #    $call = $conexion->query($sqlprop);

    #$sqlprop2 = "select @MATEMATICAS as 'MATEMATICAS', @NINGUNA as 'NINGUNA', @NO_INDICA as 'NO INDICA', @ECONOMIA as 'ECONOMIA', @COCINA as 'COCINA',
 #@CIENCIAS_SOCIALES as 'CIENCIAS SOCIALES', @CIENCIAS_SALUD as 'CIENCIAS SALUD', @CIENCIAS_EDUCACION as ' CIENCIAS EDUCACION', @ARTES as 'ARTES', @AVIACION as 'AVIACION', @AGRONOMIA as 'AGRONOMIA', @INGENIERIA as 'INGENIERIA';

#";
      #   $valores_prop2 = $conexion->query($sqlprop2);

     #  $valor_assoc = $valores_prop2->fetch_assoc();
    
    #   $total=$valor_assoc["MATEMATICAS"]+
    #   $valor_assoc["NINGUNA"]+$valor_assoc["ECONOMIA"]+$valor_assoc["NO INDICA"]+$valor_assoc["COCINA"]+$valor_assoc["CIENCIAS SOCIALES"]+$valor_assoc["CIENCIAS SALUD"]+$valor_assoc["CIENCIAS EDUCACION"]+$valor_assoc["ARTES"]+$valor_assoc["AGRONOMIA"]+$valor_assoc["INGENIERIA"]+$valor_assoc["AVIACION"];
  ##     $prop_no_indica = $valor_assoc["NO INDICA"]*100/$total;

    

// Verificar la conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Obtener valores de los filtros seleccionados
$filtro_genero = isset($_GET['filtro_genero']) ? $_GET['filtro_genero'] : '';
$filtro_estado_civil = isset($_GET['filtro_estado_civil']) ? $_GET['filtro_estado_civil'] : '';
$filtro_area_conocimiento = isset($_GET['filtro_area_conocimiento']) ? $_GET['filtro_area_conocimiento'] : '';
$filtro_sin_indicar = isset($_GET['filtro_sin_indicar']) ? $_GET['filtro_sin_indicar'] : '';
$filtro_ninguno = isset($_GET['filtro_ninguno']) ? $_GET['filtro_ninguno'] : '';
// Definir el número de registros por página
$registros_por_pagina = 10;
$pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$inicio = ($pagina_actual > 1) ? ($pagina_actual * $registros_por_pagina) - $registros_por_pagina : 0;

// Aplicar los filtros seleccionados
$filtros = [];
if (!empty($filtro_genero)) {
    $filtros[] = "Genero = '$filtro_genero'";
}
if (!empty($filtro_estado_civil)) {
    $filtros[] = "Estado_civil = '$filtro_estado_civil'";
}
if (!empty($filtro_area_conocimiento)) {
    $filtros[] = "Area_Conocimiento LIKE '$filtro_area_conocimiento%' ";
}
if (!empty($filtro_sin_indicar)) {
    $filtros[] = "Area_Conocimiento != '(NO REGISTRA)' AND Area_Conocimiento != 'NO INDICA'";
}
if (!empty($filtro_ninguno)) {
    $filtros[] = "Area_Conocimiento != 'NINGUNA'";
}



// Consulta SQL para contar el total de personas registradas
$sql_total_personas = "SELECT COUNT(*) as total FROM colombianos_exterior  ";
if (count($filtros) > 0) {
    $sql_total_personas .= " WHERE " . implode(" AND ", $filtros);
}
$total_personas_result = $conexion->query($sql_total_personas);
$total_personas = $total_personas_result->fetch_assoc()['total'];

// Construir la consulta SQL con los filtros aplicados
$sql_base = "
    SELECT 
        Genero,
        Estado_civil,
        Area_Conocimiento,
        COUNT(*) as total_personas,
        (COUNT(*) * 100.0 / $total_personas) as probabilidad
    FROM colombianos_exterior 
   
";



// Agregar los filtros a la consulta
if (count($filtros) > 0) {
    $sql_base .= " WHERE " . implode(" AND ", $filtros);
}
$sql_base .= " GROUP BY Genero, Estado_civil, Area_Conocimiento";
// Consulta para contar el total de registros después de los filtros aplicados
$total_registros_sql = "SELECT COUNT(*) as total FROM ($sql_base) as subquery";
$total_registros_result = $conexion->query($total_registros_sql);
$total_registros = $total_registros_result->fetch_assoc()['total'];

// Agregar la paginación a la consulta
$sql = $sql_base . " LIMIT $inicio, $registros_por_pagina";

// Ejecutar la consulta
$result = $conexion->query($sql);

// Verificar si hay resultados
if ($result->num_rows > 0) {
    $resultados = $result->fetch_all(MYSQLI_ASSOC);
} else {
    echo "No se encontraron resultados.";
}

// Calcular el total de páginas
$total_paginas = ceil($total_registros / $registros_por_pagina);

// Cerrar la conexión
$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla de contingencia de probabilidades</title>
    <link rel="stylesheet" href="../css/index.css">
    <!-- Incluyendo Bootstrap para estilo -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding: 20px;
        }
        .table-container {
            max-width: 1000px;
            margin: 0 auto;
        }
        .table th, .table td {
            text-align: center;
            vertical-align: middle;
        }
        .pagination {
            justify-content: center;
        }
        .form-container {
            margin-bottom: 20px;
        }
    </style>
</head>

<body style="padding:0px;">
<nav class="navbar navbar-expand-lg navbar-light bg-primary">
  <div class="container-fluid">

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
 

        <li class="nav-item">
          <a class="nav-link active" href="../html/pais.php" tabindex="-1" >Regresar al inicio</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
    <div class="table-container">
    <input type="hidden" name="NombrePais" id="NombrePais">

        <h2 class="text-center mb-4">Tabla de Probabilidades Conjuntas</h2>
    <!-- <p>La probabilidad de que una persona inmigrante de colombia no haya especificado su Area de conocimiento es de:<?php echo" ".round($prop_no_indica,2)."%<br>"; ?></p> -->

        <!-- Filtros -->
        <form class="form-container" method="GET" action="">
            <div class="row">
                <div class="col-md-4">
                    <label for="filtro_genero">Filtrar por Género:</label>
                    <select class="form-select" id="filtro_genero" name="filtro_genero">
                        <option value="">Todos</option>
                        <option value="Masculino" <?= $filtro_genero == 'Masculino' ? 'selected' : ''; ?>>Masculino</option>
                        <option value="Femenino" <?= $filtro_genero == 'Femenino' ? 'selected' : ''; ?>>Femenino</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="filtro_estado_civil">Filtrar por Estado Civil:</label>
                    <select class="form-select" id="filtro_estado_civil" name="filtro_estado_civil">
                        <option value="">Todos</option>
                        <option value="Soltero" <?= $filtro_estado_civil == 'Soltero' ? 'selected' : ''; ?>>Soltero</option>
                        <option value="Casado" <?= $filtro_estado_civil == 'Casado' ? 'selected' : ''; ?>>Casado</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="filtro_area_conocimiento">Filtrar por Área de Conocimiento:</label>
                    <select class="form-select" id="filtro_area_conocimiento" name="filtro_area_conocimiento">
                        <option value="">Todas</option>
                        <option value="Matemáticas" <?= $filtro_area_conocimiento == 'Matemáticas' ? 'selected' : ''; ?>>Matemáticas</option>
                        <option value="Ingeniería" <?= $filtro_area_conocimiento == 'Ingeniería' ? 'selected' : ''; ?>>Ingeniería</option>
                        <option value="Ciencias Sociales" <?= $filtro_area_conocimiento == 'Ciencias Sociales' ? 'selected' : ''; ?>>Ciencias Sociales</option>
                        <option value="BELLAS ARTES" <?= $filtro_area_conocimiento == 'BELLAS ARTES' ? 'selected' : ''; ?>>BELLAS ARTES</option>
                        <option value="AVIACIÓN" <?= $filtro_area_conocimiento == 'AVIACIÓN' ? 'selected' : ''; ?>>AVIACIÓN</option>
                        <option value="CIENCIAS DE LA SALUD" <?= $filtro_area_conocimiento == 'CIENCIAS DE LA SALUD' ? 'selected' : ''; ?>>CIENCIAS DE LA SALUD</option>
                        <option value="CIENCIAS DE LA EDUCACIÓN" <?= $filtro_area_conocimiento == 'CIENCIAS DE LA EDUCACIÓN' ? 'selected' : ''; ?>>CIENCIAS DE LA EDUCACIÓN</option>
                        <option value="COCINA" <?= $filtro_area_conocimiento == 'COCINA' ? 'selected' : ''; ?>>COCINA</option>
                        <option value="AGRONOMÍA" <?= $filtro_area_conocimiento == 'AGRONOMÍA' ? 'selected' : ''; ?>>AGRONOMÍA</option>


                    </select>
                </div>
                <div class="col-md-4">
                <label for="filtro_area_conocimiento">Omitir Area Conocimiento sin indicar</label>
                <input type="checkbox" name="filtro_sin_indicar" id="filtro_sin_indicar" <?= $filtro_sin_indicar == 'escogido' ? 'checked' : ''; ?> value="escogido">
                </div>
                <div class="col-md-4">
                <label for="filtro_area_conocimiento">Omitir ninguna Area Conocimiento</label>
                <input class="form-checkbox" type="checkbox" name="filtro_ninguno" id="filtro_ninguno" <?= $filtro_ninguno == 'escogido' ? 'checked' : ''; ?> value="escogido">
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Aplicar Filtros</button>
            </div>
        </form>

        <!-- Tabla de Probabilidades Conjuntas -->
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Género</th>
                    <th>Estado Civil</th>
                    <th>Área de Conocimiento</th>
                    <th>Cantidad</th>
                    <th>Probabilidad (%)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Mostrar los resultados en la tabla si hay datos
                if (!empty($resultados)) {
                    foreach ($resultados as $fila) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($fila['Genero']) . "</td>";
                        echo "<td>" . htmlspecialchars($fila['Estado_civil']) . "</td>";
                        echo "<td>" . htmlspecialchars($fila['Area_Conocimiento']) . "</td>";
                        echo "<td>" . htmlspecialchars($fila['total_personas']) . "</td>";
                        echo "<td>" . number_format($fila['probabilidad'], 2) . "</td>";
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>

        <!-- Paginación -->
      
        <nav aria-label="Page navigation">
            <ul class="pagination">

                <!-- Botón "Anterior" -->
                <li class="page-item <?= ($pagina_actual <= 1) ? 'disabled' : ''; ?>">
                    <a class="page-link" href="?pagina=<?= $pagina_actual - 1; ?>&filtro_genero=<?= $filtro_genero; ?>&filtro_estado_civil=<?= $filtro_estado_civil; ?>&filtro_area_conocimiento=<?= $filtro_area_conocimiento; ?>&filtro_sin_indicar=<?= $filtro_sin_indicar; ?>&filtro_ninguno=<?= $filtro_ninguno; ?>">Anterior</a>
                </li>

                <!-- Números de página -->
                <?php for ($i = max(1, $pagina_actual - 2); $i <= min($pagina_actual + 2, $total_paginas); $i++) : ?>
                    <li class="page-item <?= ($i == $pagina_actual) ? 'active' : ''; ?>">
                        <a class="page-link" href="?pagina=<?= $i; ?>&filtro_genero=<?= $filtro_genero; ?>&filtro_estado_civil=<?= $filtro_estado_civil; ?>&filtro_area_conocimiento=<?= $filtro_area_conocimiento; ?>&filtro_sin_indicar=<?= $filtro_sin_indicar; ?>&filtro_ninguno=<?= $filtro_ninguno; ?>"><?= $i; ?></a>
                    </li>
                <?php endfor; ?>

                <!-- Botón "Siguiente" -->
                <li class="page-item <?= ($pagina_actual >= $total_paginas) ? 'disabled' : ''; ?>">
                    <a class="page-link" href="?pagina=<?= $pagina_actual + 1; ?>&filtro_genero=<?= $filtro_genero; ?>&filtro_estado_civil=<?= $filtro_estado_civil; ?>&filtro_area_conocimiento=<?= $filtro_area_conocimiento; ?>&filtro_sin_indicar=<?= $filtro_sin_indicar; ?>&filtro_ninguno=<?= $filtro_ninguno; ?>">Siguiente</a>
                </li>
            </ul>
        </nav>
    </div>

    <!-- Bootstrap JS (opcional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>


</html>