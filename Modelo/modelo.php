<?php
    function set_cookie (String $nom, $val){
        setcookie($nom, $val, time()+(86400*30));  
    }

    function start_session(){
        if(session_status() == PHP_SESSION_NONE){
            session_start();
        }
    }

function unset_cookie (String $nom){ //Devuelve true si se ha borrado 
        $comp = false;
        if(isset($_COOKIE[$nom])){ //Si el cookie existe
            setcookie($nom, "", time()-30); //Lo borramos
            $comp = true; //Devuelve true
        }
        return $comp;      
    }

    function set_session (String $nom, $val){ //Devuelve true si se ha borrado
       start_session(); 
       $_SESSION[$nom] = $val;
    }

    function get_session (String $nom){
        start_session();
        return $_SESSION[$nom];
    }

    function unset_session (String $nom){
        start_session();
    
        session_unset();
        session_destroy();
    }

    function is_session (String $nom){
        start_session();
        $isset = isset($_SESSION[$nom]);
        return $isset;
    }
    
?>