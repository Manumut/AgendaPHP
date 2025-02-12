<?php
require_once('../../../cred.php');

class db {
    private $con; 
    public function __construct() {
        $this->con=new mysqli("localhost",USUARIO_CON,PSW_CON,"db_agenda");
    }
    public function getConexion(){
        return $this->$con;
    }
}
?>