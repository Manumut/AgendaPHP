<?php
require_once("../Vista/cabecera.html");
?>
    <main id="buscAm">
        <div class="form-buscAm">
            <h1>Buscar Amigos</h1>
            <form action="../Controlador/index.php" method="POST">
                <label for="busqueda">Nombre o Apellidos</label>
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
                            <td><?php echo htmlspecialchars($amigo['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($amigo['apellidos']); ?></td>
                            <td><?php echo htmlspecialchars($amigo['fecha_nacimiento']); ?></td>
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