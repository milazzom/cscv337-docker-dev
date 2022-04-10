<?php
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://localhost:8080/hw6/actorid.php?first_name=tom&last_name=hanks");
curl_setopt($ch, CURLOPT_HEADER, TRUE);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
$head = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
print_r($head);

if ($httpCode == 404)
{
    echo "Actor/actress does not exist in the database!";
} else {
    echo "Actor/actress was found!";
}