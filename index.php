<?php
session_start();
require_once 'php/conexion.php';

$error_mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $dni = trim($_POST['dni'] ?? '');
    $pass = trim($_POST['pass'] ?? '');

    if (!empty($dni) && !empty($pass)) {
        try {
            $stmt = $conexion->prepare("SELECT dni, pass, nombre FROM profesores WHERE dni = :dni");
            $stmt->execute(['dni' => $dni]);
            $profesor = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($profesor && password_verify($pass, $profesor['pass'])) {
                $_SESSION['dni'] = $profesor['dni'];
                $_SESSION['nombre'] = $profesor['nombre'];

                header("Location: php/menu.php");
                exit();
            } else {
                $error_mensaje = "Contraseña o DNI incorrectos";
            }

        } catch (PDOException $e) {
            $error_mensaje = "Error en la base de datos";
        }
    } else {
        $error_mensaje = "Por favor, complete todos los campos";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - EEST N°1</title>
    <link rel="stylesheet" href="css/index.css">
    <script src="https://kit.fontawesome.com/40202e00e6.js" crossorigin="anonymous"></script>
</head>
<body>
    <main class="auth-card">
        <!-- Panel de marca -->
        <section class="auth-brand">
            <div class="brand-logo">
                <img src="img/logo_escuela.png" alt="Logo EEST N°1">
            </div>
            <h1>Valoraciones EEST N°1</h1>
        </section>

        <!-- Panel del formulario -->
        <section class="auth-form">
            <h2>Iniciar Sesión</h2>
            <p class="auth-subtitle">Ingresá con tu DNI y contraseña</p>

            <?php if (!empty($error_mensaje)): ?>
                <div class="alert alert-error" role="alert">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span><?php echo htmlspecialchars($error_mensaje, ENT_QUOTES); ?></span>
                </div>
            <?php endif; ?>

            <form action="" method="POST">
                <div class="form-field">
                    <label for="dni">DNI</label>
                    <div class="input-group">
                        <i class="fa-solid fa-id-card input-icon"></i>
                        <input type="text" id="dni" name="dni" placeholder="Ej: 30123456" inputmode="numeric" required>
                    </div>
                </div>

                <div class="form-field">
                    <label for="pass">Contraseña</label>
                    <div class="input-group">
                        <i class="fa-solid fa-lock input-icon"></i>
                        <input type="password" id="pass" name="pass" placeholder="Tu contraseña" required>
                        <button type="button" class="input-toggle" aria-label="Mostrar u ocultar contraseña">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    <span>Iniciar Sesión</span>
                    <i class="fa-solid fa-right-to-bracket"></i>
                </button>

                <p class="auth-links">
                    <a href="php/registro_profesor.php">¿No tenés cuenta? Registrarme</a>
                </p>
            </form>
        </section>
    </main>

    <script>
        document.querySelectorAll('.input-toggle').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var input = btn.parentElement.querySelector('input');
                var icon = btn.querySelector('i');
                var mostrar = input.type === 'password';
                input.type = mostrar ? 'text' : 'password';
                icon.className = mostrar ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye';
            });
        });
    </script>
</body>
</html>