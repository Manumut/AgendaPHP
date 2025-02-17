<?php

    //Crear una cookie
    function crearCookie(String $nom, $val){
        setcookie($nom, $val, time() + (86400*30));
    }


    //Eliminar una cookie
    function eliminarCookie(String $nom){
        if (isset($_COOKIE[$nombre])) {
            setcookie($nombre, "", time() - 3600); // Expira en el pasado
            return true;
        }
        return false;
    }


    // 🔹 Iniciar una sesión si no está iniciada
    function iniciarSesion() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }


// 🔹 Crear variables de sesión
    function establecerSesion(String $nom1, $val1, String $nom2, $val2, String $nom3, $val3){
        start_session();
        $_SESSION[$nom1]=$val1;
        $_SESSION[$nom2]=$val2;
        $_SESSION[$nom3]=$val3;
    }


// Obtener el valor de una variable de sesión
    function obtenerSesion(String $nom){
        iniciarSesion();
        return $_SESSION[$nom];
    }


    // 🔹 Cerrar sesión
    function cerrarSesion() {
        iniciarSesion();
        session_unset();
        session_destroy();
    }


    //Comprobar si la sesión existe
    function existeSesion(String $nom){
        iniciarSesion();
        return isset($_SESSION[$nom]);

    }
?>