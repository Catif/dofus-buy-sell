<?php

use Catif\Dofus\Api\Controller\ItemController;
use Catif\Dofus\Api\Controller\TransactionController;
use Catif\Dofus\Class\Router;

Router::group('/api', 'API', function () {
  Router::get('/items', ItemController::class, 'index');

  Router::post('/transactions', TransactionController::class, 'store');
});
