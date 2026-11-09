
<?php
$ejercicios = [
    [
        "numero" => "01",
        "titulo" => "Lista de Tareas Interactiva",
        "descripcion" => "Sistema de gestión de tareas con usuarios, roles y permisos.",
        "estado" => "En desarrollo",
        "enlace" => "ejercicio01/index.php"
    ],
    [
        "numero" => "02",
        "titulo" => "Ejercicio 02",
        "descripcion" => "Espacio reservado para una futura actividad.",
        "estado" => "Pendiente",
        "enlace" => "ejercicio02/index.php"
    ],
    [
        "numero" => "03",
        "titulo" => "Ejercicio 03",
        "descripcion" => "Espacio reservado para una futura actividad.",
        "estado" => "Pendiente",
        "enlace" => "ejercicio03/index.php"
    ],
    [
        "numero" => "04",
        "titulo" => "Ejercicio 04",
        "descripcion" => "Espacio reservado para una futura actividad.",
        "estado" => "Pendiente",
        "enlace" => "ejercicio04/index.php"
    ],
    [
        "numero" => "05",
        "titulo" => "Ejercicio 05",
        "descripcion" => "Espacio reservado para una futura actividad.",
        "estado" => "Pendiente",
        "enlace" => "ejercicio05/index.php"
    ]
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PWATAREA4 | Desarrollo Web</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #0b1120;
            color: #ffffff;
            min-height: 100vh;
        }

        header {
            padding: 25px 8%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #26334a;
        }

        .logo {
            font-size: 25px;
            font-weight: bold;
            color: #60a5fa;
        }

        .badge {
            color: #93c5fd;
            background: #172b48;
            padding: 9px 15px;
            border-radius: 20px;
            font-size: 13px;
        }

        .principal {
            padding: 65px 8% 35px;
        }

        .principal h1 {
            font-size: clamp(30px, 5vw, 48px);
            margin-bottom: 15px;
        }

        .principal h1 span {
            color: #60a5fa;
        }

        .principal p {
            color: #aab7ca;
            line-height: 1.7;
            max-width: 650px;
        }

        .tecnologias {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 25px;
        }

        .tecnologias span {
            background: #17243a;
            border: 1px solid #33445f;
            padding: 9px 15px;
            border-radius: 8px;
            color: #bfdbfe;
            font-size: 13px;
        }

        .contenido {
            padding: 20px 8% 70px;
        }

        .contenido h2 {
            margin-bottom: 25px;
            font-size: 24px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
            gap: 20px;
        }

        .card {
            background: #151f32;
            border: 1px solid #2c3b54;
            border-radius: 15px;
            padding: 25px;
            transition: 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
            border-color: #60a5fa;
        }

        .numero {
            color: #60a5fa;
            font-size: 30px;
            font-weight: bold;
            margin-bottom: 18px;
        }

        .card h3 {
            font-size: 19px;
            margin-bottom: 12px;
        }

        .card p {
            color: #aab7ca;
            font-size: 14px;
            line-height: 1.6;
            min-height: 65px;
        }

        .estado {
            display: inline-block;
            font-size: 12px;
            color: #93c5fd;
            background: #203653;
            padding: 7px 11px;
            border-radius: 20px;
            margin: 15px 0;
        }

        .enlace {
            display: block;
            text-decoration: none;
            color: white;
            background: #2563eb;
            text-align: center;
            padding: 12px;
            border-radius: 8px;
            margin-top: 8px;
            transition: 0.3s;
        }

        .enlace:hover {
            background: #1d4ed8;
        }

        footer {
            text-align: center;
            padding: 25px;
            color: #8190a7;
            border-top: 1px solid #26334a;
            font-size: 13px;
        }

        @media (max-width: 600px) {
            header {
                padding: 20px;
            }

            .principal {
                padding: 45px 20px 25px;
            }

            .contenido {
                padding: 20px;
            }
        }
    </style>
</head>

<body>

<header>
    <div class="logo">PWATAREA4</div>
    <div class="badge">Programación Avanzada</div>
</header>

<section class="principal">

    <h1>Desarrollo de <span>Sistemas Web</span></h1>

    <p>
        Plataforma académica de ejercicios prácticos de programación
        utilizando HTML5, CSS, JavaScript, PHP y MySQL.
        Cada ejercicio demuestra la aplicación de conocimientos
        en el desarrollo de sistemas web interactivos.
    </p>

    <div class="tecnologias">
        <span>HTML5</span>
        <span>CSS3</span>
        <span>JavaScript</span>
        <span>PHP</span>
        <span>MySQL</span>
    </div>

</section>

<section class="contenido">

    <h2>Mis ejercicios prácticos</h2>

    <div class="grid">

        <?php foreach ($ejercicios as $ejercicio): ?>

            <article class="card">

                <div class="numero">
                    <?php echo htmlspecialchars($ejercicio["numero"]); ?>
                </div>

                <h3>
                    <?php echo htmlspecialchars($ejercicio["titulo"]); ?>
                </h3>

                <p>
                    <?php echo htmlspecialchars($ejercicio["descripcion"]); ?>
                </p>

                <div class="estado">
                    <?php echo htmlspecialchars($ejercicio["estado"]); ?>
                </div>

                <a class="enlace"
                   href="<?php echo htmlspecialchars($ejercicio["enlace"]); ?>">
                    Abrir ejercicio →
                </a>

            </article>

        <?php endforeach; ?>

    </div>

</section>

<footer>
    Proyecto académico PWATAREA4 | Programación Avanzada
</footer>

</body>
</html>
