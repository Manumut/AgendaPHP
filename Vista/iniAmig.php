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
    
        <!-- Añade un botón para ordenar la lista de amigos por nombre, en
    orden alfabético, y otro para ordenar la lista por fecha de nacimiento, de
    menor a mayor. Una vez mostrada la lista ordenada, se podrá volver a
    pulsar el botón, lo que hará que se ordene de forma inversa.
     -->
    <form action="../Controlador/index.php" method="POST">
        <input type="hidden" name="accion" value="ordenar">
        <input type="submit" value="Ordenar por Nombre" value="orNom">
        <input type="submit" value="Ordenar por Fecha de Nacimiento" value="orNac">
    </form>

    </main>

<?php
require_once('../Vista/footer.html');
?>
