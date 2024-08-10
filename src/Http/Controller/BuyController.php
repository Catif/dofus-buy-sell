<?php

namespace Catif\Dofus\Http\Controller;

use Catif\Dofus\Class\Request;

class BuyController extends BaseController
{
  public static $title = 'Dofus - Buy';

  protected static function index(): string
  {
    return self::FOLDER_VIEWS . '/BuyView.php';
  }

  protected static function show(Request $request): string
  {
    $itemId = $request->getRouteParams()['item_id'];

    if (!is_numeric($itemId)) {
      return self::FOLDER_VIEWS . '/NotFoundView.php';
    }

    $db = self::getDB();

    $item = $db->find('items', $itemId);

    self::$data['item'] = $item;

    return self::FOLDER_VIEWS . '/BuyIdView.php';
  }
}
