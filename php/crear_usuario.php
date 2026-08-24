<?php
require_once('conexion.php');
include('logs/logger.php');
session_start();

$error_mensaje = "";
$exito_mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre = trim($_POST['nombre'] ?? '');
    $user = trim($_POST['user'] ?? '');
    $pass = trim($_POST['pass'] ?? '');
    $pass2 = trim($_POST['pass2'] ?? '');
    $permisos = $_POST['permisos'] ?? '';

    $niveles_validos = ['1', '2', '3'];

    if (!empty($nombre) && !empty($user) && !empty($pass) && !empty($pass2) && !empty($permisos)) {

        if ($pass !== $pass2) {
            $error_mensaje = "Las contraseñas no coinciden";
        } elseif (!in_array($permisos, $niveles_validos, true)) {
            $error_mensaje = "Nivel de permisos inválido";
        } else {
            try {
                $stmt = $conexion->prepare("SELECT user FROM usuarios WHERE user = :user");
                $stmt->execute(['user' => $user]);

                if ($stmt->fetch()) {
                    $error_mensaje = "Ya existe un usuario con ese nombre de usuario";
                } else {
                    $pass_hash = password_hash($pass, PASSWORD_DEFAULT);

                    $stmt = $conexion->prepare(
                        "INSERT INTO usuarios (user, pass, nombre, permisos)
                         VALUES (:user, :pass, :nombre, :permisos)"
                    );
                    $stmt->execute([
                        'user'     => $user,
                        'pass'     => $pass_hash,
                        'nombre'   => $nombre,
                        'permisos' => $permisos
                    ]);

                    registrar_log("Usuario creado: " . $user . " (nivel " . $permisos . ")", 'INFO');

                    $exito_mensaje = "Usuario creado correctamente.";
                }
            } catch (PDOException $e) {
                registrar_log("Error de BD al crear usuario: " . $e->getMessage(), 'ERROR');
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
    <title>Crear Usuario - EEST N°1</title>
    <link rel="stylesheet" href="../css/index.css">
    <script src="https://kit.fontawesome.com/40202e00e6.js" crossorigin="anonymous"></script>
    <style>
        select {
            width: 100%;
            padding: 0.85rem 1rem;
            font-size: 0.95rem;
            font-family: var(--font-body);
            color: var(--gray-900);
            background: var(--white);
            border: 1px solid var(--gray-300);
            border-radius: var(--radius);
            cursor: pointer;
            transition: border-color 0.18s ease, box-shadow 0.18s ease;
        }

        select:hover {
            border-color: var(--navy-500);
        }

        select:focus {
            outline: none;
            border-color: var(--orange);
            box-shadow: var(--focus-ring);
        }
    </style>
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
            <h2>Crear Usuario</h2>
            <p class="auth-subtitle">Alta temporal de usuarios del panel</p>

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
            <?php endif; ?>

            <form action="" method="POST">
                <div class="form-field">
                    <label for="nombre">Nombre</label>
                    <div class="input-group">
                        <i class="fa-solid fa-user input-icon"></i>
                        <input type="text" id="nombre" name="nombre" placeholder="Nombre completo" required>
                    </div>
                </div>

                <div class="form-field">
                    <label for="user">Usuario</label>
                    <div class="input-group">
                        <i class="fa-solid fa-id-card input-icon"></i>
                        <input type="text" id="user" name="user" placeholder="Nombre de usuario" required>
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
                    <label for="permisos">Nivel de permisos</label>
                    <div class="input-group">
                        <i class="fa-solid fa-shield-halved input-icon"></i>
                        <select id="permisos" name="permisos" required>
                            <option value="" disabled selected>Elegí un nivel</option>
                            <option value="1">Nivel 1 — Solo consulta</option>
                            <option value="2">Nivel 2 — Carga de notas</option>
                            <option value="3">Nivel 3 — Administrador</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    <span>Crear usuario</span>
                    <i class="fa-solid fa-user-plus"></i>
                </button>

                <p class="auth-links">
                    <a href="acceso.php">Ir al login del panel</a>
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
