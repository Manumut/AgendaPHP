<?php

require_once('../Modelo/class.amigos.php');

// Instanciar la clase Amig
$amigos = new Amigo();
require_once('../Vista/cabecera.html');
?>

    <header id="amigos">
        <h1>AGENDA PERSONAL</h1>
        <nav>
            <a href="../Vista/iniAmig.php">Amigos</a>
            <a href="../Vista/iniJuegos.php">Juegos</a>
            <a href="../Vista/iniPrestamos.php">Prestamos</a>
            <a href="../Vista/login.php">Salir</a>
        </nav>
        <div>
            <a href="../Vista/masAmigo.php">Insertar Amigos</a>
            <a href="../Vista/buscAmigo.php">Buscar Amigos</a>
        </div>
    </header>

    <main>
    <h2>Lista de Amigos</h2>
    <?php $amigos->mostrarTablaAmigos($_SESSION['usuario']); ?>

    </main>

<?php
require_once('../Vista/footer.html');
?>
