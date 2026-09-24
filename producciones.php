<?php

require_once __DIR__ . "/model/produccion_model.php";
require_once __DIR__ . "/model/gallina_model.php";

$todos = mostrarTodos();
$fechas = mostrarFechas();


$fecha = $_GET['fechaFiltrar'] ?? '';
$error = $_GET['error'] ?? '';

$producciones = mostrarProduccion($fecha);
$gallinas = mostrarGallinasVivas();



?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>O Jalinheiro | Producciones</title>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="shortcut icon" href="./img/hen_icon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
</head>

<body>
    <?php include("include/cabecera.php"); ?>
    <main>
        <section id="producciones">
            <h1>Producciones</h1>
            <?php if ($error === "fecha_existente") { ?>
                <p class="mensaje-produccion mensaje-error">
                    Ya existe una producción registrada para esa fecha. Elige otra fecha o elimina la producción existente antes de volver a registrarla.
                </p>
            <?php } ?>

            <div class="contenedor">
                <div class="card produccion-card">
                    <div class="produccion-heading">
                        <span class="material-symbols-outlined icono">egg</span>
                        <div>
                            <h2>Registrar producción</h2>
                            <p>Selecciona la cantidad recogida de cada gallina.</p>
                        </div>
                    </div>
                    <form action="controller/produccion_insertar.php" method="post">
                        <div class="produccion-form">
                            <div class="fecha-produccion">
                                <label for="fecha">Fecha recogida: </label>
                                <input type="date" name="fecha" id="fecha" value="<?= date('Y-m-d') ?>">
                            </div>

                            <table class="registro-produccion">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Gallina</th>
                                        <th>0</th>
                                        <th>1</th>
                                        <th>2</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($gallinas as $gallina) { ?>
                                        <tr>
                                            <td class="gallina-id">#<?= (int)$gallina["id"] ?></td>
                                            <td>
                                                <?= htmlspecialchars($gallina["nombre"]) ?>
                                            </td>
                                            <?php for ($cantidad = 0; $cantidad <= 2; $cantidad++) { ?>
                                                <td class="cantidad-opcion">
                                                    <label class="cantidad-tile" for="cantidad_<?= (int)$gallina["id"] ?>_<?= $cantidad ?>">
                                                        <input type="radio"
                                                            name="cantidades[<?= (int)$gallina["id"] ?>]"
                                                            id="cantidad_<?= (int)$gallina["id"] ?>_<?= $cantidad ?>"
                                                            value="<?= $cantidad ?>"
                                                            <?= $cantidad === 0 ? 'checked' : '' ?>>
                                                        <span></span>
                                                    </label>
                                                </td>
                                            <?php } ?>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <input class="boton guardar-produccion" type="submit" value="Guardar producción">
                        </div>
                    </form>
                </div>

                <div class="tablaProducciones">
                    <div class="produccion-heading">
                        <span class="material-symbols-outlined icono">filter_alt</span>
                        <h2>Resumen de producción</h2>
                    </div>

                    <div class="produccion-form filtrar">
                        <form action="" method="get">
                            <div class="fecha-produccion">
                                <label for="fechaFiltrar">Fecha: </label>
                                <select name="fechaFiltrar" id="fechaFiltrar" onchange="this.form.submit()">
                                    <!-- <select name="fechaFiltrar" id="fechaFiltrar" onchange="eliminarProduccion()"> -->
                                    <option value="" <?= $fecha === '' ? 'selected' : '' ?>>
                                        Todos
                                    </option>
                                    <?php foreach ($fechas as $fechaDisponible) { ?>
                                        <option
                                            value="<?= htmlspecialchars($fechaDisponible['fecha_recogida']) ?>"
                                            <?= $fecha === $fechaDisponible['fecha_recogida'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($fechaDisponible['fecha_recogida']) ?>
                                        </option>
                                    <?php } ?>
                                </select>
                                <!-- <input class="boton filtrar" type="submit" value="Filtrar"> -->
                            </div>
                        </form>


                        <div id="delete-form">
                            <form action="controller/produccion_eliminar.php" method="post"
                                onsubmit="return confirm('¿Seguro que quieres eliminar producción de esta fecha?');">
                                <input type="hidden" name="fechaFiltrar" value="<?= htmlspecialchars($fecha) ?>">
                                <button id="delete" class="boton" type="submit">Eliminar producción de esta fecha</button>
                            </form>
                        </div>
                    </div>

                    <table>
                        <?php if ($fecha === "") { ?>
                            <tr>
                                <th>Id</th>
                                <th>Gallina</th>
                                <th>Huevos producidos</th>
                            </tr>
                        <?php
                        } else { ?>
                            <tr>
                                <th>Id</th>
                                <th>Gallina</th>
                                <th>Cantidad</th>
                            </tr>
                        <?php } ?>
                        <?php if ($fecha === "") { ?>
                            <?php foreach ($todos as $todo) { ?>
                                <tr>
                                    <td><?= htmlspecialchars($todo["id"]) ?></td>
                                    <td><?= htmlspecialchars($todo["nombre"]) ?></td>
                                    <td><?= htmlspecialchars($todo["cantidad"]) ?></td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>

                            <?php foreach ($producciones as $produccion) { ?>
                                <tr>
                                    <td><?= htmlspecialchars($produccion["id"]) ?></td>
                                    <td><?= htmlspecialchars($produccion["nombre"]) ?></td>
                                    <td><?= htmlspecialchars($produccion["cantidad"]) ?></td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                        <tfoot>
                            <tr>
                                <th colspan="2">Total</th>
                                <?php
                                $totalCantidad = 0;
                                $filasResumen = $fecha === "" ? $todos : $producciones;
                                foreach ($filasResumen as $produccion) {
                                    $totalCantidad += $produccion["cantidad"] ?? 0;
                                }
                                ?>
                                <th><?= $totalCantidad ?></th>
                            </tr>
                        </tfoot>

                    </table>
                </div>

            </div>

        </section>

    </main>
    <?php include("include/pie.php"); ?>
    <script src="./js/index.js"></script>
</body>

</html>