<?php
    require_once("../Modelo/class.db.php");

    class Amigo{
        public $con;
        public $id_amigo;
        public $id_usuario;
        public $nombre;
        public $apellidos;
        public $nacimiento;
        public function __construct(){
            $this->con=new db();
            $this->id_amigo;
            $this->id_usuario;
            $this->nombre;
            $this->apellidos;
            $this->nacimiento;   
        }
        //Obtener todos los amigos de la tabla para el admin
        public function obtenerAllAmigos() {  
            $sentencia = "SELECT amigos.nombre, apellidos, nacimiento, usuarios.nombre, id_amigo FROM amigos, usuarios WHERE amigos.id_usuario=usuarios.id_usu";       
            $consulta = $this->con->__get("con")->prepare($sentencia);           
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
        public function obtenerAmigos(int $id_usuario) {         //Funcion para obtener los amigos de cada usuario  
            $sentencia = "SELECT id_am, nombre, apellidos, nacimiento FROM amigos WHERE id_usuario = ?";            
            $consulta = $this->con->__get("con")->prepare($sentencia);           
            $consulta->bind_param("i", $id_usuario);            
            $consulta->bind_result($res4, $res, $res2, $res3); //id_amigo, nombre, apellidos, nacimiento
            $amigos = array();
            $consulta->execute();
            while($consulta->fetch()){
                $fech = strtotime($res3); //paso nacimiento a fecha
                $res3 = date('d-m-Y', $fech); //devuelvo la fecha en formato español
                array_push($amigos, [$res, $res2, $res3, $res4]); // esto quiere decir que el array amigos va a tener un array con el id_amigo, nombre, apellidos y nacimiento
            };
            $consulta->close();
            return $amigos;
        }
        //obtener un amigo en concreto
        public function obtenerPorId($id_amigo) {
            $sentencia = "SELECT nombre, apellidos, nacimiento FROM amigos WHERE id_amigo = ?";
            $consulta = $this->con->__get('con')->prepare($sentencia); 
            $consulta->bind_param('i', $id_amigo); // esto lo que hace es pasar el id del amigo a buscar
            $consulta->execute();
            $resultado = $consulta->get_result();
            $amigo = $resultado->fetch_assoc();//devuelve un array asociativo
            $consulta->close();
            return $amigo;
        }
        //Modificar el amigo seleccionado siendo usuario
        public function actualizar($id_amigo, $nombre, $apellidos, $fechaNacimiento) {
            $sentencia = "UPDATE amigos SET nombre = ?, apellidos = ?, nacimiento = ? WHERE id_amigo = ?";
            $consulta = $this->con->__get('con')->prepare($sentencia);
            $consulta->bind_param('sssi', $nombre, $apellidos, $fechaNacimiento, $id_amigo);
            $consulta->execute();
            $consulta->close();
        }
        //Modificar el amigo seleccionado siendo admin
        public function actualizarAdmin($id_amigo, $id_usuario, $nombre, $apellidos, $fNaci) {
            $sentencia = "UPDATE amigos SET id_usuario = ?, nombre = ?, apellidos = ?, nacimiento = ? WHERE id_amigo = ?";
            $consulta = $this->con->__get('con')->prepare($sentencia);
            $consulta->bind_param('isssi',$id_usuario, $nombre, $apellidos, $fNaci, $id_amigo );
            $consulta->execute();
            $consulta->close();
        }

        //Agregar el amigo nuevo
        public function insertar($id_usuario, $nombre, $apellidos, $nacimiento) {
            $sentencia = "INSERT INTO amigos (id_usuario, nombre, apellidos, nacimiento) VALUES (?, ?, ?, ?)";
            $consulta = $this->con->__get("con")->prepare($sentencia);
            $consulta->bind_param("isss", $id_usuario, $nombre, $apellidos, $nacimiento);
            return $consulta->execute();
        }




// MIRAR ESTO BIEN A FONDO XQ NO ME FIO DE MI


        //Buscador de amigo de usuario normal
        public function buscarAmigos($busqueda, $id_usuario) {
            $sentencia = "SELECT id_amigo, nombre, apellidos, nacimiento 
                    FROM amigos 
                    WHERE id_usuario = ? AND (nombre LIKE ? OR apellidos LIKE ?)";
            $consulta = $this->con->__get("con")->prepare($sentencia);
            $likeBusqueda = "%" . $busqueda . "%";
            $consulta->bind_param("iss", $id_usuario, $likeBusqueda, $likeBusqueda);
            $consulta->execute();
            $consulta->bind_result($id_amigo, $nombre, $apellidos, $nacimiento);
        
            $amigos = array();
            while ($consulta->fetch()) {
                array_push($amigos, [$nombre, $apellidos, $nacimiento, $id_amigo]);
            }
            $consulta->close();
            return $amigos;
        }
        //Buscador de amigo de usuario admin
        public function buscarAmigosAdmin($busqueda) {
            $sentencia = "SELECT id_amigo, nombre, apellidos, nacimiento, nombre_usuario
                    FROM amigos, usuarios 
                    WHERE usuarios.id_usuario=amigos.id_usuario AND (nombre LIKE ? OR apellidos LIKE ?)";
            $consulta = $this->con->__get("con")->prepare($sentencia);
            $likeBusqueda = "%" . $busqueda . "%";
            $consulta->bind_param("ss", $likeBusqueda, $likeBusqueda);
            $consulta->execute();
            $consulta->bind_result($id_amigo, $nombre, $apellidos, $nacimiento, $nombre_usuario);
        
            $amigos = array();
            while ($consulta->fetch()) {
                array_push($amigos, [$nombre, $apellidos, $nacimiento, $nombre_usuario, $id_amigo]);
            }
            $consulta->close();
            return $amigos;
        }
    }