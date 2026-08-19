<?php

function registrar_log($mensaje, $tipo = 'INFO') {
    $archivo_log = __DIR__ . '/accesos.log';
    $fecha = date('Y-m-d H:i:s');
    $linea = "[$fecha] [$tipo] $mensaje" . PHP_EOL;

    file_put_contents($archivo_log, $linea, FILE_APPEND | LOCK_EX);
}
