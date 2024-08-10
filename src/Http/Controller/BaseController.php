<?php

namespace Catif\Dofus\Http\Controller;

use Catif\Dofus\Class\Database;
use Catif\Dofus\Class\Request;

abstract class BaseController
{
  const FOLDER_VIEWS = ROOT . '/src/Http/Views';
  const FOLDER_COMPONENTS = ROOT . '/src/Http/Components';
  const FOLDER_CSS = ROOT . '/public/css';
  const FOLDER_ICONS = '/icons';

  public static $files_css = [
    'reset.css',
    'style.css',
    'footer.css',
    'navbar.css',
    'default_rules.css',
  ];

  public static $title = 'Dofus';
  public static $data = [];

  public static function renderView(string $view, Request $request): string
  {

    $view = static::getHtmlOfFile(static::$view($request));

    $html = self::getHtmlOfFile(static::header());
    $html .= $view;
    $html .= self::getHtmlOfFile(static::footer());

    return $html;
  }

  public static function header(): string
  {
    return self::FOLDER_COMPONENTS . '/header.php';
  }

  public static function footer(): string
  {
    return self::FOLDER_COMPONENTS . '/footer.php';
  }

  public static function changeTitle(string $title): void
  {
    self::$title = $title;
  }

  public static function importCSS(): void
  {
    foreach (self::$files_css as $css) {
      echo "<link rel='stylesheet' href='/css/$css'>";
    }
  }

  public static function getIcon(array $icon)
  {
    $ext = $icon['ext'] ?? 'svg';
    $name = $icon['name'];
    $size = $icon['size'] ?? '24';

    $src = self::FOLDER_ICONS . "/$name." . $ext;

    return "<img src='$src' width='$size' >";
  }

  private static function getHtmlOfFile(string $file): string
  {
    ob_start();
    require $file;
    $html = ob_get_contents();
    ob_end_clean();
    return $html;
  }

  protected static function getDB()
  {
    return new Database();
  }
}
