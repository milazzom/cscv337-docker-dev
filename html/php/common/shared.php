<?php
$myVar = $_GET['somevar'];
$showSection = $_GET['showSection'];
$myVar2 = $_REQUEST['anothervar'];


function doSomething($someParam) {
    echo "I guess I should get to work. " . $someParam;
}


function processPlayerFile($filePath) {
    
    try {
        $file = fopen($filePath, "r") or die("The file you specified doesn't exist!");
        $numberOfPlayers = fgets($file);
        fwrite($file, "some data");
        $start = 0;
        while ($start < $numberOfPlayers) {
            $player = fgets($file);
            echo "Player Name and Position: " . $player;
            echo "<br/>";
            $start++;
        }

    } catch (Exception $e) {
        echo "A problem occurred. " . $e;  
        die(); 
    } finally {
        fclose($file);
    }
}


function processArray() {
    $myArray = array("Mike:Center", "Brian:Forward", "Dzastina:Forward");
    
    foreach ($myArray as $player) {
        echo $player . " <br/>";
    }
}
?>