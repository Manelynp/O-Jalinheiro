<?php

require_once __DIR__ . "/../include/db_connection.php";

function mostrarTopGallinas() 
{
    global $db;

    $datos = [];
    $sql = "SELECT g.nombre, SUM(p.cantidad) AS cantidad
FROM produccion p
JOIN gallina g
ON p.id_gallina=g.id
GROUP BY g.nombre
ORDER BY cantidad DESC
LIMIT 5";

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

function mostrarGallinaDeLaSemana() 
{
    global $db;

    $datos = [];
    $sql = "SELECT g.nombre, SUM(p.cantidad) AS cantidad
            FROM gallina g JOIN produccion p
            ON g.id=p.id_gallina
            WHERE p.fecha_recogida >= CURRENT_DATE() - INTERVAL 7 DAY
            GROUP BY g.id, g.nombre
            ORDER BY cantidad DESC
            LIMIT 1";

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

function mostrarRazaPromedio() 
{
    global $db;

    // Media semanal por raza: promedio de huevos recogidos por cada raza
    // en los últimos 7 días.
    $datos = [];
    $sql = "SELECT r.nombre, ROUND(AVG(p.cantidad), 2) AS promedio
            FROM raza r 
            JOIN gallina g ON r.id = g.id_raza
            JOIN produccion p ON p.id_gallina = g.id
            WHERE p.fecha_recogida >= CURRENT_DATE() - INTERVAL 7 DAY
            GROUP BY r.id, r.nombre
            ORDER BY promedio DESC";

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

function mostrarProduccionSemanal() 
{
    global $db;

    $datos = [];
    $sql = "SELECT fecha_recogida, SUM(cantidad) AS cantidad
            FROM produccion
            WHERE fecha_recogida >= CURRENT_DATE() - INTERVAL 7 DAY
            GROUP BY fecha_recogida
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

function mostrarTopProduccion() 
{
    global $db;

    $datos = [];
    $sql = "SELECT fecha_recogida, SUM(cantidad) AS cantidad
            FROM produccion
            GROUP BY fecha_recogida
            ORDER BY cantidad DESC
            LIMIT 3";

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

function mostrarProduccionHoy() 
{
    global $db;

    $datos = [];
    $sql = "SELECT fecha_recogida, SUM(cantidad) AS cantidad
            FROM produccion
            WHERE fecha_recogida >= CURRENT_DATE() - INTERVAL 7 DAY
            GROUP BY fecha_recogida
            ORDER BY fecha_recogida DESC
            LIMIT 1";

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

function mostrarMejorDia() 
{
    global $db;

    $datos = [];
    $sql = "SELECT fecha_recogida, SUM(cantidad) AS cantidad
            FROM produccion
            GROUP BY fecha_recogida
            ORDER BY cantidad DESC
            LIMIT 1";

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