<?php

// system settings
ini_set('display_errors', true);

// constants
define('PROJECT_PATH', dirname(realpath(__DIR__)));

// inside files
require_once(PROJECT_PATH . '/code/model/data.php');
require_once(PROJECT_PATH . '/code/model/player.php');
require_once(PROJECT_PATH . '/code/model/printer.php');
require_once(PROJECT_PATH . '/code/model/team.php');
