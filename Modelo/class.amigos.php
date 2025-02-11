<?php
    require_once("./class.bd.php");

    class Amigo{
        public $conn;
        public $id_amigo;
        public $id_usuario;
        public $nombre;
        public $apellidos;
        public $fecha_nacimiento;
        public function __construct(){
            $this->conn=new bd();
            $this->id_amigo;
            $this->id_usuario;
            $this->nombre;
            $this->apellidos;
            $this->fecha_nacimiento;   
        }
        //Obtener todos los amigos de la tabla 
        public function obtenerAllAmigos() {  
            $sentencia = "SELECT nombre, apellidos, fecha_nacimiento, nombre_usuario, id_amigo FROM amigos, usuarios WHERE amigos.id_usuario=usuarios.id_usuario";       
            $consulta = $this->conn->__get("conn")->prepare($sentencia);           
            $consulta->bind_result($res, $res2, $res3, $res4, $res5);
            $amigos = array();
            $consulta->execute();
            while($consulta->fetch()){
                $fech = strtotime($res3);
                $res3 = date('d-m-Y', $fech);
                array_push($amigos, [$res, $res2, $res3, $res4, $res5]);
            };
            $consulta->close();
            return $amigos;
        }
        //Obtener amigos por cada usuario
        public function obtenerAmigos(int $id_usuario) {           
            $sentencia = "SELECT id_amigo, nombre, apellidos, fecha_nacimiento FROM amigos WHERE id_usuario = ?";            
            $consulta = $this->conn->__get("conn")->prepare($sentencia);           
            $consulta->bind_param("i", $id_usuario);            
            $consulta->bind_result($res4, $res, $res2, $res3);
            $amigos = array();
            $consulta->execute();
            while($consulta->fetch()){
                $fech = strtotime($res3);
                $res3 = date('d-m-Y', $fech);
                array_push($amigos, [$res, $res2, $res3, $res4]);
            };
            $consulta->close();
            return $amigos;
        }
        //obtener un amigo en concreto
        public function obtenerPorId($id_amigo) {
            $sentencia = "SELECT nombre, apellidos, fecha_nacimiento FROM amigos WHERE id_amigo = ?";
            $consulta = $this->conn->__get('conn')->prepare($sentencia); // Usamos la conexión desde la clase `bd`
            $consulta->bind_param('i', $id_amigo);
            $consulta->execute();
            $resultado = $consulta->get_result();
            $amigo = $resultado->fetch_assoc();
            $consulta->close();
            return $amigo;
        }
        //Modificar el amigo seleccionado siendo usuario
        public function actualizar($id_amigo, $nombre, $apellidos, $fechaNacimiento) {
            $sentencia = "UPDATE amigos SET nombre = ?, apellidos = ?, fecha_nacimiento = ? WHERE id_amigo = ?";
            $consulta = $this->conn->__get('conn')->prepare($sentencia);
            $consulta->bind_param('sssi', $nombre, $apellidos, $fechaNacimiento, $id_amigo);
            $consulta->execute();
            $consulta->close();
        }
        //Modificar el amigo seleccionado siendo admin
        public function actualizarAdmin($id_amigo, $id_usuario, $nombre, $apellidos, $fechaNacimiento) {
            $sentencia = "UPDATE amigos SET id_usuario = ?, nombre = ?, apellidos = ?, fecha_nacimiento = ? WHERE id_amigo = ?";
            $consulta = $this->conn->__get('conn')->prepare($sentencia);
            $consulta->bind_param('isssi',$id_usuario, $nombre, $apellidos, $fechaNacimiento, $id_amigo );
            $consulta->execute();
            $consulta->close();
        }
        //Agregar el amigo nuevo
        public function insertar($id_usuario, $nombre, $apellidos, $fecha_nacimiento) {
            $sentencia = "INSERT INTO amigos (id_usuario, nombre, apellidos, fecha_nacimiento) VALUES (?, ?, ?, ?)";
            $consulta = $this->conn->__get("conn")->prepare($sentencia);
            $consulta->bind_param("isss", $id_usuario, $nombre, $apellidos, $fecha_nacimiento);
            return $consulta->execute();
        }
        //Buscador de amigo de usuario normal
        public function buscarAmigos($busqueda, $id_usuario) {
            $sentencia = "SELECT id_amigo, nombre, apellidos, fecha_nacimiento 
                    FROM amigos 
                    WHERE id_usuario = ? AND (nombre LIKE ? OR apellidos LIKE ?)";
            $consulta = $this->conn->__get("conn")->prepare($sentencia);
            $likeBusqueda = "%" . $busqueda . "%";
            $consulta->bind_param("iss", $id_usuario, $likeBusqueda, $likeBusqueda);
            $consulta->execute();
            $consulta->bind_result($id_amigo, $nombre, $apellidos, $fecha_nacimiento);
        
            $amigos = array();
            while ($consulta->fetch()) {
                array_push($amigos, [$nombre, $apellidos, $fecha_nacimiento, $id_amigo]);
            }
            $consulta->close();
            return $amigos;
        }
        //Buscador de amigo de usuario admin
        public function buscarAmigosAdmin($busqueda) {
            $sentencia = "SELECT id_amigo, nombre, apellidos, fecha_nacimiento, nombre_usuario
                    FROM amigos, usuarios 
                    WHERE usuarios.id_usuario=amigos.id_usuario AND (nombre LIKE ? OR apellidos LIKE ?)";
            $consulta = $this->conn->__get("conn")->prepare($sentencia);
            $likeBusqueda = "%" . $busqueda . "%";
            $consulta->bind_param("ss", $likeBusqueda, $likeBusqueda);
            $consulta->execute();
            $consulta->bind_result($id_amigo, $nombre, $apellidos, $fecha_nacimiento, $nombre_usuario);
        
            $amigos = array();
            while ($consulta->fetch()) {
                array_push($amigos, [$nombre, $apellidos, $fecha_nacimiento, $nombre_usuario, $id_amigo]);
            }
            $consulta->close();
            return $amigos;
        }
    }