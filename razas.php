<?php

require_once __DIR__ . "/model/raza_model.php";

$razas = mostrarRazas();


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>O Jalinheiro | Razas</title>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="shortcut icon" href="./img/hen_icon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
</head>

<body>
    <?php include("include/cabecera.php"); ?>
    <main>
        <section id="razas">
            <h1>Gestión de razas</h1>
            <div class="contenedor">
                <div class="card">
                    <h2>Registrar nueva raza</h2>
                    <form action="controller/raza_insertar.php" method="post">
                        <div class="registrar">
                            <div>
                                <label for="nombre">Nombre:</label>
                                <input type="text" name="nombre" id="nombre" required>
                            </div>
                            <div>
                                <label for="descripcion">Descripción:</label>
                                <textarea name="descripcion" id="descripcion"></textarea>
                            </div>
                            <input class="boton" type="submit" value="Guardar raza">
                        </div>
                    </form>
                </div>

                <div class="razas_card">
                    <?php foreach ($razas as $raza) { ?>
                        <div class="card">
                            <div class="razas-img">
                                <h3><?= htmlspecialchars($raza["raza"]) ?>
                                    <a id="boton_insert" href="razas.php?id=<?= (int)$raza["id"] ?>">
                                        <span class="material-symbols-outlined edit">table_edit</span></a>
                                    <?php if ((int)$raza["cantidad_gallinas"] === 0) { ?>
                                        <form action="controller/raza_eliminar.php" method="post"
                                            onsubmit="return confirm('¿Seguro que quieres eliminar esta raza?');">
                                            <input type="hidden" name="id" value="<?= (int)$raza["id"] ?>">
                                            <button type="submit"><span class="material-symbols-outlined delete">delete</span></button>
                                        </form>
                                    <?php } ?>
                                </h3>
                                <?php if ($raza["raza"] == "Mos") { ?>
                                    <img src="./img/Mos.PNG" alt="Imagen de la raza <?= htmlspecialchars($raza["raza"]) ?>">
                                <?php } elseif ($raza["raza"] == "Villalba") { ?>
                                    <img src="./img/Villalba.PNG" alt="Imagen de la raza <?= htmlspecialchars($raza["raza"]) ?>">
                                <?php } elseif ($raza["raza"] == "Piñeira") { ?>
                                    <img src="./img/Piñeira.PNG" alt="Imagen de la raza <?= htmlspecialchars($raza["raza"]) ?>">
                                <?php } else { ?>
                                    <img src="./img/default-img.jpg" alt="Imagen de la raza <?= htmlspecialchars($raza["raza"]) ?>">
                                <?php } ?>
                            </div>
                            <details>
                                <summary><span class="material-symbols-outlined">read_more</span> Descripcion</summary>

                                <p><?= htmlspecialchars($raza["descripcion"]) ?></p>
                            </details>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </section>

        <?php
        if (isset($_GET["id"])) {
            $id = (int)$_GET["id"];

            $raza = mostrarRazaPorId($id);

        ?>
            <section>
                <div id="modal">
                    <div class="card editarRaza">
                        <h2>Editar Raza</h2>
                        <form action="controller/raza_modificar.php" method="post">
                            <div class="editar">
                                <input type="hidden" name="id" value="<?= (int)$raza["id"] ?>">
                                <div>
                                    <label for="nombreRaza">Nombre: </label>
                                    <input type="text" name="nombre" id="nombreRaza" value="<?= $raza["nombre"] ?>">
                                </div>
                                <div>
                                    <label for="descripcionRaza">Descripcion: </label>
                                    <textarea name="descripcion" id="descripcionRaza"><?= $raza["descripcion"] ?></textarea>
                                </div>

                                <input id="boton_guardar" class="boton" type="submit" value="Guardar cambios">
                                <div>
                                    <a class="boton" href="razas.php">Cancelar</a>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </section>

        <?php
        }
        ?>
    </main>
    <?php include("include/pie.php"); ?>
    <script src="./js/index.js"></script>
</body>

</html>