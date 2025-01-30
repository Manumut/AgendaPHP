<?php
    // require_once('class.db.php');

    // class usu{
    //     private $db;

    //     public function __construct(){
    //         $this->db = new db();
    //     }

    //     public function insertar(){
    //         $conn = $this->db->__get("conn");
    //         $sent = "SELECT * FROM autores WHERE id<>0";

    //         $cons = $conn->prepare($sent);
    //         $cons->bind_result($id, $nom);
    //         $cons->execute();

    //         $lista = array();

    //         while($cons->fetch()){
    //             $lista[$id] = $nom;
    //         }

    //         $cons->close();

    //         return $lista;
    //     }

    
    // }

    class Usuario {
        private $db;
    
        public function __construct() {
            $this->db = (new DB())->getConn();
        }
    
        public function login($nombre, $password) {
            $stmt = $this->db->prepare("SELECT id FROM usuarios WHERE nombre = ? AND password = ?");
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