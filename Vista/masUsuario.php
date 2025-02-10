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
            <a href="../Vista/masUsuario.php">Insertar Usuario</a>
            <a href="../Vista/buscUsuario.php">Buscar Usuario</a>
        </div>
    </header>


    <main id=masAmigos>
        <div class="formu-masAmigos">
            <h1>NUEVO USUARIO</h1>
            <form id="aniadir-amigo" action="../Controlador/index.php" method="POST">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" required>

                <label for="contrasenia">Contraseña</label>
                <input type="text" id="contrasenia" name="contrasenia" required>

                <button type="submit">Enviar</button>
            </form>
        </div>
    </main>
























<?php
require_once("../Vista/footer.html");
?>