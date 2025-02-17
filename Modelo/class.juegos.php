<?php
    require_once("../Modelo/class.db.php");
    class Juego{
        public $con;
        public $id_jue;
        public $dueño;
        public $url_img;
        public $nombre;
        public $plataforma;
        public $lanzamiento;

        public function __construct(){
            $this->con=new db();
            $this->id_jue;
            $this->dueño;
            $this->url_img;
            $this->nombre;
            $this->plataforma;
            $this->lanzamiento;   
        }

        
        //Sacar los juegos segun el usuario
        public function obtenerJuegos($id_usu){
            $sentencia ="SELECT id_jue, nombre, url_img, plataforma, lanzamiento FROM juegos WHERE dueño= ?;";
            $consulta=$this->con->getConexion()->prepare($sentencia);
            $consulta->bind_param("i",$id_usu);
            $consulta->bind_result($id_jue, $nombre, $url_img, $plataforma, $lanzamiento);
            $consulta->execute();

            $juegos=[];
            while($consulta->fetch()){
                $juegos[$id]=[$img,$nombre,$plataforma,$lanzamiento];
            }
            $consulta->close();
            return $juegos;
        }

        //Obtener el juego en especifico por el id
        public function juegoId($id_juego) {
            $sentencia = "SELECT url_img, nombre, plataforma, lanzamiento FROM juegos WHERE id_jue = ?";
            $consulta = $this->con->getConexion()->prepare($sentencia);
            $consulta->bind_param("i", $id_juego);
            $consulta->execute();
            $resultado = $consulta->get_result();
            $juego = $resultado->fetch_assoc();
            $consulta->close();
            return $juego;
        }

        //Insertar un nuevo juego para el usuario
        public function inserJuego($id_usu, $nombre, $plataforma, $lanzamiento, $url_img){
            $sentencia = "INSERT INTO juegos (dueño, url_img, nombre, plataforma, lanzamiento) VALUES (?, ?, ?, ?,?)";
            $consulta = $this->con->getConexion()->prepare($sentencia);
            $consulta->bind_param("issss", $id_usu, $nombre, $plataforma, $lanzamiento, $url_img);
            return $consulta->execute();
        }


        
        //Modificar el juego seleccionado
        public function modiJuego($id_jue, $url_img, $nombre, $plataforma, $lanzamiento ) {
            $sentencia = "UPDATE juegos SET url_img = ? nombre = ?, plataforma = ?, lanzamiento = ?,  WHERE id_juego = ?";
            $consulta = $this->con->getConexion()->prepare($sentencia);
            $consulta->bind_param("issss", $id_jue, $url_img, $nombre, $plataforma, $lanzamiento);
            $resultado = $consulta->execute();
            $consulta->close();
            return $resultado;
        }


        // Funcion para buscar juego por nombre del juego o plataforma
        public function buscarJuego($busqueda, $idUsu){
            $sentencia="SELECT id_jue, url_img, nombre, plataforma, lanzamiento FROM juegos WHERE (nombre LIKE ? OR plataforma LIKE ?) AND dueño=?;";
            $consulta=$this->conn->getConexion()->prepare($sentencia);
            $busque= $busqueda . "%";
            $consulta->bind_param("iss", $id, $busque, $busque);
            $consulta->bind_result($id_jue, $url_img, $nombre, $plataforma, $lanzamiento);
            $consulta->execute();

            $buscJu=[];
            while($consulta->fetch()){
                $buscJu[$id_jue]=[$url_img, $nombre, $plataforma, $lanzamiento];
            }

            $consulta->close();
            return $buscJu;
        }
    }
?>