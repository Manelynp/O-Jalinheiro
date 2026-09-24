<?php

require_once __DIR__ . "/../model/gallina_model.php";

$id        = (int)$_POST["id"];
$nombre    = $_POST["nombreGallina"];
$fecha_nacimiento = $_POST["fechaNac_gallina"];
$fecha_alta = $_POST["fechaAlta_gallina"];
$raza = $_POST["nombreRaza"];

// El controller no habla con la base de datos: se lo delega al modelo
actualizarGallinas($id, $nombre, $fecha_nacimiento, $fecha_alta, $raza);

// Tras guardar, volvemos a la ficha para ver los datos ya actualizados
header("Location: ../gallinas.php");
exit();