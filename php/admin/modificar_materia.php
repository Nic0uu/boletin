<?php
require_once('../conexion.php');
include('../logs/logger.php');
session_start();

if (!isset($_SESSION['user']) || !in_array((string) $_SESSION['permisos'], ['1', '2', '3'], true)) {
    header('Location: ../acceso.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: panel.php');
    exit();
}

$pag = (int) ($_POST['pag'] ?? 1);
$pag = max($pag, 1);

$status = '';

$id_materia = (int) ($_POST['id_materia'] ?? 0);
$materia = trim($_POST['materia'] ?? '');
$id_curso = (int) ($_POST['id_curso'] ?? 0);
$id_profesor = (int) ($_POST['id_profesor'] ?? 0);

if ($id_materia > 0 && $materia !== '' && $id_curso > 0) {
    try {
        $stmt = $conexion->prepare(
            "UPDATE materias
             SET materia = :materia, id_curso = :id_curso, id_profesor = :id_profesor
             WHERE id_materia = :id_materia"
        );
        $stmt->execute([
            'materia'     => $materia,
            'id_curso'    => $id_curso,
            'id_profesor' => $id_profesor,
            'id_materia'  => $id_materia
        ]);

        registrar_log("Materia modificada: " . $materia . " (id " . $id_materia . ") por " . $_SESSION['user'], 'INFO');
        $status = 'materia_editada';
    } catch (PDOException $e) {
        registrar_log("Error de BD al modificar materia: " . $e->getMessage(), 'ERROR');
        $status = 'bd';
    }
} else {
    $status = 'materia_campos';
}

header('Location: panel.php?pag=' . $pag . '&status=' . $status);
exit();
