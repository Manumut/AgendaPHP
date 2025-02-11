<?php
require_once('../../../../cred.php');
class db {
    private $conn; 
    public function __construct() {
        $this->conn=new mysqli("localhost",USUARIO_CON,PSW_CON,"agenda");
    }
    public function __get($nom){
        return $this->$nom;
    }
}
?>