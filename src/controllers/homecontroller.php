<?php

namespace controllers;

class homecontroller {

    function index():void {
        if(isset($_SESSION['user'])){
            header('location: ' . HOME_PATH . '/users/userhome');
            die();
        }
        require __DIR__ . '../../views/home/home.php';
    }
}