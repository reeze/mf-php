<?php
require_once "../Mf.php";

define('APP_DIR', ROOT_DIR . DS . 'app');
define('MF_ENV', 'dev');

// start process
Mf::dispatch();