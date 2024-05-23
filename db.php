<?php 
 $servername = "localhost";
 $username = "root";
 $password = "emma2004";
 $dbname = "fitness_tracker";

 //create connection
 $conn = new mysqli($servername, $username, $password, $dbname);

 //CHECK CONNECTION
 if ($conn->connect_error) {
    die("CONNECTION FAILED: ". $conn->connect_error);
 }