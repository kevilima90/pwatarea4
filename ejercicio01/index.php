
<?php
session_start();

if (isset($_SESSION["usuario_id"])) {
    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>TaskFlow | Gestión de tareas</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
*{box-sizing:border-box;margin:0;padding:0}
body{
    min-height:100vh;
    font-family:Inter,sans-serif;
    color:#f8fafc;
    background:
    radial-gradient(circle at 15% 20%,#172d58 0,transparent 35%),
    radial-gradient(circle at 85% 80%,#252052 0,transparent 35%),
    #080d18;
}
nav{
    height:85px;
    max-width:1150px;
    margin:auto;
    padding:0 25px;
    display:flex;
    align-items:center;
    justify-content:space-between;
}
.logo{font-size:21px;font-weight:800;letter-spacing:-1px}
.logo span{color:#60a5fa}
.nav-links{display:flex;gap:12px}
a{text-decoration:none}
.boton{
    padding:12px 20px;
    border-radius:9px;
    font-size:12px;
    font-weight:700;
    transition:.2s;
}
.login{color:#dbeafe;border:1px solid #344563}
.registro{color:white;background:linear-gradient(100deg,#2563eb,#6366f1)}
.boton:hover{transform:translateY(-2px)}
main{
    max-width:1150px;
    min-height:calc(100vh - 85px);
    margin:auto;
    padding:60px 25px;
    display:grid;
    grid-template-columns:1.1fr .9fr;
    align-items:center;
    gap:55px;
}
.etiqueta{
    display:inline-block;
    padding:9px 14px;
    border:1px solid #29436b;
    background:#142542;
    border-radius:30px;
    color:#93c5fd;
    font-size:11px;
    font-weight:700;
    letter-spacing:1px;
    margin-bottom:25px;
}
h1{
    font-size:clamp(42px,6vw,68px);
    line-height:1.08;
    letter-spacing:-3px;
    margin-bottom:24px;
}
h1 span{
    background:linear-gradient(90deg,#60a5fa,#a78bfa);
    -webkit-background-clip:text;
    color:transparent;
}
.descripcion{
    max-width:520px;
    color:#94a3b8;
    line-height:1.9;
    font-size:15px;
}
.botones{
    display:flex;
    gap:13px;
    margin-top:35px;
    flex-wrap:wrap;
}
.botones a{padding:16px 23px}
.informacion{
    margin-top:35px;
    display:flex;
    gap:25px;
    flex-wrap:wrap;
    color:#94a3b8;
    font-size:12px;
}
.informacion span::before{content:"✓";color:#60a5fa;margin-right:8px}
.visual{
    padding:25px;
    border:1px solid #293b58;
    border-radius:22px;
    background:linear-gradient(145deg,#14223a,#0d1729);
    box-shadow:0 30px 90px #0008;
}
.visual-top{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;
}
.visual-top h2{font-size:16px}
.estado{font-size:10px;color:#86efac;background:#12372d;padding:7px 10px;border-radius:20px}
.estadisticas{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:13px;
}
.tarjeta{
    padding:20px;
    background:#1a2a43;
    border:1px solid #2b405f;
    border-radius:14px;
}
.tarjeta small{color:#94a3b8;font-size:11px}
.tarjeta strong{display:block;font-size:28px;margin-top:10px}
.lista{margin-top:20px}
.lista h3{font-size:13px;margin-bottom:14px}
.tarea{
    display:flex;
    align-items:center;
    gap:12px;
    padding:15px 0;
    border-top:1px solid #293a54;
    font-size:12px;
    color:#dbeafe;
}
.circulo{
    width:20px;height:20px;border-radius:7px;
    border:1px solid #4b80d7;
    display:grid;place-items:center;color:#60a5fa;
}
.completada{color:#86efac}
footer{text-align:center;color:#64748b;font-size:11px;padding:20px}
@media(max-width:800px){
    main{grid-template-columns:1fr;padding-top:45px}
    .visual{max-width:520px;width:100%}
    h1{letter-spacing:-2px}
}
@media(max-width:480px){
    nav{padding:0 15px}
    .logo{font-size:17px}
    .boton{padding:10px 12px}
    main{padding:35px 18px}
}
</style>
</head>

<body>
<nav>
    <div class="logo">TASK<span>FLOW.</span></div>
    <div class="nav-links">
        <a class="boton login" href="login.php">Iniciar sesión</a>
        <a class="boton registro" href="registro.php">Registrarse</a>
    </div>
</nav>

<main>
    <section>
        <div class="etiqueta">GESTIÓN INTELIGENTE DE ACTIVIDADES</div>
        <h1>Organiza tus tareas.<br><span>Logra tus metas.</span></h1>
        <p class="descripcion">
            Una plataforma para crear, organizar y supervisar tareas.
            Trabaja en equipo, controla tus actividades y consulta
            tu progreso desde un solo lugar.
        </p>

        <div class="botones">
            <a class="boton registro" href="registro.php">Comenzar ahora →</a>
            <a class="boton login" href="login.php">Ya tengo una cuenta</a>
        </div>

        <div class="informacion">
            <span>Fácil de utilizar</span>
            <span>Control de usuarios</span>
            <span>Seguimiento de tareas</span>
        </div>
    </section>

    <section class="visual">
        <div class="visual-top">
            <h2>Resumen de actividades</h2>
            <span class="estado">● Sistema activo</span>
        </div>

        <div class="estadisticas">
            <div class="tarjeta">
                <small>Tareas registradas</small>
                <strong>12</strong>
            </div>
            <div class="tarjeta">
                <small>Completadas</small>
                <strong>08</strong>
            </div>
        </div>

        <div class="lista">
            <h3>Ejemplo de actividades</h3>
            <div class="tarea">
                <span class="circulo completada">✓</span>
                Organizar actividades pendientes
                <span class="completada">Listo</span>
            </div>
            <div class="tarea">
                <span class="circulo"></span>
                Revisar tareas del equipo
            </div>
            <div class="tarea">
                <span class="circulo"></span>
                Planificar nuevas actividades
            </div>
        </div>
    </section>
</main>

<footer>TaskFlow · Sistema de gestión de tareas · Ejercicio 01</footer>
</body>
</html>
