<?php

require_once __DIR__ . "/../include/db_connection.php";

function mostrarBajas()
{
    global $db;

    $datos = [];
    $sql = "SELECT b.id_gallina, g.nombre , b.fecha, b.causa
            FROM baja b
            RIGHT JOIN gallina g ON b.id_gallina = g.id
            WHERE b.id_gallina IS NOT NULL
            ORDER BY g.id, b.fecha DESC";

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

function insertarGallinaBaja($idGallina, $fecha, $causa) 
{
    global $db;

    $sql = "INSERT INTO baja (id_gallina, fecha, causa)
            VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($db, $sql);

    if (!$stmt) {
        exit("Error al preparar la consulta: " . mysqli_error($db));
    }

    mysqli_stmt_bind_param($stmt, "iss", $idGallina, $fecha, $causa);

    $resultado = mysqli_stmt_execute($stmt);

    if (!$resultado) {
        exit("Error al insertar gallina: " . mysqli_stmt_error($stmt));
    }

    $nuevoId = mysqli_insert_id($db);

    mysqli_stmt_close($stmt);

    return $nuevoId;
}

function actualizarGallinasbajas($id_gallina, $fecha, $causa) 
{
    global $db;

    $sql = "UPDATE baja SET fecha = ?, causa = ? WHERE id_gallina = ?";
    $stmt = mysqli_prepare($db, $sql);

    if (!$stmt) {
        exit("Error al preparar la consulta: " . mysqli_error($db));
    }

    mysqli_stmt_bind_param($stmt, "ssi", $fecha, $causa, $id_gallina);

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

function mostrarBajaPorId($id) 
{
    global $db;

    $sql = "SELECT * FROM baja b JOIN gallina g
            ON b.id_gallina=g.id WHERE b.id_gallina = ?";
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
    $baja = mysqli_fetch_assoc($result);

    mysqli_stmt_close($stmt);

    return $baja;
}

function eliminarGallinaBaja($id) 
{
    global $db;

    $sql = "DELETE FROM baja WHERE id_gallina = ?";
    $stmt = mysqli_prepare($db, $sql);

    if (!$stmt) {
        exit("Error al preparar la consulta: " . mysqli_error($db));
    }

    mysqli_stmt_bind_param($stmt, "i", $id);

    $resultado = mysqli_stmt_execute($stmt);

    if (!$resultado) {
        exit("Error al eliminar gallina de baja: " . mysqli_stmt_error($stmt));
    }

    $filasEliminadas = mysqli_stmt_affected_rows($stmt);

    mysqli_stmt_close($stmt);

    return $filasEliminadas;
}
