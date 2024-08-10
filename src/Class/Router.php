<?php

namespace Catif\Dofus\Class;

class Router
{
  protected static $type = 'HTTP';
  private static $routeFound = false;
  private static ?request $request = null;
  public static $routeFoundUrl = '';
  private static $route = '';

  public static function start()
  {
    static::$request = new Request();
    static::$route = static::$request->route;
  }

  public static function group($prefix, $type, $callback)
  {
    if (strpos(static::$route, $prefix) === 0) {
      if (!is_null($type)) {
        static::$type = $type;
      }
      static::$route = substr(static::$route, strlen($prefix));
      $callback();
    }
  }

  public static function getRedirect($urlFound, $urlRedirect)
  {
    if (self::isRouteOk('GET', $urlFound)) {
      header('Location: ' . $urlRedirect);
    }
  }

  public static function get($url, $controller, $function = 'index')
  {
    if (self::isRouteOk('GET', $url)) {
      static::handleRequest($controller, $function);
    }
  }

  public static function post($url, $controller, $function = 'store')
  {
    if (self::isRouteOk('POST', $url)) {
      static::handleRequest($controller, $function);
    }
  }

  public static function put($url, $controller, $function = 'update')
  {
    if (self::isRouteOk('PUT', $url)) {
      static::handleRequest($controller, $function);
    }
  }

  public static function delete($url, $controller, $function = 'destroy')
  {
    if (self::isRouteOk('DELETE', $url)) {
      static::handleRequest($controller, $function);
    }
  }

  private static function handleRequest($controller, $function = 'index')
  {
    static::$routeFound = true;

    try {
      $request = new Request();

      if (static::$type === 'API') {
        $controllerObject = new $controller();
        $response = $controllerObject->$function($request);
      } else {
        $response = $controller::renderView($function, $request);
      }

      static::success($response);
    } catch (\Exception $e) {
      static::error($e->getMessage(), $e->getCode());
    }
  }


  private static function success($body)
  {
    if (static::$type === 'API') {
      header('Content-Type: application/json');
    }

    echo $body;
  }

  private static function error($message, $code)
  {
    if (static::$type === 'API') {
      http_response_code($code);
      header('Content-Type: application/json');
      echo json_encode(['error' => $message]);
    } else {
      echo $message;
    }
  }

  public static function notFound($controller)
  {
    if (!static::$routeFound) {
      static::handleRequest($controller);
    }
  }

  private static function isRouteOk(string $method, string $url): bool
  {
    if (static::$routeFound || $_SERVER['REQUEST_METHOD'] !== $method) {
      return false;
    }

    $url = rtrim($url, '/');


    $serverRouteExplode = explode('/', $url);
    $userRouteExplode = explode('/', static::$route);

    if (count($serverRouteExplode) !== count($userRouteExplode)) {
      return false;
    }

    foreach ($serverRouteExplode as $key => $value) {
      if ($value !== $userRouteExplode[$key] && $serverRouteExplode[$key][0] !== '{') {
        return false;
      }
    }

    static::$routeFoundUrl = $url;

    return true;
  }
}
