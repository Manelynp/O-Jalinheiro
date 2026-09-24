<?php

require_once __DIR__ . "/../model/produccion_model.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST" || !isset($_POST["fechaFiltrar"])) {
	exit("Solicitud no válida.");
}

$fecha_recogida = $_POST["fechaFiltrar"];

if ($fecha_recogida === "") {
	exit("Fecha de producción no válida.");
}

eliminarProduccion($fecha_recogida);

header("Location: ../producciones.php");
exit();
