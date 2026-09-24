<?php

require_once __DIR__ . "/../model/raza_model.php";

$id        = (int)$_POST["id"];
$nombre    = $_POST["nombre"];
$descripcion = $_POST["descripcion"];

// El controller no habla con la base de datos: se lo delega al modelo
actualizarRazas($id, $nombre, $descripcion);

// Tras guardar, volvemos a la ficha para ver los datos ya actualizados
header("Location: ../razas.php");
exit();