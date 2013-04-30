<?php
require('app/application.php');

/* load regular */
$config = include('app/config/application.php');

/* you could also mock here */

/* start the application */
new Application($config);
