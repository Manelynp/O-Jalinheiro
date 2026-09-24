<?php

require_once __DIR__ . "/../model/raza_model.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST" || !isset($_POST["id"])) {
	exit("Solicitud no válida.");
}

$id = (int)$_POST["id"];

if ($id <= 0) {
	exit("Identificador de raza no válido.");
}

eliminarRaza($id);

header("Location: ../razas.php");
exit();
