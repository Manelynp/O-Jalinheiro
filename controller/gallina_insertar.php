<?php

require_once __DIR__ . "/../model/gallina_model.php";

// Recogemos y validamos los datos que ha enviado el formulario por POST.
$nombre = $_POST["nombre"];
$fecha_nacimiento = $_POST["fecha_nacimiento"];
$fecha_alta = $_POST["fecha_alta"];
$raza = (int)$_POST["raza"];


$idNuevoGallina = insertarGallina($nombre, $fecha_nacimiento, $fecha_alta, $raza);

// Tras guardar, redirigimos al inicio para ver la gallina ya insertado
header("Location: ../gallinas.php");
exit();
