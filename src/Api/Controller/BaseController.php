<?php

namespace Catif\Dofus\Api\Controller;

use Catif\Dofus\Class\Database;
use Exception;

abstract class BaseController
{
  protected function success($data)
  {
    return json_encode([
      'meta' => [
        'status' => 'success',
        'message' => 'Request successfully processed',
      ],
      'data' => $data,
    ]);
  }

  protected static function getDB()
  {
    return new Database();
  }

  protected function error($message, $status = 400)
  {
    throw new Exception($message, $status);
  }
}
