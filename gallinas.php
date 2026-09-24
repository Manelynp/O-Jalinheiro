<?php
require_once __DIR__ . "/model/gallina_model.php";
require_once __DIR__ . "/model/raza_model.php";

$razas = mostrarRazas();

$gallinas = mostrarGallinas();



?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>O Jalinheiro | Gallinas</title>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="shortcut icon" href="./img/hen_icon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
</head>

<body>
    <?php include("include/cabecera.php"); ?>
    <main>
        <section>
            <h1>Gestión de gallinas</h1>
            <div class="contenedor">
                <div class="card">
                    <h2>Registrar nueva gallina</h2>
                    <form action="controller/gallina_insertar.php" method="post">
                        <div class="registrar">
                            <div>
                                <label for="nombre">Nombre:</label>
                                <input type="text" name="nombre" id="nombre" required>
                            </div>
                            <div>
                                <label for="fecha_nacimiento">Fecha de nacimiento:</label>
                                <input type="date" name="fecha_nacimiento" id="fecha_nacimiento">
                            </div>
                            <div>
                                <label for="fecha_alta">Fecha de alta:</label>
                                <input type="date" name="fecha_alta" id="fecha_alta" required value="<?= date('Y-m-d') ?>">
                            </div>
                            <div>
                                <label for="raza">Raza:</label>
                                <select name="raza" id="raza" required>
                                    <option value="">--Seleccione raza--</option>
                                    <?php foreach ($razas as $raza) { ?>
                                        <option value="<?= (int)$raza["id"] ?>"><?= htmlspecialchars($raza["raza"]) ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <input class="boton" type="submit" value="Guardar gallina">
                        </div>
                    </form>
                </div>

                <div class="tablaGallinas">
                    <div class="tabla-titulo">
                        <h2>Registro de gallinas</h2>
                        <p class="leyenda-bajas">
                            <span aria-hidden="true"></span>
                            Los nombres en rojo corresponden a gallinas fallecidas.
                        </p>
                    </div>
                    <table>
                        <tr>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Fecha nacimiento</th>
                            <th>Fecha alta</th>
                            <th>Raza</th>
                            <th colspan="2">Acciones</th>
                        </tr>
                        <?php foreach ($gallinas as $gallina) { ?>

                            <tr <?php if ($gallina["id_gallina"] !== null) {
                                    echo 'class="filaRoja"';
                                } ?>>
                                <td><?= htmlspecialchars($gallina["id"]) ?></td>
                                <td><?= htmlspecialchars($gallina["nombre"]) ?></td>
                                <td><?= htmlspecialchars($gallina["fecha_nacimiento"]) ?></td>
                                <td><?= htmlspecialchars($gallina["fecha_alta"]) ?></td>
                                <td><?= htmlspecialchars($gallina["raza"]) ?></td>
                                <td>
                                    <a id="boton_insert" href="gallinas.php?id=<?= (int)$gallina["id"] ?>">
                                        <span class="material-symbols-outlined edit">table_edit</span></a>
                                </td>
                                <?php if ($gallina["cantidad"] === null && $gallina["id_gallina"] === null) { ?>
                                    <td>
                                        <form action="controller/gallina_eliminar.php" method="post"
                                            onsubmit="return confirm('¿Seguro que quieres eliminar esta gallina?');">
                                            <input type="hidden" name="id" value="<?= (int)$gallina["id"] ?>">
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

            $gallina = mostrarGallinaPorId($id);

        ?>
            <section>
                <div id="modal">
                    <div class="card editarGallina">
                        <h2>Editar Gallina</h2>
                        <form action="controller/gallina_modificar.php" method="post">
                            <div class="editar">
                                <input type="hidden" name="id" value="<?= (int)$gallina["id"] ?>">
                                <div>
                                    <label for="nombreGallina">Nombre: </label>
                                    <input type="text" name="nombreGallina" id="nombreGallina" value="<?= $gallina["nombre"] ?>">
                                </div>
                                <div>
                                    <label for="fechaNac_gallina">Fecha nacimiento: </label>
                                    <input type="date" name="fechaNac_gallina" id="fechaNac_gallina" value="<?= $gallina["fecha_nacimiento"] ?>">
                                </div>
                                <div>
                                    <label for="fechaAlta_gallina">Fecha alta: </label>
                                    <input type="date" name="fechaAlta_gallina" id="fechaAlta_gallina" value="<?= $gallina["fecha_alta"] ?>">
                                </div>
                                <div>
                                    <label for="nombreRaza">Raza: </label>
                                    <select name="nombreRaza" id="nombreRaza">
                                        <option value="">--Seleccione raza--</option>
                                        <?php foreach ($razas as $raza) { ?>
                                            <option value="<?= (int)$raza["id"] ?>"
                                                <?= (int)$raza["id"] === (int)$gallina["id_raza"] ? "selected" : "" ?>><?= htmlspecialchars($raza["raza"]) ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <input id="boton_guardar" class="boton" type="submit" value="Guardar cambios">
                                <div>
                                    <a class="boton" href="gallinas.php">Cancelar</a>
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