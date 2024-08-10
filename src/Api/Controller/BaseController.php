<?php

namespace Catif\Dofus\Api\Controller;

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
}
