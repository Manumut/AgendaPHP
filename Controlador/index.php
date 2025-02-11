<?php
    // function inicio(){
    //     $user = $_POST["user"]; // Se obtiene el usuario del formulario
    //     $pass = $_POST["psw"]; // Se obtiene la contraseña del formulario
    //     $usuario = new Usuario();
    //     $validacion = $usuario->iniciar_sesion($user, $pass); // Se verifica si el usuario es válido

    //     session_start(); // Se inicia la sesión
    //     $_SESSION['user'] = $user; // Se guarda el usuario en la sesión

    //     // Si el usuario marcó "recuerdame", se guarda en una cookie por 30 días
    //     if (isset($_POST["recuerdame"])) {
    //         setcookie("user", $user, time() + (86400 * 30), "/");
    //     }

    //     // Si la validación es correcta, se redirige a lista de amigos, si no, a lista de usuarios
    //     if ($validacion) {
    //         header("Location: ../Vista/iniAmigo.php");
    //     } else {
    //         header("Location: ./Vista/login.php");
    //     }
    // }

    function inicio() {
        $user = $_POST["user"];
        $pass = $_POST["psw"];
        echo "hola";
        $usuario = new Usuario();
        $validacion = $usuario->iniciar_sesion($user, $pass);
        echo "hola1";

        session_start();
        echo "hola2";

        if ($validacion) {
            $_SESSION['user'] = $usuario->nombre_usuario;
            $_SESSION['tipo'] = $usuario->tipo;
    
            if (isset($_POST["recuerdame"])) {
                setcookie("user", $user, time() + (86400 * 30), "/");
            }
    
            header("Location: ../Vista/iniAmigo.php");
            exit();
        } else {
            header("Location: ../Vista/login.php");
            exit();
        }
    }

     function procesar_amigo(){

        // Verificar si el usuario está logueado
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: login.php');
            exit();
        }

        // Verificar si los datos fueron enviados
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $db = new db();
            $conn = $db->conexion();

            // Obtener datos del formulario
            $usuario_id = $_SESSION['usuario_id'];
            $nombre = $_POST['nombre'];
            $apellidos = $_POST['apellidos'];
            $fecha_nacimiento = $_POST['fecha_nacimiento'];

            // Insertar en la base de datos
            $query = "INSERT INTO amigos (usuario_id, nombre, apellidos, fecha_nacimiento) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("isss", $usuario_id, $nombre, $apellidos, $fecha_nacimiento);

            if ($stmt->execute()) {
                echo "<script>alert('Amigo agregado correctamente.'); window.location.href='../Vista/iniAmig.php';</script>";
            } else {
                echo "<script>alert('Error al agregar amigo.'); window.history.back();</script>";
            }

            $stmt->close();
            $conn->close();
        } else {
            header("Location: ../Vista/nuevoAmigo.php");
            exit();
        }

    }

    function buscar_amigo(){
        require_once('../Modelo/class.amigos.php');
    session_start();

    // Verificar si el usuario está logueado
    if (!isset($_SESSION['usuario_id'])) {
        header('Location: ../Vista/login.php');
        exit();
    }

    // Instanciar la clase Amigo
    $amigo = new Amigo();
    $resultados = [];

    // Si se envió el formulario, procesar la búsqueda
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $busqueda = $_POST['busqueda'];
        $resultados = $amigo->buscarAmigos($_SESSION['usuario_id'], $busqueda);
    }

    // Incluir la vista
    require_once('../Vista/buscAmigo.php');
    


    }


    require_once('../Modelo/class.usuarios.php');
session_start();

if (isset($_POST["action"])) {
    $action = $_POST["action"];
    if ($action == "login") {
        $usuario = new Usuario();
        if ($usuario->login($_POST["nombre"], $_POST["password"])) {
            header("Location: ../Vista/iniAmig.php");
        } 
        // else {
        //     echo "Usuario o contraseña incorrectos";
        // }
    }
}


 
    // if(isset($_REQUEST["action"])) {  //Si se ha pulsado una accion
    //     $action = $_REQUEST["action"];  //Guardamos la accion
    //     $action();  //Ejecutamos la accion
    // }