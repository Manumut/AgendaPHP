<?php
    require_once("../Modelo/class.db.php");
    class Usuario{
        private $con;
        public $id_usu;
        public $nombre;
        public $pasword;
        public $tipo;
        
        public function __construct(){
            $this->con=new db();
            $this->id_usu;
            $this->nombre;
            $this->pasword;
            $this->tipo;
        }
        
        // Para tener el id del usuario
        public function obtenerId($nombre_usuario){
            $sentencia="SELECT id_usu FROM usuarios WHERE nombre=? and pasword=?;";
            $consulta=$this->con->getConexion()->prepare($sentencia);
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



        //tipo de usuario, es decir, admin o usuario normal
        public function tipoUsu($nom,$psw){
            $sentencia="SELECT tipo FROM usuario WHERE nombre=? AND contrasenia=?;";
            $consulta=$this->con->getConexion()->prepare($sentencia);
            $consulta->bind_param("ss",$nom,$psw);
            $consulta->bind_result($tipo);
            $consulta->execute();
            $consulta->fetch();
            $consulta->close();
            return $tipo;
        }


        //se busca la contraseña para saber si es la correcta
        public function contraseniaCorrec($nom,$contra){
            $sentencia="SELECT count(contrasenia) FROM usuario WHERE nombre=? AND contrasenia=?;";
            $consulta=$this->conn->getConexion()->prepare($sentencia);
            $consulta->bind_param("ss",$nom,$contra);
            $consulta->bind_result($count);

            $consulta->execute();
            $consulta->fetch();

            // compruebo q encuentre algo y si encuentra una es porque esta bien
            $correcto=false;
            if($count==1){
                $correcto=true;
            }

            $consulta->close();
            return $correcto;  
        }


        //revisa si ese nombre esta en la base de datos
        public function nombreCorrec($nom){
            $sentencia="SELECT count(id_usu) FROM usuarios WHERE nombre=?;";
            $consulta=$this->conn->getConexion()->prepare($sentencia);
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
        public function modifica($nombre, $pasword, $id_usu) {
            $sentencia = "UPDATE usuarios SET nombre = ?, pasword = ? WHERE id_usu = ?;";
            $consulta = $this->con->getConexion()->prepare($sentencia);
            $consulta->bind_param("ssi", $nombre, $pasword, $id_usu);
            return $consulta->execute();
        }



        //Seleccionar los usuarios para el buscador
        public function busca($busqueda) {
            $sentencia = "SELECT id_usu, nombre, pasword FROM usuarios WHERE nombre LIKE ?";
            $consulta = $this->con->getConexion()->prepare($sentencia);
            $busque = $busqueda . "%";
            $consulta->bind_param("s", $busque );
            $consulta->execute();
            $consulta->bind_result($id_usu, $nombre, $pasword);
        
            $datos=[];
            while($consulta->fetch()){
                $datos[$id_usu]=[$nombre, $pasword];
            }

            $consulta->close();
            return $datos;
        }
    }
?>