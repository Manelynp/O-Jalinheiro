<?php

require_once __DIR__ . "/../model/baja_model.php";

// Recogemos y validamos los datos que ha enviado el formulario por POST.
$nombre = $_POST["nombre"];
$fecha = $_POST["fecha"];
$causa = $_POST["causa"];


$idNuevoGallinaBaja = insertarGallinaBaja($nombre, $fecha, $causa);

// Tras guardar, redirigimos al inicio para ver la gallina baja ya insertado
header("Location: ../bajas.php");
exit();
