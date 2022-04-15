<?php
$options = array(
    CURLOPT_RETURNTRANSFER => true,     // return web page
    CURLOPT_HEADER         => false,    // don't return headers
    CURLOPT_FOLLOWLOCATION => true,     // follow redirects
    CURLOPT_ENCODING       => "",       // handle all encodings
    CURLOPT_USERAGENT      => "spider", // who am i
    CURLOPT_AUTOREFERER    => true,     // set referer on redirect
    CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects

);
$first_name = $_REQUEST['first_name'];
$last_name = $_REQUEST['last_name'];
$ch = curl_init();
$url = "http://localhost:80/hw6/actorid.php?first_name=tom&last_name=hanks";
$ch = curl_init($url);
curl_setopt_array( $ch, $options );
$content = curl_exec( $ch );
curl_close( $ch );


$oXML = new SimpleXMLElement($content);
$actorId = $oXML[0]->attributes()->id;
echo "Actor id is " . $actorId;
