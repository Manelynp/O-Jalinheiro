<?php

require_once __DIR__ . "/../model/baja_model.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST" || !isset($_POST["id"])) {
	exit("Solicitud no válida.");
}

$id = (int)$_POST["id"];

if ($id <= 0) {
	exit("Identificador de baja no válido.");
}

eliminarGallinaBaja($id);

header("Location: ../bajas.php");
exit();
