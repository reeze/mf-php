<?php

require_once './Mf.php';
define('APP_DIR', './app');
define('MF_ENV', 'dev');


Mf::init();

// Include your Doctrine configuration/setup here, your connections, models, etc.

// Configure Doctrine Cli
// Normally these are arguments to the cli tasks but if they are set here the arguments will be auto-filled and are not required for you to enter them.

$config = array('data_fixtures_path'  =>  '/path/to/data/fixtures',
                'models_path'         =>  APP_DIR . DS . 'models',
                'migrations_path'     =>  ROOT_DIR . DS . 'data' . DS . 'migrations',
                'sql_path'            =>  ROOT_DIR . DS . 'data' . DS . 'sql',
                'yaml_schema_path'    =>  ROOT_DIR . DS . 'data');

$cli = new Doctrine_Cli($config);
$cli->run($_SERVER['argv']);
