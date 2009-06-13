<?php
/**
 * Configuration for develop env variables
 */

error_reporting(7);

mfConfig::set('show_debug_info', true);
mfConfig::set('enable_toolbar', true);
mfConfig::set('default_layout', 'application');

// if set to true debug() function will take effect.
mfConfig::set('debug_mode', true);

mfConfig::set('enable_log', true);