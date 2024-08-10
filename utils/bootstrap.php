<?php
define('ROOT', dirname(__DIR__));

require ROOT . '/vendor/autoload.php';
require 'functions.php';

use Catif\Dofus\Class\Database;

$env_files_path = ROOT . '/.env';
generateEnv($env_files_path);

// Show error
if (config('app.env') === 'local') {
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
}

Database::connectByEnv();
