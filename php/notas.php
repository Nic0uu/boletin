<?php
session_start();
require_once('conexion.php');

if (!isset($_SESSION['dni'])) {
    header('Location: ../index.php');
    exit();
}

$id_materia = $_GET['id'] ?? null;
$curso = $_GET['curso'] ?? null;
$guardado = $_GET['guardado'] ?? null;

$campos = ['1inf', '1cua', '2inf', '2cua', 'intdic', 'intfebmar', 'nota_final'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_materia = $_POST['id_materia'] ?? null;
    $curso = $_POST['curso'] ?? null;

    if ($id_materia && $curso) {

        $stmtProf = $conexion->prepare("SELECT id_profesor FROM materias WHERE id_materia = :id_materia");
        $stmtProf->bindParam(':id_materia', $id_materia);
        $stmtProf->execute();
        $id_profesor = $stmtProf->fetchColumn();

        $guardar_notas = function ($id_alumno, $por_campo) use ($conexion, $id_materia, $curso, $id_profesor, $campos) {

            $stmtNota = $conexion->prepare("SELECT id_nota FROM notas WHERE id_alumno = :id_alumno AND id_materia = :id_materia LIMIT 1");
            $stmtNota->bindParam(':id_alumno', $id_alumno);
            $stmtNota->bindParam(':id_materia', $id_materia);
            $stmtNota->execute();
            $id_nota = $stmtNota->fetchColumn();

            $valores = [];
            foreach ($campos as $campo) {
                $v = trim($por_campo[$campo] ?? '');
                if ($v !== '') {
                    $valores[$campo] = $v;
                }
            }

            if ($id_nota) {
                if (!empty($valores)) {
                    $set = implode(', ', array_map(function ($k) {
                        return "`$k` = :$k";
                    }, array_keys($valores)));
                    $upd = $conexion->prepare("UPDATE notas SET $set WHERE id_nota = :id_nota");
                    foreach ($valores as $k => $v) {
                        $upd->bindValue(":$k", $v);
                    }
                    $upd->bindValue(':id_nota', $id_nota);
                    $upd->execute();
                }
            } else {
                $completos = [];
                foreach ($campos as $campo) {
                    $completos[$campo] = trim($por_campo[$campo] ?? '');
                }
                $cols = 'id_curso, id_profesor, id_alumno, id_materia, fecha, `' . implode('`, `', $campos) . '`';
                $ins = $conexion->prepare("INSERT INTO notas ($cols) VALUES (:id_curso, :id_profesor, :id_alumno, :id_materia, :fecha, :" . implode(', :', $campos) . ")");
                $ins->bindValue(':id_curso', $curso);
                $ins->bindValue(':id_profesor', $id_profesor);
                $ins->bindValue(':id_alumno', $id_alumno);
                $ins->bindValue(':id_materia', $id_materia);
                $ins->bindValue(':fecha', date('Y-m-d'));
                foreach ($completos as $k => $v) {
                    $ins->bindValue(":$k", $v);
                }
                $ins->execute();
            }
        };

        if (!empty($_POST['guardar_todo'])) {
            $ids = array_keys($_POST['1inf'] ?? []);
            foreach ($ids as $id_alumno) {
                $por_campo = [];
                foreach ($campos as $campo) {
                    $por_campo[$campo] = $_POST[$campo][$id_alumno] ?? '';
                }
                $guardar_notas($id_alumno, $por_campo);
            }
            header("Location: notas.php?id=" . urlencode($id_materia) . "&curso=" . urlencode($curso) . "&guardado=" . urlencode('todos los alumnos'));
            exit();
        }

        $id_alumno = $_POST['id_alumno'] ?? null;
        if ($id_alumno) {
            $por_campo = [];
            foreach ($campos as $campo) {
                $por_campo[$campo] = $_POST[$campo] ?? '';
            }
            $guardar_notas($id_alumno, $por_campo);

            $stmtNombre = $conexion->prepare("SELECT nombre_completo FROM alumnos WHERE id_alumno = :id_alumno");
            $stmtNombre->bindParam(':id_alumno', $id_alumno);
            $stmtNombre->execute();
            $nombre = $stmtNombre->fetchColumn();

            header("Location: notas.php?id=" . urlencode($id_materia) . "&curso=" . urlencode($curso) . "&guardado=" . urlencode($nombre));
            exit();
        }
    }
}

$stmt = $conexion->prepare("SELECT a.id_alumno, a.nombre_completo, c.curso, n.id_nota,
                            n.`1inf`, n.`1cua`, n.`2inf`, n.`2cua`, n.intdic, n.intfebmar, n.nota_final
                            FROM alumnos as a 
                            INNER JOIN cursos as c ON a.id_curso = c.id_curso
                            LEFT JOIN notas as n ON a.id_alumno = n.id_alumno AND n.id_materia = :id_materia
                            WHERE c.id_curso = :id_curso
                            GROUP BY a.id_alumno");

$stmt->bindParam(':id_materia', $id_materia);
$stmt->bindParam(':id_curso', $curso);
$stmt->execute();
$alumnos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmtCurso = $conexion->prepare("SELECT curso FROM cursos WHERE id_curso = :id_curso");
$stmtCurso->bindParam(':id_curso', $curso);
$stmtCurso->execute();
$curso_nombre = $stmtCurso->fetchColumn();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notas - EEST N°1</title>
    <link rel="stylesheet" href="../css/notas.css">
</head>
<body>
    <header>
        <h1>Notas — <?= htmlspecialchars($curso_nombre) ?></h1>
        <div class="header-actions">
            <button type="button" id="guardar-todo" class="btn-guardar">Guardar todo</button>
            <a href="menu.php">← Volver al menú</a>
        </div>
    </header>
    <main>
        <?php if ($guardado): ?>
            <div class="alert-success" role="alert">
                Notas guardadas para <?= htmlspecialchars($guardado, ENT_QUOTES, 'UTF-8') ?>.
            </div>
        <?php endif; ?>
        <div class="table-wrap">
        <table>
            <caption class="visually-hidden">Planilla de notas de <?= htmlspecialchars($curso_nombre) ?></caption>
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
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($alumnos as $alumno): ?>
                <tr>
                    <th scope="row">
                        <form id="f<?= $alumno['id_alumno'] ?>" method="post">
                            <input type="hidden" name="id_materia" value="<?= htmlspecialchars($id_materia) ?>">
                            <input type="hidden" name="curso" value="<?= htmlspecialchars($curso) ?>">
                            <input type="hidden" name="id_alumno" value="<?= $alumno['id_alumno'] ?>">
                        </form>
                        <?= htmlspecialchars($alumno['nombre_completo']) ?>
                    </th>
                    <td data-label="1° informe">
                        <select name="1inf" form="f<?= $alumno['id_alumno'] ?>" class="form-select" aria-label="1° informe">
                            <option value="">Seleccione</option>
                            <option value="tea" <?= (($alumno['1inf'] ?? '') === 'tea') ? 'selected' : '' ?>>TEA</option>
                            <option value="tep" <?= (($alumno['1inf'] ?? '') === 'tep') ? 'selected' : '' ?>>TEP</option>
                            <option value="ted" <?= (($alumno['1inf'] ?? '') === 'ted') ? 'selected' : '' ?>>TED</option>
                        </select>
                    </td>
                    <td data-label="1° cuatrimestre">
                        <input type="number" name="1cua" form="f<?= $alumno['id_alumno'] ?>" class="form-control" aria-label="1° cuatrimestre" value="<?= $alumno['1cua'] ?? '' ?>">
                    </td>
                    <td data-label="2° informe">
                        <select name="2inf" form="f<?= $alumno['id_alumno'] ?>" class="form-select" aria-label="2° informe">
                            <option value="">Seleccione</option>
                            <option value="tea" <?= (($alumno['2inf'] ?? '') === 'tea') ? 'selected' : '' ?>>TEA</option>
                            <option value="tep" <?= (($alumno['2inf'] ?? '') === 'tep') ? 'selected' : '' ?>>TEP</option>
                            <option value="ted" <?= (($alumno['2inf'] ?? '') === 'ted') ? 'selected' : '' ?>>TED</option>
                        </select>
                    </td>
                    <td data-label="2° cuatrimestre">
                        <input type="number" name="2cua" form="f<?= $alumno['id_alumno'] ?>" class="form-control" aria-label="2° cuatrimestre" value="<?= $alumno['2cua'] ?? '' ?>">
                    </td>
                    <td data-label="Int. diciembre">
                        <input type="number" name="intdic" form="f<?= $alumno['id_alumno'] ?>" class="form-control" aria-label="int. diciembre" value="<?= $alumno['intdic'] ?? '' ?>">
                    </td>
                    <td data-label="Int. febrero/marzo">
                        <input type="number" name="intfebmar" form="f<?= $alumno['id_alumno'] ?>" class="form-control" aria-label="int. febrero/marzo" value="<?= $alumno['intfebmar'] ?? '' ?>">
                    </td>
                    <td data-label="Nota final">
                        <input type="number" name="nota_final" form="f<?= $alumno['id_alumno'] ?>" class="form-control" aria-label="nota final" value="<?= $alumno['nota_final'] ?? '' ?>">
                    </td>
                    <td data-label="Guardar">
                        <button type="submit" form="f<?= $alumno['id_alumno'] ?>" class="btn-guardar">Guardar</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        </div>
    </main>
    <script>
        document.getElementById('guardar-todo').addEventListener('click', function () {
            var filas = document.querySelectorAll('form[id^="f"]');
            if (!filas.length) {
                return;
            }
            var form = document.createElement('form');
            form.method = 'post';
            form.action = 'notas.php';
            var add = function (name, value) {
                var i = document.createElement('input');
                i.type = 'hidden';
                i.name = name;
                i.value = value;
                form.appendChild(i);
            };
            add('guardar_todo', '1');
            add('id_materia', filas[0].querySelector('input[name="id_materia"]').value);
            add('curso', filas[0].querySelector('input[name="curso"]').value);
            var campos = ['1inf', '1cua', '2inf', '2cua', 'intdic', 'intfebmar', 'nota_final'];
            filas.forEach(function (f) {
                var id = f.querySelector('input[name="id_alumno"]').value;
                campos.forEach(function (c) {
                    var el = f.querySelector('[name="' + c + '"]');
                    if (el) {
                        add(c + '[' + id + ']', el.value);
                    }
                });
            });
            document.body.appendChild(form);
            form.submit();
        });
    </script>
</body>
</html>