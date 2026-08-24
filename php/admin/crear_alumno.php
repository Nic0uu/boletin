<?php
require_once('../conexion.php');
include('../logs/logger.php');
session_start();

if (!isset($_SESSION['user']) || $_SESSION['permisos'] != 3) {
    header('Location: ../acceso.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre = trim($_POST['nombre_completo'] ?? '');
    $dni = trim($_POST['dni'] ?? '');
    $curso = trim($_POST['id_curso'] ?? '');

    if (!empty($nombre) && !empty($dni) && !empty($curso)) {

        if (!ctype_digit($dni)) {
            $status = 'alumno_campos';
        } else {
            try {
                $stmt = $conexion->prepare("SELECT id_alumno FROM alumnos WHERE dni = :dni");
                $stmt->execute(['dni' => $dni]);

                if ($stmt->fetch()) {
                    $status = 'alumno_duplicado';
                } else {
                    $stmt = $conexion->prepare(
                        "INSERT INTO alumnos (nombre_completo, dni, id_curso)
                         VALUES (:nombre_completo, :dni, :id_curso)"
                    );

                    $stmt->execute([
                        'nombre_completo' => $nombre,
                        'dni'             => $dni,
                        'id_curso'        => $curso,
                    ]);

                    registrar_log("Alumno creado: " . $nombre . " por " . $_SESSION['user'], 'INFO');
                    $status = 'alumno_creado';
                }
            } catch (PDOException $e) {
                registrar_log("Error de BD al crear alumno: " . $e->getMessage(), 'ERROR');
                $status = 'alumno_bd';
            }
        }
    } else {
        $status = 'alumno_campos';
    }

    header('Location: panel.php?status=' . $status);
    exit();
}

header('Location: panel.php');

exit();