<?php
$host = "mysql-server";
$user = "root";
$pass = "Be@rD0wN!";
$db = "imdb";
try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 
    
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

$sql = "UPDATE actors set last_name = :lname where id = :id";
$params = [];
$params["lname"] = "Barkley";
$params["id"] = 81396;
$preparedStatement = $conn->prepare($sql);
$preparedStatement->execute($params);
$conn = null;

echo "Last name updated to " . $params["lname"] . " for actor with ID " . $params["id"];