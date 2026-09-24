<?php

require_once __DIR__ . "/model/estadisticas_model.php";

$topGallinas = mostrarTopGallinas();
$gallinasDeLaSemana = mostrarGallinaDeLaSemana();
$razasPromedio = mostrarRazaPromedio();
$produccionesSemanal = mostrarProduccionSemanal();
$topProduccion = mostrarTopProduccion();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>O Jalinheiro | Estadísticas</title>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="shortcut icon" href="./img/hen_icon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
</head>

<body>
    <?php include("include/cabecera.php"); ?>
    <main>
        <section id="estadisticas">
            <h1>Estadísticas</h1>

            <!-- TOP 5 -->
            <section class="estadisticas-top">
                <div class="estadisticas-heading">
                    <span class="material-symbols-outlined icono">emoji_events</span>
                    <h2>Top 5 productoras</h2>
                </div>

                <div class="ranking-lista">

                    <?php
                    $posicion = 1;

                    foreach ($topGallinas as $topGallina) {
                        $cantidad = (int)$topGallina["cantidad"];
                    ?>

                        <div class="ranking-fila">

                            <span class="ranking-posicion">
                                <?= $posicion ?>
                            </span>

                            <span class="ranking-nombre">
                                <?= htmlspecialchars($topGallina["nombre"]) ?>
                            </span>

                            <div class="ranking-barra">
                                <span
                                    style="width: <?= $cantidad * 100 / max(array_column($topGallinas, 'cantidad')) ?>%">
                                </span>
                            </div>

                            <strong>
                                <?= $cantidad ?> huevos
                            </strong>

                        </div>

                    <?php
                        $posicion++;
                    }
                    ?>

                </div>
            </section>

            <!-- GALLINA DE LA SEMANA -->
            <div class="estadisticas-grid">
                <article class="estadistica-card estadistica-destacada">
                    <div class="estadistica-titulo">
                        <span class="material-symbols-outlined icono">star</span>
                        <h2>Gallina de la semana</h2>
                    </div>
                    <?php foreach ($gallinasDeLaSemana as $gallina) { ?>
                        <div class="estadistica-principal">
                            <strong><?= htmlspecialchars($gallina["nombre"]) ?></strong>
                            <span><?= htmlspecialchars($gallina["cantidad"]) ?> huevos</span>
                        </div>
                    <?php } ?>
                </article>

                <!-- MEDIA POR RAZA -->
                <article class="estadistica-card">
                    <div class="estadistica-titulo">
                        <span class="material-symbols-outlined icono">egg_alt</span>
                        <h2>Media por raza (últimos 7 días)</h2>
                    </div>
                    <p class="estadistica-subtitulo">Promedio de huevos por raza en la última semana</p>
                    <div class="estadistica-lista">
                        <?php foreach ($razasPromedio as $raza) { ?>
                            <div class="estadistica-fila">
                                <span><?= htmlspecialchars($raza["nombre"]) ?></span>
                                <strong><?= number_format((float)$raza["promedio"], 2, ',', '.') ?> huevos</strong>
                            </div>
                        <?php } ?>
                    </div>
                </article>

                <!-- STATISTICS CARDS -->
                <article class="estadistica-card">
                    <div class="estadistica-titulo">
                        <span class="material-symbols-outlined icono">calendar_month</span>
                        <h2>Producción semanal</h2>
                    </div>
                    <div class="estadistica-lista">
                        <?php foreach ($produccionesSemanal as $produccionSemanal) { ?>
                            <div class="estadistica-fila">
                                <span><?= htmlspecialchars($produccionSemanal["fecha_recogida"]) ?></span>
                                <strong><?= (int)$produccionSemanal["cantidad"] ?> huevos</strong>
                            </div>
                        <?php } ?>
                    </div>
                </article>

                <!-- TOP 3 DÍAS -->
                <article class="estadistica-card">
                    <div class="estadistica-titulo">
                        <span class="material-symbols-outlined icono">emoji_events</span>
                        <h2>Top 3 días</h2>
                    </div>
                    <div class="estadistica-lista">
                        <?php foreach ($topProduccion as $produccion) { ?>
                            <div class="estadistica-fila">
                                <span><?= htmlspecialchars($produccion["fecha_recogida"]) ?></span>
                                <strong><?= (int)$produccion["cantidad"] ?> huevos</strong>
                            </div>
                        <?php } ?>
                    </div>
                </article>
            </div>
        </section>

    </main>
    <?php include("include/pie.php"); ?>
</body>

</html>