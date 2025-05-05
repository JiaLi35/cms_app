<?php

function connectToDB(){
    $host ="127.0.0.1";
    $database_name = "cms_app";
    $database_user = "root";
    $database_password = "";

    $database = new PDO(
        "mysql:host=$host;dbname=$database_name",
        $database_user,
        $database_password
    );
    
    return $database;
}