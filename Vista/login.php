<?php
require_once('cabecera.html');
?>
<header>
        <h1>AGENDA PERSONAL</h1>
        <nav>
            <a href="#">Home</a>
            <a href="#">Accede</a>
        </nav>
    </header>

    <div class="container">
        <div class="form-box">
            <h2>Inicia Sesión</h2>
            <form action="../Controlador/index.php?action=inicio" method="post">
        <label for="nom">Nombre</label>
        <input type="text" name="nom">
        <br>
        <label for="psw">Contraseña</label>
        <input type="password" name="psw">
        <br>
        <input type="checkbox" name="rec" <?php if(isset($_COOKIE["usuario"])) echo"checked" ?>>
        <label for="rec">Recordarme</label>
        <br>
        <input type="submit" value="Enviar" name="enviar">
    </form>
        </div>
    </div>

    
    
<?php
    require_once('footer.html');
?>