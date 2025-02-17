<?php
    
    // INICIO SESION
    function inicio() {
        require_once("../Modelo/class.usuarios.php");
        $usuario= new Usuario();

        // Si le ha dado a recordar y hay una cookie la borro 
        if (isset($_POST["recuerdame"])) {
            require_once("../Modelo/class.sesion.php");
            eliminarCookie("usuario");
        }

        // Nombre en la bd
        if($usuario->nombreCorrec($_POST["user"])){
            // contraseña en la bd
            if($usuario->contraseniaCorrec($_POST["user"],$_POST["psw"])){
                // tipo de usuario
                $tipo=$usuario->tipoUsu($_POST["user"],$_POST["psw"]);
                // Saco id del usuario
                $id_us=$usuario->obtenerId($_POST["user"],$_POST["psw"]);
                
                //Si marca recordar se crea una cookie con el nombre del usuario
                if (isset($_POST["recuerdame"])) {
                    require_once("../Modelo/class.sesion.php");
                    crearCookie("usuario",$_POST["user"]);
                }

                // Si no marca recordar se borra la cookie
                else{
                    require_once("../Modelo/class.sesion.php");
                    eliminarCookie("usuario");
                }

                // Establece la sesion
                require_once("../Modelo/class.sesion.php");
                establecerSesion("id_us", $id_us, "nom_us", $_POST["user"], "tipo_us", $tipo);

                // Si es administrador
                if($tipo=="admin"){
                    header("Location: ../Vista/iniAmigAdmin.php");
                }
                // Si es usuario
                elseif($tipo=="usuario"){
                    header("Location: ../Vista/iniAmig.php");
                }
                else{
                    header("Location: ../Vista/login.php");
                    echo "Error";
                }
                
            }else{
                header("Location: ../Vista/login.php");
                echo "Contraseña Incorrecta";
            }
        }else{
            header("Location: ../Vista/login.php");
            echo "Usuario no registrado";
        }
        
    }
    function salir(){
        require_once("../Modelo/class.sesion.php");
        cerrarSesion();
        header("Location: ../Vista/login.php");
    }

    //Función para redirigir a la vista de amigos
    function VistaAmigos() {
        //Mostrar amigos antes de redirigir
        require_once("../Modelo/class.sesiones.php");
        iniciarSesion();

        //Como esta vista también puede ser la de contactos del admin, hay que comprobar el tipo de usuario
        if(obtenerSesion("tipo_us")=="admin"){
            require_once("../Modelo/class.amigos.php");
            $amigos = new Amigo();
            $fullAmigos->allAmigos(obtenerSesion("id_us"));
            header("Location: ../Vista/iniAmigAdmin.php");

        }
        elseif(obtenerSesion("tipo_us")=="usuario"){
            require_once("../Modelo/class.amigos.php");
            $amigos = new Amigo();
            $fullAmigos->allAmigos(obtenerSesion("id_us"));
            header("Location: ../Vista/iniAmig.php");
        }
    }