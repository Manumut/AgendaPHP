<?php
require_once("../Vista/cabecera.html");
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
            <a href="../Vista/masPrestamo.php">Insertar Prestamos</a>
            <a href="../Vista/buscPrestamo.php">Buscar Prestamos</a>
        </div>
    </header>

    <form action="../Controlador/index.php" method="POST">
        <input type="hidden" name="accion" value="verificao">
        <input type="number" name="" id="">
    </form>




















<?php
require_once("../Vista/footer.html");
?>