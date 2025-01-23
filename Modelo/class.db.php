<?php
    class db{
        private $conn;

        public function __construct(){
            require_once('../../../cred.php');
            $this->conn = new mysqli("localhost", USUARIO_CON, PSW_CON, 'agenda');
        }

        public function compCrede(String $nom, String $psw){ // Esta funcion comprueba las credenciales
            $sentencia = "SELECT COUNT(*) FROM usuarios WHERE nombre = ? AND password = ?"; // Creamos la sentencia
            $consulta = $this->conn->prepare($sentencia); // Creamos la consulta
            $consulta->bind_param("ss", $nom, $psw); // Creamos los parametros
            $consulta->bind_result($count); // Creamos el resultado

            $consulta->execute(); // Ejecutamos la consulta
            $consulta->fetch(); // Obtenemos el resultado

            $existe = false; // Variable para comprobar si el usuario existe

            if($count == 1) $existe = true; // Si el usuario existe

            $consulta->close(); // Cerramos la consulta
            return $existe; // Devolvemos el valor de la variable
        }
        public function __get($nom){
            return $this->$nom;
        }
    }
?>