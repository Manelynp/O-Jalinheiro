<?php

require_once __DIR__ . "/../model/raza_model.php";

// Recogemos y validamos los datos que ha enviado el formulario por POST.
$nombre = $_POST["nombre"];
$descripcion = $_POST["descripcion"];

// if ($nombre === "" || $fecha_nacimiento === "" || $fecha_alta === "" || $raza <= 0) {
// 	exit("Completa todos los campos y selecciona una raza válida.");
// }

$idNuevoRaza = insertarRaza($nombre, $descripcion);

// Tras guardar, redirigimos al inicio para ver la raza ya insertado
header("Location: ../razas.php");
exit();
