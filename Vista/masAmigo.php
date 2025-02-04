<?php
require_once("../Vista/cabecera.html");
?>


    <main id=masAmigos>
        <div class="formu-masAmigos">
            <h1>NUEVO AMIGO</h1>
            <form id="aniadir-amigo" action="../Controlador/index.php" method="POST">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" required>

                <label for="apellidos">Apellidos</label>
                <input type="text" id="apellidos" name="apellidos" required>

                <label for="fecha_nacimiento">Fecha de nacimiento</label>
                <input type="text" id="fecha_nacimiento" name="fecha_nacimiento" placeholder="dd/mm/aaaa" required>

                <button type="submit">Enviar</button>
            </form>
        </div>
    </main>
























<?php
require_once("../Vista/footer.html");
?>