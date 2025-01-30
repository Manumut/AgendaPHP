<?php

require_once('../Modelo/amigos.php');




// Instanciar la clase Amig
$amigos = new Amig();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amigos</title>
    <link rel="stylesheet" href="../Vista/styles.css">
</head>
<body>
    <?php
    // Mostrar tabla de amigos
    echo '<h1>Mis Amigos</h1>';
    $amigos->mostrarTablaAmigos($_SESSION['usuario_id']);
    ?>
</body>
</html>
