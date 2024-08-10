<?php

use Catif\Dofus\Class\Request;
use Catif\Dofus\Http\Controller\BaseController;

$items = [
  [
    'title' => 'Buy',
    'url' => '/buy',
    'icon' => [
      'name' => 'hotel_de_vente',
      'ext' => 'png',
      'size' => '32'
    ]
  ],
  [
    'title' => 'Sell',
    'url' => '/sell',
    'icon' => [
      'name' => 'kamas',
      'ext' => 'png',
      'size' => '32'
    ]
  ],
  [
    'title' => 'History',
    'url' => '/history',
    'icon' => [
      'name' => 'chart-line-up-fill',
      'ext' => 'svg',
      'size' => '32',
    ]
  ],
];

$request = new Request();

$actual_link = $request->route;
?>

<nav>
  <div>
    <?php foreach ($items as $item) : ?>
      <a href="<?= $item['url'] ?>" class="<?= $actual_link === $item['url'] ? 'active' : '' ?>">
        <?= BaseController::getIcon($item['icon']) ?>
        <span>
          <?= $item['title'] ?>
        </span>
      </a>
    <?php endforeach; ?>
  </div>
</nav>