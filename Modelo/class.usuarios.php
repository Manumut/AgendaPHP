<?php
    require_once("../Modelo/class.db.php");
    class Usuario{
        private $con;
        public $id_usu;
        public $nombre;
        public $pasword;
        public $tipo;
        public function __construct(){
            $this->con=new bd();
            $this->id_usu;
            $this->nombre;
            $this->pasword;
            $this->tipo;
        }
        // Método para iniciar sesión verificando usuario y contraseña en la base de datos
        // public function iniciar_sesion($user, $cont) {
        //     $num = 0;
        //     $sent = "SELECT count(*) FROM usuarios WHERE nombre = ? AND pasword = ?";
        //     $consulta = $this->con->getConexion()->prepare($sent);
        //     $consulta->bind_param("ss", $user, $cont);
        //     $consulta->execute();
        //     $consulta->bind_result($num);
        //     $consulta->fetch();
        //     echo "hola3";

        //     $inicio = ($num == 1) ? true : false; // Si encuentra 1 coincidencia, inicia sesión
        //     $consulta->close(); 
        //     return $inicio;
        // }


        public function obtenerId($nombre_usuario){
            $sentencia="SELECT id_usu FROM usuarios WHERE nombre=? and pasword=?;";
            $consulta=$this->con->__get()->prepare($sentencia);
            $consulta->bind_param("s",$nombre_usuario);
            $consulta->bind_result($id_usuario);
            $consulta->execute();
            $consulta->fetch();
            $consulta->close();
            return $id_usuario;
        }

        // obtener todos los usuarios 
        public function obtenerUsuarios(){
            $sentencia="SELECT id_usu,nombre,pasword FROM usuarios;";
            $consulta=$this->conn->getConection()->prepare($sentencia);
            $consulta->bind_result($id,$nombre,$contrasenia);
            $consulta->execute();

            $usuarios=[];
            while($consulta->fetch()){
                $usuarios[$id]=[$nombre,$contrasenia];
            }

            $consulta->close();
            return $usuarios;
        }



        public function tipoUsu($nom,$psw){
            //Comprueba de q tipo es el usuario
            $sentencia="SELECT tipo FROM usuario WHERE nombre=? AND contrasenia=?;";
            $consulta=$this->con->__get()->prepare($sentencia);
            $consulta->bind_param("ss",$nom,$psw);
            $consulta->bind_result($tipo);
            $consulta->execute();
            $consulta->fetch();
            $consulta->close();
            return $tipo;
        }


        public function contraseniaCorrec($nom,$contra){
            //Comprobar que la contraseña es la correcta
            $sentencia="SELECT count(contrasenia) FROM usuario WHERE nombre=? AND contrasenia=?;";
            $consulta=$this->conn->__get()->prepare($sentencia);
            $consulta->bind_param("ss",$nom,$contra);
            $consulta->bind_result($count);

            $consulta->execute();
            $consulta->fetch();

            $correcto=false;
            // si encuentra 1 coincidencia
            if($count==1){
                $correcto=true;
            }

            $consulta->close();
            return $correcto;  
        }


        public function nombreCorrec($nom){
            //Comprueba si el nombre de usuario ya existe en la bd
            $sentencia="SELECT count(id_usu) FROM usuarios WHERE nombre=?;";
            $consulta=$this->conn->__get()->prepare($sentencia);
            $consulta->bind_param("s",$nom);
            $consulta->bind_result($count);
            $consulta->execute();

            $consulta->fetch();
            $existe=false;
            
            if($count==1){
                $existe=true;
            }

            $consulta->close();
            return $existe;           
        }

        
        //obtener el id del usuario
        //Insertar usuario
        public function insertarUsu($nombre, $pasword) {
            $sentencia = "INSERT INTO usuarios (nombre, pasword) VALUES (?, ?)";
            $consulta = $this->con->getConexion()->prepare($sentencia);
            $consulta->bind_param("ss", $nombre, $pasword);
            $consulta->execute();
            $consulta->close();
            return $insertado;
        }






        
        //Modificar los usarios
        public function actualizar($nombre, $pasword, $id_usu) {
            $sentencia = "UPDATE usuarios SET nombre = ?, pasword = ? WHERE id_usu = ?";
            $consulta = $this->con->getConexion()->prepare($sentencia);
            $consulta->bind_param('ssi', $nombre, $pasword, $id_usu);
            return $consulta->execute();
        }



        //Seleccionar los usuarios para el buscador
        public function buscarUsuarios($busqueda) {
            $sentencia = "SELECT id_usu, nombre, pasword 
                    FROM usuarios 
                    WHERE nombre LIKE ? OR pasword LIKE ?";
            $consulta = $this->con->getConexion()->prepare($sentencia);
            $likeBusqueda = "%" . $busqueda . "%";
            $consulta->bind_param("ss", $likeBusqueda, $likeBusqueda);
            $consulta->execute();
            $consulta->bind_result($id_usu, $nombre, $pasword);
        
            $usuarios = array();
            while ($consulta->fetch()) {
                array_push($usuarios, [$id_usu, $nombre, $pasword]);
            }
            $consulta->close();
            return $usuarios;
        }
    }
?>