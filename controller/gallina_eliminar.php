<?php

require_once __DIR__ . "/../model/gallina_model.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST" || !isset($_POST["id"])) {
	exit("Solicitud no válida.");
}

$id = (int)$_POST["id"];

if ($id <= 0) {
	exit("Identificador de gallina no válido.");
}

eliminarGallina($id);

header("Location: ../gallinas.php");
exit();
