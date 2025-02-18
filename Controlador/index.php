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
    
        function guardaImg(){
            require_once("../Modelo/class.sesiones.php");
            iniciarSesion();
            
            //PARA LA FOTO, crear carpeta con el nombre del usuario si todavía no existe y meter la imagen, luego coger esa ruta para meterla en la bd
        require_once("../Modelo/cookies_sesiones.php");
        start_session();

        
        $ruta="../img/".$_SESSION["usu"]."/";
        if(!file_exists($ruta)){
            mkdir($ruta,0777,true); //El tercer parámetro "true" permite crear directorios recursivamente, es decir, se crea tanto img cómo la carpeta con el nombre del usuario
        }

        $nomOrig=$_FILES["img"]["name"]; //El nombre original de la imagen

        //COMO NO HAY QUE RENOMBRAR EL ARCHIVO, LO COMENTADO NO HACE FALTA, EN CASO DE QUE HUBIERA QUE RENOMBRARLO, SE HARÍA LO SIGUIENTE:
        //Si el nuevo nombre no tiene la extensión, hay que añadirsela para que el archivo se pueda ver correctamente
        // $extension;
        // if(!preg_match("'^[a-zA-Z0-9]+\.[a-z]+$'",$valorInput)){//Si el nuevo nombre no va seguido de . y la extensión, se le añade la extensión del nombre original
        //     //Se concatena el nombre nuevo que se le va a poner a la imagen con la extensión del nombre original

        //     $pos = strrpos($nomOrig, '.'); // Encuentra la posición del último punto dentro del nombre original
        //     $extension=substr($nomOrig,$pos);//substr devuelve una parte del string a partir de una posición, en este caso devuelve una cadena a partir de la posición del . en el nombre original
        //     $valorInput=$valorInput.$extension;//Se concatena el nuevo nombre con la extensión
        // }

        $origen=$_FILES["img"]["tmp_name"];
        $destino=$ruta.$nomOrig; //Se concatena la ruta donde queremos guardar la imagen con el nuevo nombre (En este caso es el nombre original, no uno nuevo)

        //Se mueve la imagen a la carpeta
        move_uploaded_file($origen,$destino);

        return $destino;
        }