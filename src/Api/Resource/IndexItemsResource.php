<?php

namespace Catif\Dofus\Api\Resource;

class IndexItemsResource extends BaseResource
{
  protected function format($data)
  {
    return [
      'id' => $data->id,
      'ankama_id' => $data->ankama_id,
      'name' => $data->name,
      'level' => $data->level,
      'type' => $data->type,
      'category' => $data->category,
      'description' => $data->description,
      'link_image' => $data->link_image,
    ];
  }
}
