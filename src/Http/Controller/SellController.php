<?php

namespace Catif\Dofus\Http\Controller;

class SellController extends BaseController
{
  public static $title = 'Dofus - Sell';

  protected static function index(): string
  {
    return self::FOLDER_VIEWS . '/SellView.php';
  }
}
