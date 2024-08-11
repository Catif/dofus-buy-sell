<?php

namespace Catif\Dofus\Api\Controller;

use Catif\Dofus\Class\Database;
use Catif\Dofus\Class\Request;

class TransactionController extends BaseController
{
  public function store(Request $request)
  {
    $body = $request->getBody();

    if (!isset($body['type'])) {
      $this->error('Type is required', 400);
    }

    if ($body['type'] === 'buy') {
      return $this->buy($body);
    }
  }

  private function buy(array $body)
  {
    if (!isset($body['item_id'])) {
      $this->error('Item id is required', 400);
    }

    if (!isset($body['quantity'])) {
      $this->error('Quantity is required', 400);
    }

    $quantity = (int) $body['quantity'];

    if (!isset($body['price'])) {
      $this->error('Price is required', 400);
    }

    $price = (int) $body['price'];

    if (!isset($body['per_quantity'])) {
      $this->error('Per quantity is required', 400);
    }

    $perQuantity = (int) $body['per_quantity'];

    $isMultiple = $quantity % $perQuantity;

    if ($isMultiple !== 0) {
      $this->error('Quantity must be a multiple of per quantity', 400);
    }

    $db = $this->getDB();

    $item = $db->find('items', $body['item_id']);

    if (!$item) {
      $this->error('Item not found', 404);
    }


    $numberTransaction = $quantity / $perQuantity;

    $dataToInsert = [];
    for ($i = 0; $i < $numberTransaction; $i++) {
      $dataToInsert[] = [
        'type' => 'buy',
        'item_id' => $item->id,
        'price' => $price,
        'quantity' => $perQuantity,
      ];
    }

    $db->insert('transactions', $dataToInsert);

    return $this->success($dataToInsert);
  }
}
