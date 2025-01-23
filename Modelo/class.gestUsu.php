<?php
    require_once('class.db.php');

    class usu{
        private $db;

        public function __construct(){
            $this->db = new db();
        }

        public function insertar(){
            $conn = $this->db->__get("conn");
            $sent = "SELECT * FROM autores WHERE id<>0";

            $cons = $conn->prepare($sent);
            $cons->bind_result($id, $nom);
            $cons->execute();

            $lista = array();

            while($cons->fetch()){
                $lista[$id] = $nom;
            }

            $cons->close();

            return $lista;
        }

        public function 
¡
    }

?>