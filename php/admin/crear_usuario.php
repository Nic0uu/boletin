<?php
require_once('../conexion.php');
include('../logs/logger.php');
session_start();

if (!isset($_SESSION['user']) || $_SESSION['permisos'] != 3) {
    header('Location: ../acceso.php');
    exit();
}

$status = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre = trim($_POST['nombre'] ?? '');
    $user = trim($_POST['user'] ?? '');
    $pass = trim($_POST['pass'] ?? '');
    $pass2 = trim($_POST['pass2'] ?? '');
    $permisos = $_POST['permisos'] ?? '';

    if (!empty($nombre) && !empty($user) && !empty($pass) && !empty($pass2) && !empty($permisos)) {

        if ($pass !== $pass2) {
            $status = 'coinciden';
        } elseif (!in_array($permisos, ['1', '2', '3'], true)) {
            $status = 'nivel';
        } else {
            try {
                $stmt = $conexion->prepare("SELECT user FROM usuarios WHERE user = :user");
                $stmt->execute(['user' => $user]);

                if ($stmt->fetch()) {
                    $status = 'duplicado';
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
                    $status = 'creado';
                }
            } catch (PDOException $e) {
                registrar_log("Error de BD al crear usuario: " . $e->getMessage(), 'ERROR');
                $status = 'bd';
            }
        }
    } else {
        $status = 'campos';
    }

    header('Location: panel.php?status=' . $status);
    exit();
}

header('Location: panel.php');
exit();
