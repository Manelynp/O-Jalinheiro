<?php
require_once __DIR__ . "/model/gallina_model.php";
require_once __DIR__ . "/model/baja_model.php";
require_once __DIR__ . "/model/produccion_model.php";

$bajas = mostrarBajas();

$gallinas = mostrarGallinasVivas();


?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>O Jalinheiro | Bajas</title>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="shortcut icon" href="./img/hen_icon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
</head>

<body>
    <?php include("include/cabecera.php"); ?>
    <main>
        <section>
            <h1>Registro de bajas</h1>
            <div class="contenedor">
                <div class="card">
                    <h2>Registrar de Bajas</h2>
                    <form action="controller/baja_insertar.php" method="post">
                        <div class="registrar">
                            <div>
                                <label for="nombre">Nombre:</label>
                                <select name="nombre" id="nombre">
                                    <?php foreach ($gallinas as $gallina) { ?>
                                        <option value="<?= (int)$gallina["id"] ?>"><?= htmlspecialchars($gallina["nombre"]) ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div>
                                <label for="fecha">Fecha:</label>
                                <input type="date" name="fecha" id="fecha" required>
                            </div>
                            <div>
                                <label for="causa">Causa:</label>
                                <input type="text" name="causa" id="causa" required>
                            </div>
                            <input class="boton" type="submit" value="Guardar gallina baja">
                        </div>
                    </form>
                </div>

                <div class="tablaGallinasBajas">
                    <table>
                        <tr>
                            <th>Nombre</th>
                            <th>Fecha</th>
                            <th>Causa</th>
                            <th colspan="2">Acciones</th>
                        </tr>
                        <?php foreach ($bajas as $baja) { ?>
                            <tr>
                                <td><?= htmlspecialchars($baja["nombre"]) ?></td>
                                <td><?= htmlspecialchars($baja["fecha"]) ?></td>
                                <td><?= htmlspecialchars($baja["causa"]) ?></td>
                                <td>
                                    <a id="boton_insert" href="bajas.php?id=<?= (int)$baja["id_gallina"] ?>">
                                        <span class="material-symbols-outlined edit">table_edit</span></a>
                                </td>
                                <?php if ($baja["id_gallina"] !== null) { ?>
                                    <td>
                                        <form action="controller/baja_eliminar.php" method="post"
                                            onsubmit="return confirm('¿Seguro que quieres eliminar esta gallina?');">
                                            <input type="hidden" name="id" value="<?= (int)$baja["id_gallina"] ?>">
                                            <button type="submit"><span class="material-symbols-outlined delete">delete</span></button>
                                        </form>
                                    </td>
                                <?php } ?>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </section>

        <?php
        if (isset($_GET["id"])) {
            $id = (int)$_GET["id"];

            $baja = mostrarBajaPorId($id);

        ?>
            <section>
                <div id="modal">
                    <div class="card editarBaja">
                        <h2>Editar la baja de <span class="nombre-seleccionado"><?= htmlspecialchars($baja["nombre"]) ?></span></h2>
                        <form action="controller/baja_modificar.php" method="post">
                            <div class="editar">
                                <input type="hidden" name="id" value="<?= (int)$baja["id_gallina"] ?>">
                                <div>
                                    <label for="fecha_baja">Fecha baja: </label>
                                    <input type="date" name="fecha" id="fecha_baja" value="<?= htmlspecialchars($baja["fecha"]) ?>">
                                </div>
                                <div>
                                    <label for="causa">Causa:</label>
                                    <input type="text" name="causa" id="causa" value="<?= htmlspecialchars($baja["causa"]) ?>">
                                </div>
                                <input id="boton_guardar" class="boton" type="submit" value="Guardar cambios">
                                <div>
                                    <a class="boton" href="bajas.php">Cancelar</a>
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