<?php
require_once('conexion.php');
include('../logs/logger.php');
session_start();

$error_mensaje = "";

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $pass = trim($_POST['pass']);
    $user = trim($_POST['user']);

    if(!empty($pass) && !empty($user)){
        try{

            $stmt = $conexion->prepare("SELECT user, pass, nombre, permisos FROM usuarios WHERE user = :user");
            $stmt->execute(':user' => $user);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if($usuario && password_verify($pass, $usuario['pass'])){
                session_regenerate_id(true);
                
                $_SESSION['user'] = $usuario['user'];
                $_SESSION['nombre'] = $usuario['nombre'];
                $_SESSION['permisos'] = $usuario['permisos'];

                registrar_log("Inicio de sesión exitoso del usuario: " . $usuario['user'], 'INFO');

                header("Location: panel.php");
                exit();
            }else{
                $error_mensaje = "Contraseña o DNI incorrectos";
            }
        }catch (PDOException $e) {
            registrar_log("Error de BD: " . $e->getMessage(), 'ERROR');
            $error_mensaje = "Error en la base de datos";
        }

        
    }else {
        $error_mensaje = "Por favor, complete todos los campos";
    }
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - EEST N°1</title>
</head>
<body>
    <header>

    </header>
    
    <?php if (!empty($error_mensaje)): ?>
        <div class="alert alert-error" role="alert">
            <i class="fa-solid fa-circle-exclamation"></i>
            <span><?php echo htmlspecialchars($error_mensaje, ENT_QUOTES, 'UTF-8'); ?></span>
        </div>
    <?php endif; ?>

    <main>
        <h1>Acceder al panel</h1>
        <form action="" method ="POST">

            <input type="text" name="user" placeholder="Ingrese su usuario">

            <input type="password" name="pass" placeholder="Ingrese la contraseña">

            <button type="submit">Ingresar</button>
        </form>
    </main>
</body>
</html>