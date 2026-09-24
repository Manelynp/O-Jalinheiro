<?php

require_once __DIR__ . "/../include/db_connection.php";

function mostrarTodos() 
{
    global $db;

    $datos = [];
    $sql = "SELECT g.id, g.nombre, SUM(p.cantidad) AS cantidad
            FROM produccion p
            JOIN gallina g
            ON p.id_gallina=g.id
            LEFT JOIN baja b
            ON b.id_gallina=g.id
            WHERE b.id_gallina IS NULL
            GROUP BY g.id, g.nombre
            ORDER BY g.id";
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

function mostrarProduccion($fecha)
{
    global $db;

    $datos = [];
    $sql = "SELECT g.id, g.nombre, p.cantidad
            FROM produccion p
            JOIN gallina g
            ON p.id_gallina=g.id
            LEFT JOIN baja b
            ON b.id_gallina=g.id
            WHERE b.id_gallina IS NULL
            AND p.fecha_recogida = ?
            ORDER BY g.id";
    $stmt = mysqli_prepare($db, $sql);

    if (!$stmt) {
        exit("Error al preparar la consulta: " . mysqli_error($db));
    }

    $busqueda = $fecha;

    mysqli_stmt_bind_param($stmt, "s", $busqueda);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    while ($fila = mysqli_fetch_assoc($result)) {
        $datos[] = $fila;
    }

    mysqli_stmt_close($stmt);

    return $datos;
}

function mostrarGallinasVivas() 
{
    global $db;

    $datos = [];
    $sql = "SELECT g.id, g.nombre, b.fecha, b.causa
FROM gallina g
LEFT JOIN baja b
ON g.id = b.id_gallina
WHERE b.fecha IS NULL
ORDER BY g.id";

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

function mostrarFechas()
{
    global $db;

    $datos = [];
    $sql = "SELECT DISTINCT fecha_recogida
            FROM produccion
            ORDER BY fecha_recogida DESC";

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

function existeProduccionFecha($fecha_recogida)
{
    global $db;

    $sql = "SELECT 1 FROM produccion WHERE fecha_recogida = ? LIMIT 1";
    $stmt = mysqli_prepare($db, $sql);

    if (!$stmt) {
        exit("Error al preparar la consulta: " . mysqli_error($db));
    }

    mysqli_stmt_bind_param($stmt, "s", $fecha_recogida);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    $existe = mysqli_stmt_num_rows($stmt) > 0;
    mysqli_stmt_close($stmt);

    return $existe;
}

function insertarProduccion($id_gallina, $fecha_recogida, $cantidad) 
{
    global $db;

    $sql = "INSERT INTO produccion (id_gallina, fecha_recogida, cantidad)
            VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($db, $sql);

    if (!$stmt) {
        exit("Error al preparar la consulta: " . mysqli_error($db));
    }

    mysqli_stmt_bind_param($stmt, "isi", $id_gallina, $fecha_recogida, $cantidad);

    $resultado = mysqli_stmt_execute($stmt);

    if (!$resultado) {
        exit("Error al insertar produccion: " . mysqli_stmt_error($stmt));
    }

    $nuevoId = mysqli_insert_id($db);

    mysqli_stmt_close($stmt);

    return $nuevoId;
}

function eliminarProduccion($fecha_recogida) 
{
    global $db;

    $sql = "DELETE FROM produccion WHERE fecha_recogida = ?";
    $stmt = mysqli_prepare($db, $sql);

    if (!$stmt) {
        exit("Error al preparar la consulta: " . mysqli_error($db));
    }

    mysqli_stmt_bind_param($stmt, "s", $fecha_recogida);

    $resultado = mysqli_stmt_execute($stmt);

    if (!$resultado) {
        exit("Error al eliminar produccion: " . mysqli_stmt_error($stmt));
    }

    $filasEliminadas = mysqli_stmt_affected_rows($stmt);

    mysqli_stmt_close($stmt);

    return $filasEliminadas;
}
