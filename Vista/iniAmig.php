<?php

require_once('../Modelo/class.amigos.php');




// Instanciar la clase Amig
$amigos = new Amigo();
require_once('../Vista/cabecera.html');
?>
    <h1>Mis Amigos</h1>
    <?php
    // Mostrar tabla de amigos
    $amigos->mostrarTablaAmigos($_SESSION['usuario_id']);
    ?>

<?php
require_once('../Vista/footer.html');
?>
