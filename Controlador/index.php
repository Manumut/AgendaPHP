<?php
    
    // INICIO SESION
    function inicio() {
        require_once("../Modelo/class.usuarios.php");
        $usuario= new Usuario();

        session_start();

        // Si le ha dado a recordar y hay una cookie la borro 
        if (isset($_POST["recuerdame"])) {
            require_once("../Modelo/class.sesion.php");
            eliminarCookie("usuario");
        }

        // Nombre en la bd
        if($usuario->nombreCorrec($_POST["usuario"])){
            // contraseña en la bd
            if($usuario->contraseniaCorrec($_POST["usuario"],$_POST["psw"])){
                // tipo de usuario
                $tipo=$usuario->tipoUsu($_POST["usuario"],$_POST["psw"]);
                // Saco id del usuario
                $id_us=$usuario->obtenerId($_POST["usuario"],$_POST["psw"]);
                
                //Si marca recordar se crea una cookie con el nombre del usuario
                if (isset($_POST["recuerdame"])) {
                    crearCookie("usuario",$_POST["usuario"]);
                }

                // Si no marca recordar se borra la cookie
                else{
                    eliminarCookie("usuario");
                }

                // Establece la sesion
                establecerSesion("id_us", $id_us, "nom_us", $_POST["usuario"], "tipo_us", $tipo);

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
    function vistaBuscAmigos() {
        //Mostrar amigos antes de redirigir
        require_once("../Modelo/class.sesiones.php");
        iniciarSesion();

        //Como esta vista también puede ser la de contactos del admin, hay que comprobar el tipo de usuario
        if(obtenerSesion("tipo_us")=="admin"){
            require_once("../Vista/buscAmigoAdmin.php");
        }
        elseif(obtenerSesion("tipo_us")=="usuario"){
            require_once("../Vista/buscAmigo.php");
        }
    }

        //Función para redirigir a la vista de usuarios
    function vistaBuscUsuarios() {
        require_once("../Modelo/class.sesiones.php");
        iniciarSesion();

        //Sacar el tipo cada vez que se muestra una vista para saber que menú se tiene que mostrar en ese momento
        if(obtenerSesion("tipo_us")=="admin"){
            header("Location: ../Vista/buscUsuarios.php");
        }
    }

    function vistaInserAmigos() {
        require_once("../Modelo/class.sesiones.php");
        iniciarSesion();

        //Sacar el tipo cada vez que se muestra una vista para saber que menú se tiene que mostrar en ese momento
        if(obtenerSesion("tipo_us")=="admin"){
            header("Location: ../Vista/insertarAmigos.php");
        }elseif(obtenerSesion("tipo_us")=="usuario"){
            header("Location: ../Vista/insertarAmigos.php");    
        }
    }
    
    function insertAmigo(){
        require_once("../Modelo/class.sesiones.php");
        iniciarSesion();

        require_once("../Modelo/class.amigos.php");
        $amigos = new Amigo();
        if(obtenerSesion("tipo_us")=="usuario"){
            if($amigos->insertarAmigo($_POST["nombre"],$_POST["apellidos"],$_POST["nacimiento"],obtenerSesion("id_us"))){
                //Si se ha insertado correctamente redirigir al menu de amigos
                vistaBuscAmigos();
            }else{
                //Si no se ha insertado correctamente, mostrar mensaje y redirigir al menu de amigos
                $mnsj="No se ha podido insertar el amigo";
                vistaBuscAmigos($mnsj);  
            }
        }
    }

    function modifiAmigo(){
        require_once("../Modelo/class.sesiones.php");
        iniciarSesion();

        require_once("../Modelo/class.amigos.php");
        $amigos = new Amigo();

        if(obtenerSesion("tipo_us")=="usuario"){
            if($amigos->modificoAmigo($_POST["nombre"],$_POST["apellidos"],$_POST["nacimiento"],obtenerSesion("id_us"))){
                //Si se ha insertado correctamente redirigir al menu de amigos
                vistaBuscAmigos();
            }else{
                //Si no se ha insertado correctamente, mostrar mensaje y redirigir al menu de amigos
                $mnsj="No se ha podido modificar el amigo";
                vistaBuscAmigos($mnsj);  
            }
        }
    }

        function busca(){
            require_once("../Modelo/class.sesiones.php");
            iniciarSesion();

            //Formatear el valor de búsqueda
            $busqueda=ucfirst(trim($_POST["busqueda"]));

            if(!empty($busqueda)){
                if(obtenerSesion("tipo_us")=="usuario"){

                    switch($_POST["busqued"]){
                        case "amigos":
                            require_once("../Modelo/class.amigos.php");
                            $amigos = new Amigo();
                            $resultados=$amigos->buscarAmigos($busqueda,obtenerSesion("id_us"));
                            vistaBuscAmigos($resultados);
                            break;
                        case "juegos":
                            require_once("../Modelo/class.juegos.php");
                            $juegos = new Juego();    
                            $resultados=$juegos->buscarJuego($busqueda,obtenerSesion("id_us"));
                            vistaBuscJuegos($resultados);
                            break;
                        case "prestamos":
                            require_once("../Modelo/class.prestamos.php");
                            $prestamos = new Prestamo();
                            $resultados=$prestamos->buscarPrestamo($busqueda,obtenerSesion("id_us"));
                            vistaBuscPrestamos($resultados);
                            break;
                    }

                }elseif(obtenerSesion("tipo_us")=="admin"){
                    switch($_POST["busqued"]){
                        case "amigos":
                            require_once("../Modelo/class.amigos.php");
                            $amigos = new Amigo();
                            $resultados=$amigos->buscarAmigos($busqueda,obtenerSesion("id_us"));
                            vistaBuscAmigos($resultados);
                            break;
                        case "usuarios":
                            require_once("../Modelo/class.usuarios.php");
                            $usuarios = new Usuario();
                            $resultados=$usuarios->busca($busqueda);
                            vistaBuscUsuarios($resultados);
                            break;
                    }
                }
            }
        }

        function juegos(){
            require_once("../Modelo/class.sesiones.php");
            iniciarSesion();
            require_once("../Modelo/class.juegos.php");
            $juegos = new Juego();
        }


        function ordenar(){
            require_once("../Modelo/class.sesiones.php");
            iniciarSesion();
            
            require_once("../Modelo/class.amigos.php");
            $amigos = new Amigo();

            if(obtenerSesion("tipo_us")=="usuario"){
                if (isset($_POST["orNom"])){
                    ordenAmigo();
                    echo "ordenAMIGO";
                }
                elseif (isset($_POST["orNac"])){
                    ordenFech();
                    echo "ordenfECH";

                }
            }
        }

        // Añado la valoracion a la funcion valorar para que la guarde en la bd
    function valorPrest(int $val){
        require_once("../Modelo/class.sesiones.php");
            iniciarSesion();

        require_once("../Modelo/clas.prestamos.php");
        $prestamos = new Prestamo();
        if($val >= 0 && $val <= 5){
            valorar($val);
        }
    }

    function sumaValoracion(){
        require_once("../Modelo/class.sesiones.php");
            iniciarSesion();

        require_once("../Modelo/class.amigos.php");
        $amigos = new Amigos();

        sacarValoracion();



    }

    function mostrarValida2(){
        require_once("../Modelo/class.sesiones.php");
            iniciarSesion();
        
        require_once("../Modelo/class.amigos.php");
            $amigos = new Amigos();

            if(obtenerSesion("tipo_us")=="usuario"){
                valida2Usu();
                
            }

    }
       