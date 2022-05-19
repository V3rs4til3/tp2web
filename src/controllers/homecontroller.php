<?php

namespace controllers;

class homecontroller {

    function index():void {
        require __DIR__ . '../../views/home/home.php';
    }

    function error():void {
        require __DIR__ . '../../views/home/error.php';
    }
}