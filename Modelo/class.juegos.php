<?php
    require_once('class.db.php');

    class Usuario {
        private $db;
    
        public function __construct() {
            $this->db = (new DB())->getConn();
        }
    
        public function login($nombre, $password) {
            $stmt = $this->db->prepare("SELECT id_usu FROM usuarios WHERE nombre = ? AND password = ?");
            $stmt->bind_param("ss", $nombre, $password);
            $stmt->execute();
            $stmt->store_result();
    
            if ($stmt->num_rows > 0) {
                session_start();
                $_SESSION['usuario'] = $nombre;
                return true;
            }
            return false;
        }
    }
    

?>