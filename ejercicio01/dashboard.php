
<?php
session_start();
require_once "conexion.php";

if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}

if (empty($_SESSION["token"])) {
    $_SESSION["token"] = bin2hex(random_bytes(32));
}

function limpiar($valor) {
    return htmlspecialchars($valor ?? "", ENT_QUOTES, "UTF-8");
}

$mensaje = "";
$error = "";

// Registrar una nueva tarea
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["crear_tarea"])) {

    if (!hash_equals($_SESSION["token"], $_POST["token"] ?? "")) {
        $error = "Solicitud no válida.";
    } else {
        $titulo = trim($_POST["titulo"] ?? "");
        $descripcion = trim($_POST["descripcion"] ?? "");

        if ($titulo === "") {
            $error = "Debes escribir el título de la tarea.";
        } elseif (strlen($titulo) > 150) {
            $error = "El título no puede superar los 150 caracteres.";
        } else {
            $consulta = $conexion->prepare("
                INSERT INTO tareas (usuario_id, titulo, descripcion)
                VALUES (:usuario_id, :titulo, :descripcion)
            ");

            $consulta->execute([
                ":usuario_id" => $_SESSION["usuario_id"],
                ":titulo" => $titulo,
                ":descripcion" => $descripcion
            ]);

            header("Location: dashboard.php");
            exit;
        }
    }
}

// Consultar tareas según el rol
if ($_SESSION["rol"] === "administrador") {
    $consulta = $conexion->query("
        SELECT tareas.*, usuarios.nombre AS nombre_usuario
        FROM tareas
        INNER JOIN usuarios ON tareas.usuario_id = usuarios.id
        ORDER BY tareas.fecha DESC
    ");
} else {
    $consulta = $conexion->prepare("
        SELECT tareas.*, usuarios.nombre AS nombre_usuario
        FROM tareas
        INNER JOIN usuarios ON tareas.usuario_id = usuarios.id
        WHERE tareas.usuario_id = :usuario_id
        ORDER BY tareas.fecha DESC
    ");

    $consulta->execute([
        ":usuario_id" => $_SESSION["usuario_id"]
    ]);
}

$tareas = $consulta->fetchAll();

// Estadísticas
$total = count($tareas);
$completadas = 0;

foreach ($tareas as $tarea) {
    if ($tarea["estado"] === "completada") {
        $completadas++;
    }
}

$pendientes = $total - $completadas;
$progreso = $total > 0 ? round(($completadas / $total) * 100) : 0;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de tareas | TaskFlow</title>
    <link rel="stylesheet" href="css/estilos.css">
    <script src="js/funciones.js" defer></script>
</head>

<body>

<div class="fondo-luz"></div>

<header class="encabezado">
    <a href="index.php" class="marca">
        <div class="marca-icono">T</div>
        <span>Task<span>Flow</span></span>
    </a>

    <div class="usuario-menu">
        <div class="usuario-info">
            <div class="avatar">
                <?= strtoupper(substr($_SESSION["nombre"], 0, 1)) ?>
            </div>

            <div>
                <strong><?= limpiar($_SESSION["nombre"]) ?></strong>
                <small>
                    <?= $_SESSION["rol"] === "administrador" ? "Administrador" : "Usuario" ?>
                </small>
            </div>
        </div>

        <a href="cerrar_sesion.php" class="btn-salir">
            <span>↪</span> Cerrar sesión
        </a>
    </div>
</header>

<main class="contenedor">

    <section class="bienvenida">
        <div>
            <span class="etiqueta">PANEL DE CONTROL</span>
            <h1>Mis tareas, <span><?= limpiar($_SESSION["nombre"]) ?></span></h1>
            <p>Organiza tus actividades y lleva un control de tu progreso.</p>
        </div>

        <div class="fecha-actual">
            <span>HOY</span>
            <strong><?= date("d/m/Y") ?></strong>
        </div>
    </section>

    <?php if ($error !== ""): ?>
        <div class="alerta error"><?= limpiar($error) ?></div>
    <?php endif; ?>

    <section class="estadisticas">

        <article class="tarjeta-estadistica">
            <div class="estadistica-icono azul">▤</div>
            <div>
                <span>Total de tareas</span>
                <strong><?= $total ?></strong>
            </div>
        </article>

        <article class="tarjeta-estadistica">
            <div class="estadistica-icono naranja">◷</div>
            <div>
                <span>Pendientes</span>
                <strong><?= $pendientes ?></strong>
            </div>
        </article>

        <article class="tarjeta-estadistica">
            <div class="estadistica-icono verde">✓</div>
            <div>
                <span>Completadas</span>
                <strong><?= $completadas ?></strong>
            </div>
        </article>

    </section>

    <section class="progreso-panel">
        <div class="progreso-cabecera">
            <div>
                <h2>Progreso general</h2>
                <p>Tu avance en las tareas registradas</p>
            </div>
            <strong><?= $progreso ?>%</strong>
        </div>

        <div class="progreso-fondo">
            <div class="barra-progreso" style="width: <?= $progreso ?>%;"></div>
        </div>
    </section>

    <section class="contenido-principal">

        <div class="panel-formulario">
            <div class="titulo-seccion">
                <span class="etiqueta">NUEVA ACTIVIDAD</span>
                <h2>Agregar tarea</h2>
                <p>Registra una actividad para organizar tu tiempo.</p>
            </div>

            <form method="POST" action="dashboard.php">
                <input type="hidden" name="token" value="<?= limpiar($_SESSION["token"]) ?>">

                <label for="titulo">Título de la tarea</label>
                <input
                    type="text"
                    id="titulo"
                    name="titulo"
                    maxlength="150"
                    placeholder="Ej. Estudiar programación"
                    required
                >

                <label for="descripcion">Descripción</label>
                <textarea
                    id="descripcion"
                    name="descripcion"
                    rows="4"
                    placeholder="Describe brevemente la actividad..."
                ></textarea>

                <button type="submit" name="crear_tarea" class="btn-crear">
                    + Crear tarea
                </button>
            </form>
        </div>

        <div class="panel-tareas">

            <div class="titulo-tareas">
                <div>
                    <span class="etiqueta">ORGANIZACIÓN</span>
                    <h2>Lista de tareas</h2>
                    <p>
                        <?= $_SESSION["rol"] === "administrador"
                            ? "Visualizando las tareas de todos los usuarios."
                            : "Visualizando tus actividades personales." ?>
                    </p>
                </div>
            </div>

            <div class="busqueda">
                <span>⌕</span>
                <input
                    type="search"
                    id="buscarTarea"
                    placeholder="Buscar una tarea..."
                >
            </div>

            <div class="filtros">
                <button class="filtro activo" data-filtro="todas" type="button">
                    Todas
                </button>

                <button class="filtro" data-filtro="pendiente" type="button">
                    Pendientes
                </button>

                <button class="filtro" data-filtro="completada" type="button">
                    Completadas
                </button>
            </div>

            <div class="contador-resultados">
                <span id="contadorVisible"><?= $total ?></span> tareas mostradas
            </div>

            <div class="lista-tareas" id="listaTareas">

                <?php if (count($tareas) > 0): ?>

                    <?php foreach ($tareas as $tarea): ?>

                        <article
                            class="tarea <?= $tarea["estado"] ?>"
                            data-estado="<?= limpiar($tarea["estado"]) ?>"
                            data-busqueda="<?= limpiar(strtolower($tarea["titulo"] . " " . $tarea["descripcion"] . " " . $tarea["nombre_usuario"])) ?>"
                        >

                            <div class="tarea-indicador">
                                <?= $tarea["estado"] === "completada" ? "✓" : "○" ?>
                            </div>

                            <div class="tarea-contenido">
                                <h3><?= limpiar($tarea["titulo"]) ?></h3>

                                <p>
                                    <?= limpiar($tarea["descripcion"] ?: "Sin descripción") ?>
                                </p>

                                <div class="datos-tarea">
                                    <span class="estado <?= $tarea["estado"] ?>">
                                        <?= ucfirst($tarea["estado"]) ?>
                                    </span>

                                    <?php if ($_SESSION["rol"] === "administrador"): ?>
                                        <span class="autor">
                                            Por: <?= limpiar($tarea["nombre_usuario"]) ?>
                                        </span>
                                    <?php endif; ?>

                                    <span class="fecha-tarea">
                                        <?= date("d/m/Y", strtotime($tarea["fecha"])) ?>
                                    </span>
                                </div>
                            </div>

                            <div class="acciones-tarea">

                                <?php if ($tarea["estado"] === "pendiente"): ?>
                                    <form method="POST" action="completar.php">
                                        <input type="hidden" name="token" value="<?= limpiar($_SESSION["token"]) ?>">
                                        <input type="hidden" name="id" value="<?= (int)$tarea["id"] ?>">
                                        <button type="submit" class="btn-completar" title="Completar tarea">
                                            ✓
                                        </button>
                                    </form>
                                <?php endif; ?>

                                <?php if ($_SESSION["rol"] === "administrador"): ?>
                                    <form method="POST" action="eliminar.php" onsubmit="return confirm('¿Estás seguro de eliminar esta tarea?');">
                                        <input type="hidden" name="token" value="<?= limpiar($_SESSION["token"]) ?>">
                                        <input type="hidden" name="id" value="<?= (int)$tarea["id"] ?>">
                                        <button type="submit" class="btn-eliminar" title="Eliminar tarea">
                                            ✕
                                        </button>
                                    </form>
                                <?php endif; ?>

                            </div>

                        </article>

                    <?php endforeach; ?>

                <?php else: ?>

                    <div class="sin-tareas" id="sinTareas">
                        <div>▤</div>
                        <h3>Aún no tienes tareas</h3>
                        <p>Agrega tu primera actividad usando el formulario.</p>
                    </div>

                <?php endif; ?>

                <div class="sin-resultados" id="sinResultados" hidden>
                    <h3>No se encontraron tareas</h3>
                    <p>Prueba con otra búsqueda o cambia el filtro.</p>
                </div>

            </div>
        </div>

    </section>

    <footer class="pie">
        <span>TaskFlow © <?= date("Y") ?></span>
        <span>Organiza. Avanza. Cumple.</span>
    </footer>

</main>

</body>
</html>
