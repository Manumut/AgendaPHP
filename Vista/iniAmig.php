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
            <p>Entra en tu agenda personal</p>
            <form action="../Controlador/index.php?action=amig" method="post">
                <input type="submit" value="Entrar" name="enviar">
            </form>
            <div>
            <a href="#">Inserta Amigos</a>
            <a href="#">Buscar Amigos</a>
            </div>
            
        </div>
    </section>







<?php
    require_once('footer.html');
?>