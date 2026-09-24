<?php

require_once __DIR__ . "/../model/baja_model.php";

$id        = (int)$_POST["id"];
$fecha = $_POST["fecha"];
$causa = $_POST["causa"];

// El controller no habla con la base de datos: se lo delega al modelo
actualizarGallinasbajas($id, $fecha, $causa);

// Tras guardar, volvemos a la ficha para ver los datos ya actualizados
header("Location: ../bajas.php");
exit();