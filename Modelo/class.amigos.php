<?php
    require_once("../Modelo/class.db.php");

    class Amigo{
        public $con;
        public $id_amigo;
        public $id_usuario;
        public $nombre;
        public $apellidos;
        public $nacimiento;
        public $puntuacion;
        
        public function __construct(){
            $this->con=new db();
            $this->id_amigo;
            $this->id_usuario;
            $this->nombre;
            $this->apellidos;
            $this->nacimiento;   
            $this->puntuacion;   

        }

        
        
        //Funcion para sacar todos los amigos  
        public function allAmigos($idUsu) {         
            $sentencia = "SELECT id_am, amigos.nombre, apellidos, nacimiento usuarios.nombre FROM amigos WHERE id_usuario = id_usu";            
            $consulta = $this->con->getConexion()->prepare($sentencia);           
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
            $consulta = $this->con->getConexion()->prepare($sentencia);   
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
            $consulta=$this->con->getConexion()->prepare($sentencia);
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
            $consulta=$this->con->getConexion()->prepare($sentencia);
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
            $consulta = $this->con->getConexion()->prepare($sentencia);
            $consulta->bind_param('isssi',$id_usuario, $nombre, $apellidos, $nacimiento, $id_amigo );
            $consulta->execute();
            $consulta->close();
        }



        //Buscador de amigo por nombre o apellido
        public function buscarAmigos($busqueda, $id_usu) {
            $sentencia = "SELECT id_am, nombre, apellidos, nacimiento FROM amigos WHERE id_usuario = ? AND (nombre LIKE ? OR apellidos LIKE ?)";
            $consulta = $this->con->getConexion()->prepare($sentencia);
            $busque = $busqueda ."%";
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



        //funcion para para sacar los nombres de los amigos por orden alfabetico
        public function ordenAmigo(){
            $sentencia ="SELECT nombre FROM amigos ORDER BY nombre;"; //esto devuelve los nombres ordenados por orden alfabetico de nombres
            $consulta = $this->con->getConexion()->prepare($sentencia);
            $consulta->bind_param('s',$nombre );
            $consulta->bind_result($nombre);
            $consulta->execute();
            echo "ordenAMIGO";
            $consulta->close();
        }
        

        //funcion para para sacar las fechas de los amigos por orden ascendente
        public function ordenFech(){
            $sentencia ="SELECT nacimiento FROM amigos ORDER BY nacimiento ASC;"; //esto devuelve las fechas ordenados por orden ascendente
            $consulta = $this->con->getConexion()->prepare($sentencia);
            $consulta->bind_param('s',$nacimiento );
            $consulta->bind_result($nacimiento);
            $consulta->execute();
            echo "ordenfECH";
            $consulta->close();
        }


         // Tengo q sacar todas las valoraciones, q salen en un array, y en otra funcion sacar la cantidad de valoraciones que hay y asi poder sacar la media luego, aunq ns como

        public function sacarValoracion(){
            $sentencia = "SELECT avg(valoracion), id_pres, amigo, usuario FROM prestamos, amigos WHERE id_am = prestamos.amigo AND valoracion != null AND devuelto = 1;";

            $consulta = $this->con->getConexion()->prepare($sentencia);
            $consulta->bind_param("i", $usuario );
            $consulta->bind_result($valoracion);
            $consulta->execute();

            $med=[];
            while($consulta->fetch()){
                $med[$id_pres]=[$valoracion];
            }

            $consulta->close();
            return $med;
        }

        public function valida2Usu(){
            $sentencia = "SELECT verificado FROM amigos WHERE verificado = 1";
            $consulta=$this->con->getConection()->prepare($sentencia);
            $consulta->bind_result($verificado);
            $consulta->execute();

            $usuarios=[];
            while($consulta->fetch()){
                $usuarios[$id_amigo]=[$verificado];
            }

            $consulta->close();
            return $usuarios;
        }
        
    }