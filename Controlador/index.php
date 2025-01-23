<?php
    function inicio(){ //Login
        if(isset($_POST["enviar"])){  //Si se ha pulsado el boton
            require_once('../Modelo/modelo.php'); //Incluimos el modelo
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
                require_once('bienvenida.php');  //Incluimos la bienvenida
            }else{
                require_once('../Vista/login.php');  //Incluimos el login
            }
        }
    }




    if(isset($_REQUEST["action"])) {  //Si se ha pulsado una accion
        $action = $_REQUEST["action"];  //Guardamos la accion
        $action();  //Ejecutamos la accion
    }
?>