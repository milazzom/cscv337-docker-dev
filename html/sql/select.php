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

$sql = "SELECT * FROM actors order by last_name desc limit 10";

$data = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Retrieving Data from SQL Example</title>
</head>
<body>
    <table>
        <th>
        <tr><td>First Name</td><td>Last Name</td><td>Database ID</td></tr>
    </th>
    <?php
        while($row = $data->fetch()) {
            ?>
            <tr><td><?=$row['first_name']?></td><td><?=$row['last_name']?></td><td><?=$row['id']?></td></tr>                
    <?php
        }
        $conn = null;
    ?>

    </table>

    
</body>
</html>