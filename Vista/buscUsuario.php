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


    <main id="buscadores">
        <div class="form-busc">
            <h1>BUSCAR USUARIOS</h1>
            <form action="../Controlador/index.php" method="POST">
                <label for="busqueda"> Nombre del usuario</label>
                <input type="text" id="busqueda" name="busqueda" required>
                <button type="submit">Buscar</button>
            </form>

            <?php if (!empty($resultados)): ?>
                <h2>Resultados</h2>
                <table>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Fecha de Nacimiento</th>
                    </tr>
                    <?php foreach ($resultados as $amigo): ?>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php elseif ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
                <p>No se encontraron resultados.</p>
            <?php endif; ?>
        </div>
    </main>



<?php
require_once("../Vista/footer.html");
?>