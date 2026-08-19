<?php
require_once 'conexion.php';

$error_mensaje = "";
$exito_mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre = trim($_POST['nombre'] ?? '');
    $apellido = trim($_POST['apellido'] ?? '');
    $dni = trim($_POST['dni'] ?? '');
    $pass = trim($_POST['pass'] ?? '');
    $pass2 = trim($_POST['pass2'] ?? '');
    $email = trim($_POST['email'] ?? '');

    if (!empty($nombre) && !empty($apellido) && !empty($dni) && !empty($pass) && !empty($pass2) && !empty($email)) {

        if ($pass !== $pass2) {
            $error_mensaje = "Las contraseñas no coinciden";
        } elseif (!ctype_digit($dni)) {
            $error_mensaje = "El DNI debe contener solo números";
        } else {
            try {
                // Verificar si el DNI ya está registrado
                $stmt = $conexion->prepare("SELECT dni FROM profesores WHERE dni = :dni");
                $stmt->execute(['dni' => $dni]);

                if ($stmt->fetch()) {
                    $error_mensaje = "Ya existe un profesor registrado con ese DNI";
                } else {
                    $pass_hash = password_hash($pass, PASSWORD_DEFAULT);

                    $stmt = $conexion->prepare(
                        "INSERT INTO profesores (nombre, apellido, dni, pass, email) 
                         VALUES (:nombre, :apellido, :dni, :pass, :email)"
                    );
                    $stmt->execute([
                        'nombre'   => $nombre,
                        'apellido' => $apellido,
                        'dni'      => $dni,
                        'pass'     => $pass_hash,
                        'email'     => $email
                    ]);

                    $exito_mensaje = "Registro exitoso. Ya podés iniciar sesión.";
                    
                }

            } catch (PDOException $e) {
                $error_mensaje = "Error en la base de datos";
            }
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
    <title>Registro - EEST N°1</title>
    <link rel="stylesheet" href="../css/index.css">
    <script src="https://kit.fontawesome.com/40202e00e6.js" crossorigin="anonymous"></script>
</head>
<body>
    <main class="auth-card">
        <!-- Panel de marca -->
        <section class="auth-brand">
            <div class="brand-logo">
                <img src="../img/logo_escuela.png" alt="Logo EEST N°1">
            </div>
            <h1>Valoraciones EEST N°1</h1>
        </section>

        <!-- Panel del formulario -->
        <section class="auth-form">
            <h2>Registro de Profesor</h2>
            <p class="auth-subtitle">Completá tus datos para crear la cuenta</p>

            <?php if (!empty($error_mensaje)): ?>
                <div class="alert alert-error" role="alert">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span><?php echo htmlspecialchars($error_mensaje, ENT_QUOTES); ?></span>
                </div>
            <?php endif; ?>

            <?php if (!empty($exito_mensaje)): ?>
                <div class="alert alert-success" role="status">
                    <i class="fa-solid fa-circle-check"></i>
                    <span><?php echo htmlspecialchars($exito_mensaje, ENT_QUOTES); ?></span>
                </div>
                <script>
                    setTimeout(function () {
                        window.location.href = '../index.php';
                    }, 1500);
                </script>
            <?php endif; ?>

            <form action="" method="POST">
                <div class="form-field">
                    <label for="nombre">Nombre</label>
                    <div class="input-group">
                        <i class="fa-solid fa-user input-icon"></i>
                        <input type="text" id="nombre" name="nombre" placeholder="Tu nombre" required>
                    </div>
                </div>

                <div class="form-field">
                    <label for="apellido">Apellido</label>
                    <div class="input-group">
                        <i class="fa-solid fa-user input-icon"></i>
                        <input type="text" id="apellido" name="apellido" placeholder="Tu apellido" required>
                    </div>
                </div>

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
                        <input type="password" id="pass" name="pass" placeholder="Elegí una contraseña" required>
                        <button type="button" class="input-toggle" aria-label="Mostrar u ocultar contraseña">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="form-field">
                    <label for="pass2">Repetir contraseña</label>
                    <div class="input-group">
                        <i class="fa-solid fa-lock input-icon"></i>
                        <input type="password" id="pass2" name="pass2" placeholder="Repetí la contraseña" required>
                        <button type="button" class="input-toggle" aria-label="Mostrar u ocultar contraseña">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="form-field">
                    <label for="email">Email</label>
                    <div class="input-group">
                        <i class="fa-solid fa-envelope input-icon"></i>
                        <input type="email" id="email" name="email" placeholder="tu@email.com" required>
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    <span>Registrarme</span>
                    <i class="fa-solid fa-user-plus"></i>
                </button>

                <p class="auth-links">
                    <a href="../index.php">¿Ya tenés una cuenta? Iniciar sesión</a>
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