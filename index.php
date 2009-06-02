<?php
require_once "Mf/Mf.php";

define('ROOT_DIR', dirname(__FILE__));
define('APP_DIR', dirname(__FILE__) . DS . 'app');
define('MF_ENV', 'dev');

// start process
Mf::dispatch();