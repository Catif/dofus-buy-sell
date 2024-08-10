<?php

use Catif\Dofus\Http\Controller\BuyController;

$data = BuyController::$data;

$item = $data['item'];

?>

<section class="container">
  <div class="card">
    <div class="card-header">
      <h1 class="card-title">
        Buy :
        <span class="text-white"><?= $item->name ?></span>
        <img class="w-16 h-16" src="<?= $item->link_image ?>" alt="Item image">
      </h1>
    </div>

    <div class="card-body">
      <form id="buy-form">
        <button id="submit" type="submit" class="btn btn-primary" disabled>Continue</button>
      </form>
    </div>
</section>

<script>
  const formEl = document.getElementById('buy-form');
  const submitEl = document.getElementById('submit');
</script>