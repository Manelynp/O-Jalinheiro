<?php

require_once __DIR__ . "/../include/db_connection.php";

function mostrarGallinas()
{
    global $db;

    $datos = [];
    $sql = "SELECT g.id, g.nombre, g.fecha_nacimiento, g.fecha_alta, r.nombre AS raza, b.id_gallina, SUM(p.cantidad) AS cantidad
            FROM gallina g JOIN raza r 
            ON g.id_raza=r.id
            LEFT JOIN produccion p
            ON p.id_gallina=g.id
            LEFT JOIN baja b 
            ON b.id_gallina=g.id
            GROUP BY g.id";
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

function insertarGallina($nombre, $fecha_nacimiento, $fecha_alta, $raza) 
{
    global $db;

    $sql = "INSERT INTO gallina (nombre, fecha_nacimiento, fecha_alta, id_raza)
            VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($db, $sql);

    if (!$stmt) {
        exit("Error al preparar la consulta: " . mysqli_error($db));
    }

    mysqli_stmt_bind_param($stmt, "sssi", $nombre, $fecha_nacimiento, $fecha_alta, $raza);

    $resultado = mysqli_stmt_execute($stmt);

    if (!$resultado) {
        exit("Error al insertar gallina: " . mysqli_stmt_error($stmt));
    }

    $nuevoId = mysqli_insert_id($db);

    mysqli_stmt_close($stmt);

    return $nuevoId;
}

function eliminarGallina($id) {
    global $db;

        $sql = "DELETE FROM gallina
            WHERE id = ?
            AND id NOT IN (SELECT id_gallina FROM baja)
            AND id NOT IN (SELECT id_gallina FROM produccion)";
    $stmt = mysqli_prepare($db, $sql);

    if (!$stmt) {
        exit("Error al preparar la consulta: " . mysqli_error($db));
    }

    mysqli_stmt_bind_param($stmt, "i", $id);

    $resultado = mysqli_stmt_execute($stmt);

    if (!$resultado) {
        exit("Error al eliminar gallina: " . mysqli_stmt_error($stmt));
    }

    $filasEliminadas = mysqli_stmt_affected_rows($stmt);

    mysqli_stmt_close($stmt);

    return $filasEliminadas;
}

function mostrarGallinaPorId($id) 
{
    global $db;

    $sql = "SELECT * FROM gallina WHERE id = ?";
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
    $gallina = mysqli_fetch_assoc($result);

    mysqli_stmt_close($stmt);

    return $gallina;
}

function actualizarGallinas($id, $nombre, $fecha_nacimiento, $fecha_alta, $raza) 
{
    global $db;

    $sql = "UPDATE gallina SET nombre = ?, fecha_nacimiento = ?, fecha_alta = ?, id_raza = ? WHERE id = ?";
    $stmt = mysqli_prepare($db, $sql);

    if (!$stmt) {
        exit("Error al preparar la consulta: " . mysqli_error($db));
    }

    mysqli_stmt_bind_param($stmt, "ssssi", $nombre, $fecha_nacimiento, $fecha_alta, $raza, $id);

    $resultado = mysqli_stmt_execute($stmt);

    if (!$resultado) {
        exit("Error al actualizar gallina: " . mysqli_stmt_error($stmt));
    }

    // mysqli_stmt_affected_rows: en un UPDATE no hay id nuevo que devolver,
    // así que en su lugar comprobamos cuántas filas se han modificado
    $filasModificadas = mysqli_stmt_affected_rows($stmt);

    mysqli_stmt_close($stmt);

    return $filasModificadas;
}
