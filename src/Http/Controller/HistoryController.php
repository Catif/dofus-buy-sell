<?php

namespace Catif\Dofus\Http\Controller;

class HistoryController extends BaseController
{
  public static $title = 'Dofus - History';

  protected static function index(): string
  {
    return self::FOLDER_VIEWS . '/HistoryView.php';
  }
}
