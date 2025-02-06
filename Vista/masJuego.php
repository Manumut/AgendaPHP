<?php
require_once("../Vista/cabecera.html");
?>

<header id="">
        <h1>AGENDA PERSONAL</h1>
        <nav>
            <a href="../Vista/iniAmig.php">Amigos</a>
            <a href="../Vista/iniJuegos.php">Juegos</a>
            <a href="../Vista/iniPrestamos.php">Prestamos</a>
            <a href="../Vista/login.php">Salir</a>
        </nav>
        <div>
            <a href="../Vista/masJuego.php">Insertar Juegos</a>
            <a href="../Vista/buscJuego.php">Buscar Juegos</a>
        </div>
    </header> 

    <main id=masAmigos>
        <div class="formu-masAmigos">
            <h1>NUEVO JUEGO</h1>
            <form id="aniadir-amigo" action="../Controlador/index.php" method="POST">
                <label for="nombre">Título</label>
                <input type="text" id="nombre" name="nombre" required>

                <label for="apellidos">Plataforma</label>
                <input type="text" id="apellidos" name="apellidos" required>

                <label for="fecha_nacimiento">Año de edición</label>
                <input type="number" id="fecha_nacimiento" name="fecha_nacimiento" placeholder="2000" required>

                <label for="foto_juego">Foto del juego</label>


                <button type="submit">Enviar</button>
            </form>
        </div>
    </main>
























<?php
require_once("../Vista/footer.html");
?>