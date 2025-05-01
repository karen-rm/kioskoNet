<?php
    //header("Content-Type: text/xml; charset=UTF-8\r\n");
    ini_set("log_errors", 1);
    ini_set("error_log", "reportes/php-error-producto.log");

    require_once 'vendor/autoload.php';
    require_once 'myFireBase.php';
    
    
    use servicioWebProductos\MyFireBase; 
    $firebase = new MyFireBase('tienda-e1876-default-rtdb');
    $server = new soap_server();
https://kioskonet-fc6a6-default-rtdb.firebaseio.com/ 