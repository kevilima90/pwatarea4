
<?php
session_start();
require_once "conexion.php";

if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}

if ($_SESSION["rol"] !== "administrador") {
    http_response_code(403);
    exit("No tienes permiso para eliminar tareas.");
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: dashboard.php");
    exit;
}

if (!hash_equals($_SESSION["token"] ?? "", $_POST["token"] ?? "")) {
    die("Solicitud no válida.");
}

$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

if ($id) {
    $consulta = $conexion->prepare(
        "DELETE FROM tareas WHERE id = :id"
    );
    $consulta->execute([":id" => $id]);
}

header("Location: dashboard.php");
exit;
?>
