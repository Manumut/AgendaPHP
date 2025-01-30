 <?php
    
// class db {
//     private $host = 'localhost'; // Cambia según tu configuración
//     private $user = 'root'; // Cambia según tu configuración
//     private $password = ''; // Cambia según tu configuración
//     private $database = 'agenda'; // Cambia según tu configuración
//     private $conn;

        
// /*************  ✨ Codeium Command ⭐  *************/
//     /**
//      * Constructor de la clase db
//      *
//      * Crea una conexión a la base de datos y verifica que la conexión sea exitosa.
//      * Si hay un error en la conexión, finaliza el script y muestra el mensaje de error.
//      */
// /******  08a5ca77-8587-4edb-bf23-c5060fca43c7  *******/
//     public function __construct() {
//         // Crear la conexión
//         $this->conn = new mysqli($this->host, $this->user, $this->password, $this->database);

           
//         // Verificar la conexión
//         if ($this->conn->connect_error) {
//             die("Error de conexión: " . $this->conn->connect_error);
//         }
//     }

//     public function conexion() {
//         return $this->conn; // Devuelve la conexión establecida
//     }
// }


class DB {
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $dbname = "agenda";
    private $conn;

    public function __construct() {
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->dbname);
        if ($this->conn->connect_error) {
            die("Error de conexión: " . $this->conn->connect_error);
        }
    }

    public function getConn() {
        return $this->conn;
    }
}
?> 
