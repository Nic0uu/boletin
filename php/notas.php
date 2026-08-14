<?php
session_start();
require_once('conexion.php');

$id_materia = $_GET['id'];


$stmt = $conexion->prepare("SELECT a.nombre_completo, c.id_curso FROM alumnos as a 
                            INNER JOIN cursos as c ON a.id_curso = c.id_curso,
                            INNER JOIN notas as n ON c.id_curso = n.id_curso,
                            WHERE n.id_materia = $id_materia;"
                            );
$stmt->bindParam(':dni', $_SESSION['dni']);
$stmt->execute();
$alumnos = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notas - EEST N°1</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

</head>
<body>
    <header>

    </header>
    <main>
        <table class="table">
            <thead>
                <tr>
                <th scope="col">Alumno</th>
                <th scope="col">1° INFORME</th>
                <th scope="col">1° CUATRIMESTRE</th>
                <th scope="col">2° INFORME</th>
                <th scope="col">2° CUATRIMESTRE</th>
                <th scope="col">INT. DIC</th>
                <th scope="col">INT. FEB/MAR</th>
                <th scope="col">NOTA FINAL</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <?php foreach ($alumnos as $alumno){?>
                    <th scope="row"><?= $alumno['nombre_completo']?></th>
                    <td>    </td>
                    <td>Otto</td>
                    <td>@mdo</td>
                    <?php } ?>
                </tr>
            </tbody>
        </table>
    </main>
</body>
</html>