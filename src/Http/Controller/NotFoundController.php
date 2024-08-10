<?php

namespace Catif\Dofus\Http\Controller;

class NotFoundController extends BaseController
{
  public static $title = 'Dofus - Not Found';

  protected static function index(): string
  {
    return self::FOLDER_VIEWS . '/NotFoundView.php';
  }
}
