<?php
$options = array(
    CURLOPT_RETURNTRANSFER => true,     // return web page
    CURLOPT_HEADER         => false,    // don't return headers
    CURLOPT_FOLLOWLOCATION => true,     // follow redirects
    CURLOPT_ENCODING       => "",       // handle all encodings
    CURLOPT_USERAGENT      => "spider", // who am i
    CURLOPT_AUTOREFERER    => true,     // set referer on redirect
    CURLOPT_CONNECTTIMEOUT => 15,      // timeout on connect
    CURLOPT_TIMEOUT        => 15,      // timeout on response
    CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects

);

$ch = curl_init();
$url = "http://web-server:80/hw6/actorid.php?first_name=tom&last_name=hanks";
$ch = curl_init($url);
curl_setopt_array( $ch, $options );
$content = curl_exec( $ch );
echo curl_error($ch);

$oXML = new SimpleXMLElement($content);
$actorId = $oXML[0]->attributes()->id;
echo "Actor id is " . $actorId;
