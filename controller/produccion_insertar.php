<?php

require_once __DIR__ . "/../model/produccion_model.php";

$fecha = $_POST["fecha"] ?? "";
$cantidades = $_POST["cantidades"] ?? [];

if ($fecha === "" || empty($cantidades)) {
    header("Location: ../producciones.php?error=datos_incompletos");
    exit();
}

if (existeProduccionFecha($fecha)) {
    header("Location: ../producciones.php?error=fecha_existente");
    exit();
}

// $cantidades=[
//     '1' => 1,
//     '7' => 0,
//     '10' => 1,
//     '11' => 2
// ]

foreach ($cantidades as $id_gallina => $cantidad) {
    insertarProduccion($id_gallina, $fecha, $cantidad);
    
}

header("Location: ../producciones.php");
exit();
