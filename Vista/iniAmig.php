<?php

require_once('../Modelo/class.amigos.php');

// Instanciar la clase Amig
$amigos = new Amigo();
require_once('../Vista/cabecera.html');
?>

    <header>
        <h1>AGENDA PERSONAL</h1>
        <nav>
            <a href="../Vista/iniAmig.php">Amigos</a>
            <a href="../Vista/juegos.php">Juegos</a>
            <a href="../Vista/prestamos.php">Prestamos</a>
            <a href="../Vista/login.php">Salir</a>
        </nav>
        <div>
            <a href="../Vista/nuevoAmigo.php">Insertar Amigos</a>
            <a href="../Vista/buscAmigo.php">Buscar Amigos</a>
        </div>
    </header>

    <main>
    <h1>Mis Amigos</h1>
    <?php
    // Mostrar tabla de amigos
    $amigos->mostrarTablaAmigos($_SESSION['usuario_id']);
    ?>
    </main>

<?php
require_once('../Vista/footer.html');
?>
