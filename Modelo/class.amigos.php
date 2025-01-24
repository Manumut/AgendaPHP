<?php
    require_once('class.db.php');

    class amig{
        private $db;

        public function __construct(){
            $this->db = new db();
        }

       
        // Ejemplo de conexión y obtención de datos desde una base de datos
        require_once('../Controlador/conexion.php');
        $usuario_id = $_SESSION['usuario_id']; // ID del usuario logueado
        $query = "SELECT id, nombre, DATE_FORMAT(fecha_nacimiento, '%d/%m/%Y') AS fecha_nacimiento FROM amigos WHERE usuario_id = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();
        $resultado = $stmt->get_result();

        while ($fila = $resultado->fetch_assoc()) {
            echo "
                <tr>
                    <td>{$fila['nombre']}</td>
                    <td>{$fila['fecha_nacimiento']}</td>
                    <td>
                        <form action='../Vista/modificar_amigo.php' method='post' style='display: inline;'>
                            <input type='hidden' name='amigo_id' value='{$fila['id']}'>
                            <button type='submit' class='btn-modify'>Modificar</button>
                        </form>
                    </td>
                </tr>
            ";
        }
        $stmt->close();
        

    }

?>