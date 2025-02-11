<?php
    require_once("class.bd.php");
    
    class Prestamo {
        public $conn;
    
        public function __construct() {
            $this->conn = new bd();
        }
        //Obtener préstamos por id_usuario
        public function obtenerPrestamos(int $id_usuario) {
            $sentencia ="SELECT amigos.nombre, juegos.titulo, juegos.foto, fecha_prestamo, devuelto, id_prestamo, prestamos.id_amigo, prestamos.id_juego FROM amigos, juegos, prestamos WHERE prestamos.id_amigo=amigos.id_amigo AND prestamos.id_juego=juegos.id_juego AND prestamos.id_usuario=?;";
            $consulta = $this->conn->__get("conn")->prepare($sentencia);
            $consulta->bind_param("i", $id_usuario);
            $consulta->bind_result($res, $res2, $res3, $res4, $res5, $res6, $res7, $res8);
            $prestamos = array();
            $consulta->execute();
            while($consulta->fetch()){
                $fech = strtotime($res4);
                $res4 = date('d-m-Y', $fech);
                array_push($prestamos, [$res, $res2, $res3, $res4, $res5, $res6, $res7, $res8]);
            };
            $consulta->close();
            return $prestamos;
        }
        //obtener un prestamo por id
        public function obtenerPrestamo(int $id_prestamo){
            $sentencia ="SELECT amigos.nombre, juegos.titulo, juegos.foto, fecha_prestamo, devuelto, id_prestamo, prestamos.id_amigo, prestamos.id_juego FROM amigos, juegos, prestamos WHERE prestamos.id_amigo=amigos.id_amigo AND prestamos.id_juego=juegos.id_juego AND prestamos.id_prestamo=?;";
            $consulta = $this->conn->__get("conn")->prepare($sentencia);
            $consulta->bind_param('i', $id_prestamo);
            $consulta->execute();
            $resultado = $consulta->get_result();
            $prestamo = $resultado->fetch_assoc();
            $consulta->close();
            return $prestamo;
        }
        //Insertar un nuevo prestamo
        public function insertarPrestamo($id_usuario, $id_amigo, $id_juego, $fecha_prestamo, $devuelto) {
            $sentencia = "INSERT INTO prestamos (id_usuario, id_amigo, id_juego, fecha_prestamo, devuelto) VALUES (?, ?, ?, ?, ?)";
            $consulta = $this->conn->__get('conn')->prepare($sentencia);
            $consulta->bind_param("iiisi", $id_usuario, $id_amigo, $id_juego, $fecha_prestamo, $devuelto);
            return $consulta->execute();
        }
        //Modificar el prestamo seleccionado
        public function actualizarPrestamo($id_prestamo, $id_usuario, $id_amigo, $id_juego, $fecha_prestamo, $devuelto) {
            $sentencia = "UPDATE prestamos SET id_usuario = ?, id_amigo = ?, id_juego = ?, fecha_prestamo = ?, devuelto = ? WHERE id_prestamo = ?";
            $consulta = $this->conn->__get('conn')->prepare($sentencia);
            $consulta->bind_param("iiisii", $id_usuario, $id_amigo, $id_juego, $fecha_prestamo, $devuelto, $id_prestamo);
            $resultado=$consulta->execute();
            $consulta->close();
            return $resultado;
        }
        //Cambiador del estado en la base de datos sobre el prestamo seleccionado
        public function devolver($id_prestamo, $devuelto){
            $sentencia = "UPDATE prestamos SET devuelto = ? WHERE id_prestamo = ?";
            $consulta = $this->conn->__get('conn')->prepare($sentencia);
            $consulta->bind_param("ii", $devuelto, $id_prestamo);
            $resultado=$consulta->execute();
            $consulta->close();
            return $resultado;
        }
        //Buscador de prestamos segun el nombre o la plataforma
        public function buscarPrestamos($busqueda, $id_usuario) {
            $sentencia = "SELECT id_prestamo, amigos.nombre, juegos.titulo, fecha_prestamo, foto, devuelto 
                          FROM prestamos, amigos, juegos
                          WHERE prestamos.id_amigo=amigos.id_amigo AND prestamos.id_juego=juegos.id_juego AND prestamos.id_usuario = ? AND (nombre LIKE ? OR titulo LIKE ?)";
            
            $consulta = $this->conn->__get("conn")->prepare($sentencia);
            $likeBusqueda = "%" . $busqueda . "%";
            $consulta->bind_param("iss", $id_usuario, $likeBusqueda, $likeBusqueda);
            $consulta->execute();
            $consulta->bind_result($id_prestamo, $amigo, $titulo, $fecha_prestamo, $foto, $devuelto);
            $prestamos = array();
            while ($consulta->fetch()) {
                $fech = strtotime($fecha_prestamo);
                $fecha_prestamo = date('d-m-Y', $fech);
                array_push($prestamos, [$amigo, $titulo, $foto, $fecha_prestamo, $devuelto, $id_prestamo]);
            }
            $consulta->close();
            return $prestamos;
        }
    }
            