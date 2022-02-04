<?php
    require('common/shared.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSCV337 PHP Meeting 4</title>
</head>
<body>
    <h1>Basic Development Workflow</h1>
    <?php

        echo "Hello, CSCV337!";
    ?>
    <p>This is a paragraph</p>
    <?php
        $rightNow = new DateTime('NOW');
        echo $rightNow->format('c');
    ?>
    <h2>You said: <?= $myVar . " " . $myVar2?></h2>
    <h2><?php doSomething("Nah, I'm too tired."); ?>

    <h3>Hockey Team</h3>
    <p><?php processPlayerFile("files/somedata.txt"); ?></p>
    <p><?php processArray(); ?></p>


    <h3>Do you want to see this section?</h3>
    <?php
    if ($showSection) { 
    ?>
        <p>This section has some super secret stuff.</p>
    <?php } ?>

</body>
</html>