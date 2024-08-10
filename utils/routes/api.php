<?php

use Catif\Dofus\Api\Controller\ItemsController;
use Catif\Dofus\Class\Router;

Router::group('/api', 'API', function () {
  Router::get('/items', ItemsController::class, 'index');
});
