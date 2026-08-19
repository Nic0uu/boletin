<?php
require_once('conexion.php')
session_start();
/*
==================
    TO DO LIST
==================

- Crear usuario (3)
- Crear alumno(1)
- Modificar datos de usuario, profesor y alumno (3)
- Blanqueo pass (3)
- Agregar curso y materias (2)
- Modificar datos de materias (1)
- Exportar notas de todos los cursos e individual (2)
*/


if (!isset($_SESSION['user']) || $_SESSION['permisos'] !== 'admin') {
    include_once('../logs/logger.php');
    registrar_log("Acceso no autorizado intentado a panel.php por: " . ($_SESSION['nombre_completo'] ?? 'Invitado'), 'WARNING');

    header("Location: ../../index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel - EEST N°1</title>
</head>
<body>
    <header>

    </header>
    <main>
    <!-- PERMISOS NIVEL 1 (secretario/a)-->
    <?php if($_SESSION['permisos'] == 1 || $_SESSION['permisos'] == 2 || $_SESSION['permisos'] == 3){?>


    <?php}?>
    <!-- PERMISOS NIVEL 2 (directivo)-->
    <?php if($_SESSION['permisos'] == 2 || $_SESSION['permisos'] == 3){?>


    <?php}?>
    <!-- PERMISOS NIVEL 3 (admin)-->
    <?php if($_SESSION['permisos'] == 3){?>


    <?php}?>
    </main>
</body>
</html>