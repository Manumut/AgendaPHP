<?php
require_once("../Vista/cabecera.html");
?>

<header>
        <h1>AGENDA PERSONAL</h1>
        <nav>
            <a href="../Vista/iniAmigAdmin.php">Contactos</a>
            <a href="../Vista/iniUsuarios.php">Usuarios</a>
            <a href="../Vista/login.php">Salir</a>
        </nav>
        <div>
            <a href="../Vista/masPrestamo.php">Insertar Usuario</a>
            <a href="../Vista/buscPrestamo.php">Buscar Usuario</a>
        </div>
    </header>

    <main id=masAmigos>
        <div class="formu-masAmigos">
            <h1>MODIFICAR USUARIO</h1>
            <form id="aniadir-amigo" action="../Controlador/index.php" method="POST">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" required>

                <label for="apellidos">Contraseña</label>
                <input type="password" id="apellidos" name="apellidos" required>

                <button type="submit">Enviar</button>
            </form>
        </div>
    </main>
























<?php
require_once("../Vista/footer.html");
?>