<?php
    function inicio(){ //Login
        if(isset($_POST["enviar"])){  //Si se ha pulsado el boton
            require_once('../Modelo/coockie&Session.php'); //Incluimos el modelo
            require_once('../Modelo/class.db.php');  //Incluimos la base de datos

            $db = new db(); //Creamos el objeto

            if(!isset($_POST["rec"])){  //Si no se ha pulsado el checkbox
                unset_cookie("usuario"); //Borramos el cookie
            }

            if($db->compCrede($_POST["nom"], $_POST["psw"])) { //Comprobamos las credenciales
                if(isset($_POST["rec"])) //Si se ha pulsado el checkbox
                    set_cookie("usuario", $_POST["nom"]); //Creamos el cookie

                set_session('usu', $_POST["nom"]);  //Creamos la sesion
                $nUsu=$_POST["nom"];  //Guardamos el nombre en una variable
                require_once('../Vista/iniAmig.php');  //Incluimos la bienvenida
            }else{
                require_once('../Vista/login.php');  //Incluimos el login
            }
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