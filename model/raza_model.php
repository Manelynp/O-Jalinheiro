<?php

require_once __DIR__ . "/../include/db_connection.php";

function mostrarRazas() 
{
    global $db;

    $datos = [];
    $sql = "SELECT r.id, r.nombre AS raza, r.descripcion, SUM(p.cantidad) AS cantidad, COUNT(DISTINCT g.id) as cantidad_gallinas
FROM gallina g RIGHT JOIN raza r 
ON g.id_raza=r.id
LEFT JOIN produccion p
ON p.id_gallina=g.id
GROUP BY r.id;";
    $result = mysqli_query($db, $sql);

    if (!$result) {
        exit("Error en la consulta: " . mysqli_error($db));
    }

    while ($fila = mysqli_fetch_assoc($result)) {
        $datos[] = $fila;
    }

    mysqli_free_result($result);

    return $datos;
}

function insertarRaza($nombre, $descripcion) 
{
    global $db;

    $sql = "INSERT INTO raza (nombre, descripcion)
            VALUES (?, ?)";
    $stmt = mysqli_prepare($db, $sql);

    if (!$stmt) {
        exit("Error al preparar la consulta: " . mysqli_error($db));
    }

    mysqli_stmt_bind_param($stmt, "ss", $nombre, $descripcion);

    $resultado = mysqli_stmt_execute($stmt);

    if (!$resultado) {
        exit("Error al insertar raza: " . mysqli_stmt_error($stmt));
    }

    $nuevoId = mysqli_insert_id($db);

    mysqli_stmt_close($stmt);

    return $nuevoId;
}

function actualizarRazas($id, $nombre, $descripcion) 
{
    global $db;

    $sql = "UPDATE raza SET nombre = ?, descripcion = ? WHERE id = ?";
    $stmt = mysqli_prepare($db, $sql);

    if (!$stmt) {
        exit("Error al preparar la consulta: " . mysqli_error($db));
    }

    mysqli_stmt_bind_param($stmt, "ssi", $nombre, $descripcion, $id);

    $resultado = mysqli_stmt_execute($stmt);

    if (!$resultado) {
        exit("Error al actualizar raza: " . mysqli_stmt_error($stmt));
    }

    // mysqli_stmt_affected_rows: en un UPDATE no hay id nuevo que devolver,
    // así que en su lugar comprobamos cuántas filas se han modificado
    $filasModificadas = mysqli_stmt_affected_rows($stmt);

    mysqli_stmt_close($stmt);

    return $filasModificadas;
}

function eliminarRaza($id) 
{
    global $db;

    $sql = "DELETE FROM raza WHERE id = ?";
    $stmt = mysqli_prepare($db, $sql);

    if (!$stmt) {
        exit("Error al preparar la consulta: " . mysqli_error($db));
    }

    mysqli_stmt_bind_param($stmt, "i", $id);

    $resultado = mysqli_stmt_execute($stmt);

    if (!$resultado) {
        exit("Error al eliminar raza: " . mysqli_stmt_error($stmt));
    }

    $filasEliminadas = mysqli_stmt_affected_rows($stmt);

    mysqli_stmt_close($stmt);

    return $filasEliminadas;
}

function mostrarRazaPorId($id) 
{
    global $db;

    $sql = "SELECT * FROM raza WHERE id = ?";
    $stmt = mysqli_prepare($db, $sql);

    if (!$stmt) {
        exit("Error al preparar la consulta: " . mysqli_error($db));
    }

    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    // mysqli_stmt_get_result convierte el resultado de la consulta preparada
    // en un resultado normal, para poder seguir usando mysqli_fetch_assoc
    $result = mysqli_stmt_get_result($stmt);

    // Como mucho hay una fila, así que llamamos a fetch_assoc una sola vez (sin while)
    $raza = mysqli_fetch_assoc($result);

    mysqli_stmt_close($stmt);

    return $raza;
}