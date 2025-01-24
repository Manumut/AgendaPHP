<?php
class db {
    private $host = 'localhost'; // Cambia según tu configuración
    private $user = 'root'; // Cambia según tu configuración
    private $password = ''; // Cambia según tu configuración
    private $database = 'agenda'; // Cambia según tu configuración
    private $conn;

    public function __construct() {
        // Crear la conexión
        $this->conn = new mysqli($this->host, $this->user, $this->password, $this->database);

        // Verificar la conexión
        if ($this->conn->connect_error) {
            die("Error de conexión: " . $this->conn->connect_error);
        }
    }

    public function conexion() {
        return $this->conn; // Devuelve la conexión establecida
    }
}
?>
