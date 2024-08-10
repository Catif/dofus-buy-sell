<?php
require dirname(__DIR__) . '/utils/bootstrap.php';

use Catif\Dofus\Class\Router;

Router::start();

require ROOT . '/utils/routes/api.php';
require ROOT . '/utils/routes/http.php';
