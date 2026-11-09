
<?php
session_start();
require_once "conexion.php";

if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: dashboard.php");
    exit;
}

if (!hash_equals($_SESSION["token"] ?? "", $_POST["token"] ?? "")) {
    die("Solicitud no válida.");
}

$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

if (!$id) {
    header("Location: dashboard.php");
    exit;
}

if ($_SESSION["rol"] === "administrador") {
    $consulta = $conexion->prepare(
        "UPDATE tareas SET estado = 'completada' WHERE id = :id"
    );
    $consulta->execute([":id" => $id]);
} else {
    $consulta = $conexion->prepare(
        "UPDATE tareas
         SET estado = 'completada'
         WHERE id = :id AND usuario_id = :usuario_id"
    );
    $consulta->execute([
        ":id" => $id,
        ":usuario_id" => $_SESSION["usuario_id"]
    ]);
}

header("Location: dashboard.php");
exit;
?>
