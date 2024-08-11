<?php

namespace Catif\Dofus\Api\Controller;

use Catif\Dofus\Api\Resource\IndexItemsResource;
use Catif\Dofus\Class\Database;
use Catif\Dofus\Class\Request;

class ItemController extends BaseController
{
  public function index(Request $request)
  {
    $query = $request->params;

    if (!isset($query['query'])) {
      $this->error('Query is required', 400);
    }

    $db = Database::getInstance();

    $items = $db->query("SELECT * FROM items 
      WHERE name LIKE '%{$query['query']}%'
      ORDER BY type
    ")->fetchAll();

    return $this->success(
      IndexItemsResource::collection($items)
    );
  }
}
