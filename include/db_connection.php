<?php

$host       = "localhost";
$usuario    = "root";
$clave      = "";
$base_datos = "ojalinheiro";

// Abrimos la conexión
$db = mysqli_connect($host, $usuario, $clave, $base_datos);

// Comprobamos que la conexión se ha realizado correctamente
if (!$db) {
    exit("Error de conexión: " . mysqli_connect_error());
}

// Forzamos que la conexión trabaje en UTF-8 (para tildes, ñ, etc.)
mysqli_set_charset($db, "utf8mb4");
