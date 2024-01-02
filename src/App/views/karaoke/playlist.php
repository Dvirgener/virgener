<?php

echo "THIS IS IT";
pd($queue);
pd($_SESSION['playlist']);

redirectTo("/player?play={$queue}");
