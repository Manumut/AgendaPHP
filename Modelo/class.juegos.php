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
            $consulta=$this->con->__get()->prepare($sentencia);
            $consulta->bind_param("i",$id_usu);
            $consulta->bind_result($id_jue, $nombre, $url_img, $plataforma, $lanzamiento);
            $consulta->execute();

            $juegos=[];
            while($consulta->fetch()){
                $juegos[$id]=[$img,$titulo,$plataforma,$lanzamiento];
            }
            $consulta->close();
            return $juegos;
        }

        //Obtener el juego en especifico por el id
        public function juegoId($id_juego) {
            $sentencia = "SELECT url_img, nombre, plataforma, lanzamiento FROM juegos WHERE id_jue = ?";
            $consulta = $this->con->__get()->prepare($sentencia);
            $consulta->bind_param("i", $id_juego);
            $consulta->execute();
            $resultado = $consulta->get_result();
            $juego = $resultado->fetch_assoc();
            $consulta->close();
            return $juego;
        }

        //Insertar un nuevo juego para el usuario
        public function inserJuego($id_usu, $titulo, $plataforma, $lanzamiento, $url_img){
            $sentencia = "INSERT INTO juegos (dueño, url_img, nombre, plataforma, lanzamiento) VALUES (?, ?, ?, ?,?)";
            $consulta = $this->con->__get()->prepare($sentencia);
            $consulta->bind_param("issss", $id_usu, $titulo, $plataforma, $lanzamiento, $url_img);
            return $consulta->execute();
        }


        
        //Modificar el juego seleccionado
        public function actualizar($id_juego, $titulo, $plataforma, $anio_lanzamiento, $foto) {
            $sentencia = "UPDATE juegos SET titulo = ?, plataforma = ?, anio_lanzamiento = ?, foto = ? WHERE id_juego = ?";
            $consulta = $this->con->__get()->prepare($sentencia);
            $consulta->bind_param("ssssi", $titulo, $plataforma, $anio_lanzamiento, $foto, $id_juego);
            $resultado = $consulta->execute();
            $consulta->close();
            return $resultado;
        }








        //Buscador de juegos del usuario
        public function buscarJuegos($busqueda, $id_usuario) {
            $sentencia = "SELECT id_juego, titulo, plataforma, anio_lanzamiento, foto 
                    FROM juegos 
                    WHERE id_usuario = ? AND (titulo LIKE ? OR plataforma LIKE ?)";
            $consulta = $this->con->__get()->prepare($sentencia);
            $likeBusqueda = "%" . $busqueda . "%";
            $consulta->bind_param("iss", $id_usuario, $likeBusqueda, $likeBusqueda);
            $consulta->execute();
            $consulta->bind_result($id_juego, $titulo, $plataforma, $anio_lanzamiento, $foto);
        
            $juegos = array();
            while ($consulta->fetch()) {
                array_push($juegos, [$titulo, $plataforma, $anio_lanzamiento, $foto, $id_juego]);
            }
            $consulta->close();
            return $juegos;
        }
    }
?>