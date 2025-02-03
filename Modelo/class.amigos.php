<?php
// require_once('../Modelo/class.db.php');

// class Amig {
//     private $db;
//     private $conn;

//     public function __construct() {
//         $this->db = new db();
//         $this->conn = $this->db->conexion(); // Obtener la conexión de la clase db
//     }

//     // Función para obtener todos los amigos del usuario
//     public function obtenerAmigos($usuario_id) {
//         $query = "SELECT id, nombre, DATE_FORMAT(fecha_nacimiento, '%d/%m/%Y') AS fecha_nacimiento FROM amigos WHERE usuario_id = ?";
//         $stmt = $this->conn->prepare($query);

//         if (!$stmt) {
//             die("Error en la preparación de la consulta: " . $this->conn->error);
//         }

//         $stmt->bind_param("i", $usuario_id);
//         $stmt->execute();
//         $resultado = $stmt->get_result();

//         $amigos = [];
//         while ($fila = $resultado->fetch_assoc()) {
//             $amigos[] = $fila;
//         }
//         $stmt->close();

//         return $amigos;
//     }

//     // Función para mostrar la tabla con los amigos
//     public function mostrarTablaAmigos($usuario_id) {
//         $amigos = $this->obtenerAmigos($usuario_id);

//         echo '
//         <table class="friends-table">
//             <thead>
//                 <tr>
//                     <th>Nombre</th>
//                     <th>Fecha de Nacimiento</th>
//                     <th>Acciones</th>
//                 </tr>
//             </thead>
//             <tbody>';
//         foreach ($amigos as $amigo) {
//             echo "
//             <tr>
//                 <td>{$amigo['nombre']}</td>
//                 <td>{$amigo['fecha_nacimiento']}</td>
//                 <td>
//                     <form action='../Vista/modificar_amigo.php' method='post' style='display: inline;'>
//                         <input type='hidden' name='amigo_id' value='{$amigo['id']}'>
//                         <button type='submit' class='btn-modify'>Modificar</button>
//                     </form>
//                 </td>
//             </tr>";
//         }
//         echo '</tbody></table>';
//     }
// }

require_once('../Modelo/class.db.php');

class Amigo {
    private $db;

    public function __construct() {
        $this->db = new DB();
    }

    // Obtener amigos del usuario
    public function obtenerAmigos($usuario_id) {
        $query = "SELECT id_am, nombre, DATE_FORMAT(nacimiento, '%d/%m/%Y') AS nacimiento FROM amigos WHERE id_usuario = ?";
        return $this->db->query($query, [$usuario_id])->fetch_all(MYSQLI_ASSOC);
    }

    // Mostrar tabla de amigos directamente
    public function mostrarTablaAmigos($usuario_id) {
        $amigos = $this->obtenerAmigos($usuario_id);

        echo '<table class="friends-table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Fecha de Nacimiento</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>';

        foreach ($amigos as $amigo) {
            echo "
            <tr>
                <td>{$amigo['nombre']}</td>
                <td>{$amigo['fecha_nacimiento']}</td>
                <td>
                    <form action='../Vista/modificar_amigo.php' method='post' style='display: inline;'>
                        <input type='hidden' name='amigo_id' value='{$amigo['id']}'>
                        <button type='submit' class='btn-modify'>Modificar</button>
                    </form>
                </td>
            </tr>";
        }

        echo '</tbody></table>';
    }
}
?>

