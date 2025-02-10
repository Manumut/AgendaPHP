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
            <a href="../Vista/masAmigoAdmin.php">Insertar Amigo</a>
            <a href="../Vista/buscAmigoAdmin.php">Buscar Amigo</a>
        </div>
    </header>

    <main id=masAmigos>
        <div class="formu-masAmigos">
            <h1>MODIFICAR AMIGO</h1>
            <form id="aniadir-amigo" action="../Controlador/index.php" method="POST">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" required>

                <label for="apellidos">Apellidos</label>
                <input type="text" id="apellidos" name="apellidos" required>

                <label for="fecha_nacimiento">Fecha de nacimiento</label>
                <input type="text" id="fecha_nacimiento" name="fecha_nacimiento" placeholder="dd/mm/aaaa" required>

                <label for="fecha_nacimiento">Usuario dueño</label>
                <input type="selec" id="" name=""  required>

                <button type="submit">Enviar</button>
            </form>
        </div>
    </main>
























<?php
require_once("../Vista/footer.html");
?>