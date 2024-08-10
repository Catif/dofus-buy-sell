<?php

use Catif\Dofus\Class\Router;
use Catif\Dofus\Http\Controller\BuyController;
use Catif\Dofus\Http\Controller\HistoryController;
use Catif\Dofus\Http\Controller\NotFoundController;
use Catif\Dofus\Http\Controller\SellController;

Router::group('', 'HTTP', function () {
  Router::getRedirect('/', '/buy');

  Router::get('/buy', BuyController::class);
  Router::get('/buy/{item_id}', BuyController::class, 'show');

  Router::get('/sell', SellController::class);
  Router::get('/history', HistoryController::class);

  Router::notFound(NotFoundController::class);
});
