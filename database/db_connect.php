<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "users";
$carbondb = "carbon";

try{
    $conn = new mysqli($servername, $username, $password, $dbname);
} catch (Exception $e){
    $conn = new mysqli($servername, $username, $password);
    $sql = "CREATE DATABASE $dbname";
    if ($conn->query($sql) === TRUE) {
        $conn->close();
        $conn = new mysqli($servername, $username, $password, $dbname);
        $sql = "CREATE TABLE  userinformation  (
            id  int NOT NULL AUTO_INCREMENT,
            username  varchar(45) NOT NULL,
            email  varchar(45) NOT NULL,
            password  varchar(60) NOT NULL,
            type  varchar(45) NOT NULL,
            lastLogin  varchar(45) NOT NULL,
            PRIMARY KEY ( id ),
            UNIQUE KEY  id_UNIQUE  ( id )
            )";
            
        if (mysqli_query($conn, $sql)) {
        } else {
            echo "Error creating table: " . mysqli_error($conn);
        }
    } else {
    echo "Error creating database: " . $conn->error;
    }
}
    $conn->close();
try{
    $conn = new mysqli($servername, $username, $password, $carbondb);
} catch (Exception $e){
    $conn = new mysqli($servername, $username, $password);
    $sql = "CREATE DATABASE $carbondb";
    if ($conn->query($sql) === TRUE) {
        $conn->close();
        $conn = new mysqli($servername, $username, $password, $carbondb);
        $sql = "CREATE TABLE  carbonEmission  (
        id  int NOT NULL AUTO_INCREMENT,
        year int NOT NULL,
        emission varchar(10) NOT NULL,
        PRIMARY KEY ( id ),
        UNIQUE KEY  id_UNIQUE  ( id )
        )";
        if (mysqli_query($conn, $sql)) {
            $conn = new mysqli($servername, $username, $password, $carbondb);

            // Check connection
            if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
            }

            // SQL query to insert data
            $sql = "INSERT INTO carbonEmission (year, emission) VALUES (1750,'9.31'),(1800,'32.8'),(1900,'196'),(2000,'2551'),(2023,'3779');";

            if ($conn->query($sql) === TRUE) {
            }
        } else {
            echo "Error creating table: " . mysqli_error($conn);
        }
    }
}



?>