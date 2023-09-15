<?php
    include_once(__DIR__."/function.php");
function db_conn( &$conn ) {
    $db_host = '192.168.0.30';
    $db_name = 'pet_realestate';
    $charset = 'utf8mb4';
    $name = 'root';
    $db_password = 'root506';
    
    $dns = "mysql:host=".$db_host.";dbname=".$db_name.";charset=".$charset;
    
    $option = 
        [
            PDO::ATTR_EMULATE_PREPARES     => false
            ,PDO::ATTR_ERRMODE             => PDO::ERRMODE_EXCEPTION
            ,PDO::ATTR_DEFAULT_FETCH_MODE  => PDO::FETCH_ASSOC
        ];
    
    try {
        $conn = new PDO($dns, $name, $db_password, $option);
    } catch (Exception $e) {
        $conn = null;
        throw new Exception( $e->getMessage() );
    }
    
}