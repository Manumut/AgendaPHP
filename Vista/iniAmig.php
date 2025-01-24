<?php
require_once('cabecera.html');
?>
<header>
        <h1>AGENDA PERSONAL</h1>
        <nav>
            <a href="#">Amigos</a>
            <a href="#">Juegos</a>
            <a href="#">Prestamos</a>
            <a href="../Vista/login.php">Salir</a>
            <!-- <hr style="border: none">
            <a href="#">Inserta Amigos</a>
            <a href="#">Buscar Amigos</a> -->


        </nav>
    </header>

    <section class="cont-amig">
    <div class="formuAmig">
        <h2>Amigos</h2>
        <div class="submenu">
            <a href="../Vista/insertar_amigos.php">Insertar Amigos</a>
            <a href="../Vista/buscar_amigos.php">Buscar Amigos</a>
        </div>

        <h3>Listado de Amigos</h3>
        <table action="../Controlador/index.php?action=inicio">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Fecha de Nacimiento</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
    </div>
</section>







<?php
    require_once('footer.html');
?>



