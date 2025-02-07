<?php

require_once('../Modelo/class.amigos.php');

// Instanciar la clase Amig
$amigos = new Amigo();
require_once('../Vista/cabecera.html');
?>

    <header>
        <h1>AGENDA PERSONAL</h1>
        <nav>
            <a href="../Vista/iniAmigAdmin.php">Contactos</a>
            <a href="../Vista/iniUsuarios.php">Usuarios</a>
            <a href="../Vista/login.php">Salir</a>
        </nav>
        <div>
            <a href="../Vista/masPrestamo.php">Insertar Prestamos</a>
            <a href="../Vista/buscPrestamo.php">Buscar Prestamos</a>
        </div>
    </header>


    <main>
    <h2>Lista de Amigos</h2>
    <?php $amigos->mostrarTablaAmigos($_SESSION['usuario']); ?>

    </main>

<?php
require_once('../Vista/footer.html');
?>
