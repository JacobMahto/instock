<?php
$username = 'root';//user name for mysql
$password = 'lion';//password for mysql
$host = 'localhost';//server
$dbName = 'stock';//name of the database
$port = '3306';//name of the connection port
$socket = '';

$connection = mysqli_connect($host,$username,$password,$dbName);
 
if($connection){ 
    //echo 'We are connected';
}
else{
    die('Database connection failed.');
}