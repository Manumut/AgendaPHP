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

        
        
        //Funcion para sacar todos los amigos  
        public function allAmigos($idUsu) {         
            $sentencia = "SELECT id_am, amigos.nombre, apellidos, nacimiento usuarios.nombre FROM amigos WHERE id_usuario = id_usu";            
            $consulta = $this->con->__get()->prepare($sentencia);           
            $consulta->bind_result($id_amigo, $nombre, $apellidos, $nacimiento, $id_usuario); //id_amigo, nombre, apellidos, nacimiento, id del dueño
            $consulta->execute();

            $datAmigos = [];
            while($consulta->fetch()){
                $datAmigos[$idAm]=[$amNombre,$ape,$nac,$due];
            };
            $consulta->close();
            return $datAmigos;
        }


        //Funcion para sacar los amigos de cada usuario  
        public function amigosUsu($idUsu) {  
            $sentencia = "SELECT amigos.nombre, apellidos, nacimiento, id_am FROM amigos, usuarios WHERE amigos.id_usuario=usuarios.id_usu";       
            $consulta = $this->con->__get()->prepare($sentencia);   
            $consulta->bind_param("i",$idUsu);
            $consulta->bind_result($nombre, $apellidos, $nacimiento, $id_amigo);
            $consulta->execute();

            $datAmigos = [];
            while($consulta->fetch()){
                $datAmigos[$idAm]=[$nombre,$apellidos,$nacimiento];
            };
            $consulta->close();
            return $datAmigos;
        }
        
        // funcion para insetar al amigo
        public function insertarAmigo($nombre,$apellidos,$nacimiento,$id_usuario){
            $sentencia="INSERT INTO amigos (nombre, apellidos, nacimiento, id_usuario) VALUES(?,?,?,?);";
            $consulta=$this->con->__get()->prepare($sentencia);
            $consulta->bind_param("sssi",$nombre,$apellidos,$nacimiento,$id_usuario);
            
            $consulta->execute();

            $inser=false;
            if($consulta->affected_rows==1){
                $inser=true;
            }

            $consulta->close();
            return $inser;
        }

        // funcion para modificar amigo
        public function modificoAmigo($nombre,$apellidos,$nacimiento,$id_amigo){
            $sentencia="UPDATE amigo SET nombre=?, apellidos=?, nacimiento=? WHERE id_am=?;";
            $consulta=$this->con->__get()->prepare($sentencia);
            $consulta->bind_param("sssi",$nombre,$apellidos,$nacimiento,$id_amigo);
            $consulta->execute();
            
            $modifi=false;
            if($consulta->affected_rows==1){
                $modifi=true;
            }

            $consulta->close();
            return $modifi;
        }


        //Modificar el amigo seleccionado siendo admin
        public function modAmiAdmin($id_amigo, $id_usuario, $nombre, $apellidos, $nacimiento) {
            $sentencia = "UPDATE amigos SET id_usuario = ?, nombre = ?, apellidos = ?, nacimiento = ? WHERE id_am = ?";
            $consulta = $this->con->__get()->prepare($sentencia);
            $consulta->bind_param('isssi',$id_usuario, $nombre, $apellidos, $nacimiento, $id_amigo );
            $consulta->execute();
            $consulta->close();
        }



        //Buscador de amigo de usuario normal
        public function buscarAmigos($busqueda, $id_usu) {
            $sentencia = "SELECT id_am, nombre, apellidos, nacimiento FROM amigos WHERE id_usuario = ? AND (nombre LIKE ? OR apellidos LIKE ?)";
            $consulta = $this->con->__get()->prepare($sentencia);
            $likeBusqueda = $busqueda ."%";
            $consulta->bind_param("iss", $id_usu, $busque, $busque);
            $consulta->bind_result($id_amigo, $nombre, $apellidos, $nacimiento);
            $consulta->execute();
        
            $amigos=[];
            while($consulta->fetch()){
                $amigos[$id_amigo]=[$nombre,$apellidos,$nacimiento,$id_usuario];
            }
            $consulta->close();
            return $amigos;
        }
        

    }