
<?php
session_start();
require_once "conexion.php";

if (isset($_SESSION["usuario_id"])) {
    header("Location: dashboard.php");
    exit;
}

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $correo = trim($_POST["correo"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($correo === "" || $password === "") {
        $mensaje = "Completa todos los campos.";
    } else {
        $consulta = $conexion->prepare(
            "SELECT id, nombre, correo, password, rol
             FROM usuarios
             WHERE correo = :correo
             LIMIT 1"
        );

        $consulta->execute([":correo" => $correo]);
        $usuario = $consulta->fetch();

        if ($usuario && password_verify($password, $usuario["password"])) {

            session_regenerate_id(true);

            $_SESSION["usuario_id"] = $usuario["id"];
            $_SESSION["nombre"] = $usuario["nombre"];
            $_SESSION["correo"] = $usuario["correo"];
            $_SESSION["rol"] = $usuario["rol"];

            header("Location: dashboard.php");
            exit;

        } else {
            $mensaje = "Correo o contraseña incorrectos.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Iniciar sesión | TaskFlow</title>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    min-height: 100vh;
    font-family: 'Inter', sans-serif;
    background:
        radial-gradient(circle at 15% 20%, rgba(37,99,235,.20), transparent 30%),
        radial-gradient(circle at 85% 80%, rgba(124,58,237,.18), transparent 30%),
        #080d19;
    color: white;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 25px;
}

.contenedor {
    width: 100%;
    max-width: 1050px;
    min-height: 620px;
    display: grid;
    grid-template-columns: 1fr 1fr;
    background: rgba(17,27,48,.88);
    border: 1px solid rgba(148,163,184,.15);
    border-radius: 25px;
    overflow: hidden;
    box-shadow: 0 30px 100px rgba(0,0,0,.45);
}

.panel-izquierdo {
    padding: 55px 45px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    background:
        linear-gradient(145deg, rgba(37,99,235,.25), rgba(124,58,237,.12)),
        #111c34;
}

.logo {
    font-size: 21px;
    font-weight: 800;
    letter-spacing: 1px;
}

.logo span {
    color: #60a5fa;
}

.etiqueta {
    display: inline-block;
    color: #93c5fd;
    background: rgba(59,130,246,.13);
    border: 1px solid rgba(96,165,250,.25);
    padding: 9px 14px;
    border-radius: 30px;
    font-size: 12px;
    margin-bottom: 25px;
}

.panel-izquierdo h1 {
    font-size: 39px;
    line-height: 1.2;
    margin-bottom: 20px;
}

.panel-izquierdo h1 span {
    color: #60a5fa;
}

.descripcion {
    color: #a9b8d0;
    font-size: 14px;
    line-height: 1.8;
    max-width: 380px;
}

.beneficios {
    display: grid;
    gap: 18px;
    margin-top: 40px;
}

.beneficio {
    display: flex;
    align-items: center;
    gap: 13px;
    color: #dce8f8;
    font-size: 13px;
}

.icono {
    width: 38px;
    height: 38px;
    border-radius: 11px;
    display: grid;
    place-items: center;
    background: rgba(59,130,246,.18);
    color: #60a5fa;
}

.pie {
    color: #71829e;
    font-size: 11px;
}

.panel-derecho {
    padding: 55px 50px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.formulario-superior {
    margin-bottom: 32px;
}

.formulario-superior h2 {
    font-size: 29px;
    margin-bottom: 10px;
}

.formulario-superior p {
    color: #94a3b8;
    font-size: 13px;
    line-height: 1.6;
}

.grupo {
    margin-bottom: 22px;
}

label {
    display: block;
    font-size: 12px;
    font-weight: 600;
    color: #cbd5e1;
    margin-bottom: 9px;
}

input {
    width: 100%;
    height: 51px;
    background: #0c1528;
    border: 1px solid #263650;
    border-radius: 10px;
    color: white;
    padding: 0 15px;
    font-size: 13px;
    outline: none;
    transition: .25s;
}

input:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59,130,246,.13);
}

input::placeholder {
    color: #586982;
}

button {
    width: 100%;
    height: 52px;
    border: none;
    border-radius: 10px;
    background: linear-gradient(100deg, #2563eb, #6366f1);
    color: white;
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
    transition: .25s;
    box-shadow: 0 8px 25px rgba(37,99,235,.25);
}

button:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 30px rgba(37,99,235,.4);
}

.mensaje {
    padding: 13px;
    margin-bottom: 20px;
    border-radius: 9px;
    font-size: 12px;
    background: rgba(239,68,68,.12);
    border: 1px solid rgba(239,68,68,.3);
    color: #fca5a5;
}

.enlace {
    text-align: center;
    color: #94a3b8;
    font-size: 12px;
    margin-top: 25px;
}

.enlace a {
    color: #60a5fa;
    font-weight: 700;
    text-decoration: none;
}

.enlace a:hover {
    text-decoration: underline;
}

@media(max-width: 750px) {
    .contenedor {
        grid-template-columns: 1fr;
        max-width: 470px;
    }

    .panel-izquierdo {
        padding: 35px 30px;
    }

    .panel-izquierdo h1 {
        font-size: 30px;
    }

    .beneficios, .pie {
        display: none;
    }

    .panel-derecho {
        padding: 40px 30px;
    }
}
</style>
</head>

<body>

<div class="contenedor">

    <section class="panel-izquierdo">

        <div class="logo">TASK<span>FLOW.</span></div>

        <div>
            <div class="etiqueta">✦ BIENVENIDO DE NUEVO</div>

            <h1>Tu productividad<br>
            <span>comienza aquí.</span></h1>

            <p class="descripcion">
                Accede a tu espacio de trabajo y continúa organizando
                tus actividades de manera sencilla e inteligente.
            </p>

            <div class="beneficios">
                <div class="beneficio">
                    <div class="icono">✓</div>
                    Control de tus actividades
                </div>

                <div class="beneficio">
                    <div class="icono">⌘</div>
                    Acceso personalizado por roles
                </div>

                <div class="beneficio">
                    <div class="icono">◈</div>
                    Gestión centralizada de tareas
                </div>
            </div>
        </div>

        <div class="pie">TASKFLOW © 2026 · SISTEMA DE GESTIÓN</div>

    </section>

    <section class="panel-derecho">

        <div class="formulario-superior">
            <h2>Iniciar sesión</h2>
            <p>Ingresa tus credenciales para acceder a tu cuenta.</p>
        </div>

        <?php if ($mensaje !== ""): ?>
            <div class="mensaje">
                <?= htmlspecialchars($mensaje, ENT_QUOTES, "UTF-8") ?>
            </div>
        <?php endif; ?>

        <form method="POST">

            <div class="grupo">
                <label>Correo electrónico</label>
                <input type="email" name="correo"
                       placeholder="correo@ejemplo.com" required>
            </div>

            <div class="grupo">
                <label>Contraseña</label>
                <input type="password" name="password"
                       placeholder="Ingresa tu contraseña" required>
            </div>

            <button type="submit">Ingresar al sistema →</button>

        </form>

        <div class="enlace">
            ¿Todavía no tienes cuenta?
            <a href="registro.php">Crear una cuenta</a>
        </div>

    </section>

</div>

</body>
</html>
