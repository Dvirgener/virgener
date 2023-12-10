<?php

include __DIR__ . "/../src/App/functions.php";

// 1 run and create an instance for the app class (go to bootstrap.php)
$app = include __DIR__ . "/../src/App/bootstrap.php";

// 11 run the run method of the app class (go to app.php)
$app->run();
