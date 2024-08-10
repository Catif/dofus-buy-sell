<?php

require dirname(__DIR__) . '/utils/bootstrap.php';

use Catif\Dofus\Class\Database;
use Catif\Dofus\Class\DofusDU;

info("== Running seederDBapi.php ==");
info("This script will seed the `Items` table with the DofusDU API");

timer(5, fn($i) => "Starting in $i seconds...");

spaces(1);

$started_at = now();

info("Seeding the database with the DofusDU API...");

$dofusDU = new DofusDU();

$listItems = [
  'resources',
  'consumables',
  'cosmetics',
  'equipment',
  'quest',
];

$item = $listItems[0];

$db = new Database();

foreach ($listItems as $item) {
  info("\n== Seeding items of type $item ==");

  info("Fetching API...");
  $elements = $dofusDU->getItems($item);
  info("- Found " . count($elements) . " items");

  info("Inserting items to DB...");
  $numberInsert = 0;

  $dataFormated = array_map(function ($element) use ($item) {
    return [
      'ankama_id' => $element['ankama_id'],
      'name' => $element['name'],
      'type' => $item,
      'category' => $element['type']['name'],
      'level' => $element['level'],
      'description' => $element['description'],
      'link_image' => $element['image_urls']['hd'],
    ];
  }, $elements);

  $db->insert('items', $dataFormated);
  info("- Done");
}

info("\nSeeding finished in " . diffHuman($started_at));
