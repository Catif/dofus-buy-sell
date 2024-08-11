<?php

namespace Catif\Dofus\Class;

class Request
{
  public string $method = '';
  public string $uri = '';
  public string $route = '';
  public array $params = [];

  public function __construct()
  {
    $this->method = $_SERVER['REQUEST_METHOD'];
    $this->uri = $_SERVER['REQUEST_URI'];

    $explodeUri = $this->explodeURI();
    $this->route = $explodeUri['route'];
    $this->params = $explodeUri['params'];
  }

  public function getBody(): array
  {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      return [];
    }
    return json_decode(file_get_contents('php://input'), true);
  }

  public function explodeURI(): array
  {
    $uri = explode('?', $this->uri);

    return [
      'route' => $uri[0],
      'params' => $this->explodeParams($uri[1] ?? '')
    ];
  }

  public function explodeParams(string $paramsQuery): array
  {
    if (empty($paramsQuery)) {
      return [];
    }

    $params = explode('&', $paramsQuery);

    $result = [];
    foreach ($params as $param) {
      $param = explode('=', $param);
      $result[$param[0]] = $param[1];
    }

    return $result;
  }

  public function getRouteParams(): array
  {
    $routeFound = Router::$routeFoundUrl;

    $userRoute = explode('/', $this->route);
    $serverRoute = explode('/', $routeFound);


    $result = [];
    foreach ($serverRoute as $key => $value) {
      if ($value === '' || $value[0] !== '{') {
        continue;
      };

      $result[str_replace(['{', '}'], '', $value)] = $userRoute[$key];
    }

    return $result;
  }
}
