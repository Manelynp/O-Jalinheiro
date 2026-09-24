<?php

require_once __DIR__ . "/model/estadisticas_model.php";
require_once __DIR__ . "/model/produccion_model.php";
require_once __DIR__ . "/model/gallina_model.php";
require_once __DIR__ . "/model/raza_model.php";
require_once __DIR__ . "/model/baja_model.php";

$producciones = mostrarTodos();
$gallinas = mostrarGallinas();
$razas = mostrarRazas();
$bajas = mostrarBajas();
$produccionesHoy = mostrarProduccionHoy();
$mejorDia = mostrarMejorDia();


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>O Jalinheiro</title>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="shortcut icon" href="./img/hen_icon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
</head>

<body>
    <?php include("include/cabecera.php"); ?>
    <main>
        <section id="dashboard">
            <h1>Resumen de la granja</h1>
            <div class="contenedor">
                <div class="dashboard-card">
                    <div class="metric-heading">
                        <span class="material-symbols-outlined icono">egg</span>
                        <?php
                        $totalhuevos = 0;
                        foreach ($producciones as $produccion) {
                            $totalhuevos += $produccion['cantidad'];
                        }
                        ?>
                        <h2>Huevos producidos</h2>
                    </div>
                    <p class="produccion-cantidad"><?= $totalhuevos ?></p>
                </div>
                <div class="dashboard-card">
                    <div class="metric-heading">
                        <span class="material-symbols-outlined icono">cruelty_free</span>
                        <h2>Gallinas</h2>
                    </div>
                    <?php
                    $totalGallinas = count($gallinas);
                    ?>
                    <p class="produccion-cantidad"><?= $totalGallinas ?></p>
                </div>
                <div class="dashboard-card">
                    <div class="metric-heading">
                        <span class="material-symbols-outlined icono">pets</span>
                        <h2>Razas</h2>
                    </div>
                    <?php
                    $totalRazas = count($razas);
                    ?>
                    <p class="produccion-cantidad"><?= $totalRazas ?></p>
                </div>
                <div class="dashboard-card">
                    <div class="metric-heading">
                        <span class="material-symbols-outlined icono">skull</span>
                        <h2>Bajas</h2>
                    </div>
                    <p class="produccion-cantidad"><?= count($bajas) ?></p>
                </div>
            </div>
        </section>

        <section class="produccion-resumen">

            <div class="produccion-card">
                <div class="metric-heading">
                    <span class="material-symbols-outlined icono">egg</span>
                    <h2>Producción de hoy</h2>
                </div>

                <?php foreach ($produccionesHoy as $produccionHoy) {?>
                <p><?= htmlspecialchars($produccionHoy["fecha_recogida"]) ?></p>
                <p class="produccion-cantidad"><?= (int)$produccionHoy["cantidad"] ?> <span>huevos</span></p>
                <?php } ?>

                <a href="./producciones.php" class="btn">Registrar producción</a>
            </div>


            <div class="produccion-card">
                <div class="metric-heading">
                    <span class="material-symbols-outlined icono">emoji_events</span>
                    <h2>Mejor día</h2>
                </div>

                <?php foreach ($mejorDia as $mejor) {?>
                <p class="produccion-cantidad"><?= $mejor["cantidad"] ?> <span>huevos</span></p>

                <p class="produccion-fecha"><?= $mejor["fecha_recogida"] ?></p>
                <?php } ?>
            </div>

        </section>

    </main>
    <?php include("include/pie.php"); ?>
</body>

</html>