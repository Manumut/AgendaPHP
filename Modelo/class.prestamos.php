<?php
    require_once("../Modelo/class.db.php");
    
    class Prestamo {
        public $con;
        private $id_pres;
        private $usuario;
        private $amigo;
        private $juego;
        private $fecha;
        private $devuelto;
        private $valoracion;

        public function __construct() {
            $this->con = new db();
            $this->id_pres;
            $this->usuario;
            $this->amigo;
            $this->juego;
            $this->fecha;
            $this->devuelto;
            $this->valoracion;
        }

        //Obtener prestamos por el id del usu
        public function obtenerPrest($idUsu){
            $sentencia="SELECT id_pres, amigos.nombre, juegos.nombre, url_img, prestamos.fecha, devuelto FROM prestamos, amigos, juegos WHERE prestamos.juego=id_jue AND prestamos.amigo=amigos.id_am AND prestamos.usuario=?;";
            $consulta=$this->con->getConexion()->prepare($sentencia);
            $consulta->bind_param("i",$idUsu);
            $consulta->bind_result($id_pres,$amigo,$fecha,$devuelto,$titJuego,$imgJuego);
            $consulta->execute();

            $datosPrest=[];
            while($consulta->fetch()){
                $datosPrest[$id_pres]=[$amigo,$fecha,$devuelto,$titJuego,$imgJuego];
            }
            $consulta->close();
            return $datosPrest;
        }
        
        //Inserccion de prestamo
        public function insertarPrestamo($usuario, $amigo, $juego, $fecha) {
            $sentencia = "INSERT INTO prestamos (usuario, amigo, juego, fecha) VALUES (?, ?, ?, ?)";
            $consulta = $this->con->getConexion()->prepare($sentencia);
            $consulta->bind_param("iiis", $usuario, $amigo, $juego, $fecha);
            return $consulta->execute();
        }
        
        //buscador de prestamos por el nombre del juego o nimbre del amigo
        public function buscarPrestamos($busqueda, $id_usuario) {
            $sentencia = "SELECT id_pres, amigos.nombre, juegos.nombre, prestamos.fecha, url_img, devuelto FROM prestamos, amigos, juegos WHERE prestamos.juego=id_jue AND prestamos.amigo=amigos.id_am AND prestamos.id_usuario = ? AND (juegos.nombre LIKE ? OR  amigos.nombre LIKE ?)";
            
            $consulta = $this->con->getConexion()->prepare($sentencia);
            $busque =$busqueda. "%";
            $consulta->bind_param("is", $usuario, $busque );
            $consulta->bind_result($id_pres, $amigo, $titulo, $fecha_prestamo, $foto, $devuelto);
            $consulta->execute();
            $busc=[];
            while($consulta->fetch()){
                $busc[$id_prestamo]=[ $amigo, $titulo, $fecha_prestamo, $foto, $devuelto];
            }

            $consulta->close();
            return $busc;
        }

        // Una fucnion para updatear la valoracion a cada prestamo
        public function valorar(int $val){
            $sentencia = "UPDATE prestamos SET valoracion = ? ;";
            $consulta = $this->con->getConexion()->prepare($sentencia);
            $consulta->bind_param('i',$valoracion);
            $consulta->execute();
            $consulta->close();
        }

          

        
        

     
    }
            