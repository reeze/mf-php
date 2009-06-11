<?php
/**
 * Configuration for develop env variables
 */

error_reporting(7);

Config::set('show_debug_info', true);
Config::set('enable_toolbar', true);
Config::set('default_layout', 'application');

// if set to true debug() function will take effect.
Config::set('debug_mode', true);

Config::set('enable_log', true);