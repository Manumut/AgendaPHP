<?php
    require_once("../Modelo/class.db.php");
    class Usuario{
        private $con;
        public $id_usuario;
        public $nombre_usuario;
        public $password;
        public $tipo;
        public function __construct(){
            $this->con=new bd();
            $this->id_usuario;
            $this->nombre_usuario;
            $this->contrasena;
            $this->tipo;
        }
        // Método para iniciar sesión verificando usuario y contraseña en la base de datos
        public function iniciar_sesion($user, $cont) {
            $num = 0;
            $sent = "SELECT COUNT(*) FROM usuarios WHERE nombre_usuario = ? AND contrasena = ?";
            $consulta = $this->db->getCon()->prepare($sent);
            $consulta->bind_param("ss", $user, $cont);
            $consulta->bind_result($num);
            $consulta->execute();
            $consulta->fetch(); 
            $inicio = ($num == 1) ? true : false; // Si encuentra 1 coincidencia, inicia sesión
            $consulta->close(); 
            return $inicio;
        }


        //Obtener todos los usuarios de la base datos
        public function obtenerUsuarios(){
            $sentencia ="SELECT id_usuario, nombre_usuario, contrasena, tipo FROM usuarios";
            $consulta=$this->con->__get("con")->prepare($sentencia);
            $consulta->bind_result($res, $res2, $res3, $res4);
            $usuarios = array();
            $consulta->execute();
            while($consulta->fetch()){
                array_push($usuarios, [$res, $res2, $res3, $res4]);
            };
            $consulta->close();
            return $usuarios;
        }
        //Obtener el tipo de usuario 
        public function obtenerTipoUsu($id_usuario){
            $sentencia ="SELECT tipo FROM usuarios WHERE id_usuario=?;";
            $consulta=$this->con->__get("con")->prepare($sentencia);
            $consulta->bind_param("s",$id_usuario);
            $consulta->bind_result($tip);
            $consulta->execute();
            $consulta->fetch();
            return $tip;
        }
        //obtener el id del usuario
        public function obtenerId($nombre_usuario){
            $sentencia="SELECT id_usuario FROM usuarios WHERE nombre_usuario=?;";
            $consulta=$this->con->__get("con")->prepare($sentencia);
            $consulta->bind_param("s",$nombre_usuario);
            $consulta->bind_result($id_usuario);
            $consulta->execute();
            $consulta->fetch();
            return $id_usuario;
        }
        //Insertar usuario
        public function insertar($nombre_usuario, $contrasena) {
            $sentencia = "INSERT INTO usuarios (nombre_usuario, contrasena) VALUES (?, ?)";
            $consulta = $this->con->__get("con")->prepare($sentencia);
            $consulta->bind_param("ss", $nombre_usuario, $contrasena);
            return $consulta->execute();
        }
        //Obtener los datos del usuarios
        public function obtenerPorId($id_usuario) {
            $sentencia = "SELECT nombre_usuario, contrasena FROM usuarios WHERE id_usuario = ?";
            $consulta = $this->con->__get('con')->prepare($sentencia); // Usamos la conexión desde la clase `bd`
            $consulta->bind_param('i', $id_usuario);
            $consulta->execute();
            $resultado = $consulta->get_result();
            $usuario = $resultado->fetch_assoc();
            $consulta->close();
            return $usuario;
        }
        //Modificar los usarios
        public function actualizar($nombre_usuario, $contrasena, $id_usuario) {
            $sentencia = "UPDATE usuarios SET nombre_usuario = ?, contrasena = ? WHERE id_usuario = ?";
            $consulta = $this->con->__get('con')->prepare($sentencia);
            $consulta->bind_param('ssi', $nombre_usuario, $contrasena, $id_usuario);
            $consulta->execute();
            $consulta->close();
        }
        //Seleccionar los usuarios para el buscador
        public function buscarUsuarios($busqueda) {
            $sentencia = "SELECT id_usuario, nombre_usuario, contrasena 
                    FROM usuarios 
                    WHERE nombre_usuario LIKE ? OR contrasena LIKE ?";
            $consulta = $this->con->__get("con")->prepare($sentencia);
            $likeBusqueda = "%" . $busqueda . "%";
            $consulta->bind_param("ss", $likeBusqueda, $likeBusqueda);
            $consulta->execute();
            $consulta->bind_result($id_usuario, $nombre_usuario, $contrasena);
        
            $usuarios = array();
            while ($consulta->fetch()) {
                array_push($usuarios, [$id_usuario, $nombre_usuario, $contrasena]);
            }
            $consulta->close();
            return $usuarios;
        }
    }
?>