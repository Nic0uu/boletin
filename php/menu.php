<?php
include_once 'conexion.php';
session_start();

if (!isset($_SESSION['dni'])) {
    header('Location: ../index.php');
    exit();
}

$stmt = $conexion->prepare("SELECT m.materia, m.id_materia, c.curso, c.id_curso FROM materias as m INNER JOIN cursos as c ON m.id_curso = c.id_curso INNER JOIN profesores as p ON m.id_profesor = p.id_profesor WHERE p.dni = :dni");
$stmt->bindParam(':dni', $_SESSION['dni']);
$stmt->execute();
$materias = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio - EEST N°1</title>
    <link rel="stylesheet" href="../css/menu.css" class="css">
    <script src="https://kit.fontawesome.com/40202e00e6.js" crossorigin="anonymous"></script>
</head>
<body>
    <header>
        <h1>Bienvenido, <?php echo $_SESSION['nombre']; ?></h1>
        <a href="logout.php">Cerrar sesión</a>
    </header>
    <main>
        <h2>Mis cursos</h2>
        <?php if (empty($materias)): ?>
            <p>No tenés materias asignadas.</p>
        <?php else: ?>
            <ul class="cards">
                <?php foreach ($materias as $materia): ?>
                    <li data-materia="<?= $materia['materia'] ?>">
                        <a href="notas.php?id=<?= $materia['id_materia'] ?>&curso=<?= $materia['id_curso'] ?>">
                            <div class="card-header">
                                <span class="card-nombre"><?= $materia['materia'] ?></span>
                                <i class="fa-solid fa-ellipsis-vertical card-menu"></i>
                            </div>
                            <div class="card-body">
                                <span class="card-curso"><?= $materia['curso'] ?></span>
                            </div>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </main>
</body>
</html>