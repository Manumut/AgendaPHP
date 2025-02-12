<?php
    
    // INICIO SESION
    function inicio() {
        require_once("../Modelo/class.usuarios.php")
        $usuario= new Usuario();

        // Nombre en la bd
        if($usuario->nombreCorrec($_POST["user"])){
            // contraseña en la bd
            if($usuario->contraseniaCorrec($_POST["user"],$_POST["psw"])){
                // tipo de usuario
                $tipo=$usuario->tipoUsu($_POST["user"],$_POST["psw"]);
                // Saco id del usuario
                $id_us=$usuario->obtenerId($_POST["user"],$_POST["psw"]);
                
                // Si le ha dado a recordar
                if (isset($_POST["recuerdame"])) {
                    setcookie("user", $user, time() + (86400 * 30), "/");
                }
            }
        }
    }

     