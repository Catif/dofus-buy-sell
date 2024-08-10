<?php

namespace Catif\Dofus\Class;

class DofusDU extends RequestAPI
{
  const URL = 'https://api.dofusdu.de';
  const LANGUAGE = 'fr';
  const GAME = 'dofus2';

  public function __construct()
  {
    info('DofusDU API initialized');
  }

  private function generateUrlAPI()
  {
    return self::URL . '/' . self::GAME . '/' . self::LANGUAGE;
  }

  // example : https://api.dofusdu.de/dofus2/fr/items/consumables/all
  public function getItems(string $type)
  {
    $url = $this->generateUrlAPI() . '/items/' . $type . '/all';

    $data = $this->get($url);

    return $data['items'];
  }

  public function searchItems(string $type, string $query)
  {
    $url = $this->generateUrlAPI() . '/items/' . $type . '/search?query=' . $query;

    $data = $this->get($url);

    return $data;
  }

  public function findItem(string $type, int $id)
  {
    $url = $this->generateUrlAPI() . '/items/' . $type . '/' . $id;

    $data = $this->get($url);

    return $data;
  }
}
