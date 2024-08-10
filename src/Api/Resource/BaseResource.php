<?php

namespace Catif\Dofus\Api\Resource;

abstract class BaseResource
{
  public static function collection($data)
  {
    $resource = new static();
    $collection = [];

    foreach ($data as $item) {
      $collection[] = $resource->format($item);
    }

    return $collection;
  }

  abstract protected function format($data);
}
