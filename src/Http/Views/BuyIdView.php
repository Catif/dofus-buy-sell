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
      <form id="buy-form" class="flex flex-col items-center gap-4">
        <div id="alert" class="alert" hidden>
        </div>
        <input type="hidden" name="item_id" value="<?= $item->id ?>">
        <div class="flex items-center gap-2">
          <span>
            I have bought
          </span>
          <input type="number" class="input" name="quantity" placeholder="Quantity total" required>
          <span>
            for
          </span>
          <input type="number" class="input" name="price" placeholder="Price per quantity" required>
          <span>
            kamas by
          </span>
          <select name="per_quantity" class="select" required>
            <option value="1">1</option>
            <option value="10">10</option>
            <option value="100">100</option>
          </select>
        </div>

        <span>
          Total : <span id="total">0</span> kamas
        </span>

        <button id="submit" type="submit" class="btn btn-primary">Continue</button>
      </form>
    </div>
  </div>
</section>

<script>
  const formEl = document.getElementById('buy-form');
  const submitEl = document.getElementById('submit');
  const alertEl = document.getElementById('alert');

  formEl.addEventListener('input', () => {
    submitEl.disabled = true;
    const formData = new FormData(formEl);

    const price = formData.get('price');
    const perQuantity = formData.get('per_quantity');
    const quantity = formData.get('quantity');

    if (price && perQuantity && quantity) {
      submitEl.disabled = false;
    }

    const total = Math.floor(price * (quantity / perQuantity));
    const regex = /\B(?=(\d{3})+(?!\d))/g;

    document.getElementById('total').innerText = total.toString().replace(regex, ' ');
  });

  formEl.addEventListener('submit', async ($event) => {
    $event.preventDefault();

    showAlert();

    const formData = new FormData(formEl);

    const price = formData.get('price');
    const perQuantity = formData.get('per_quantity');
    const quantity = formData.get('quantity');
    const item_id = formData.get('item_id');

    const body = {
      item_id,
      price,
      per_quantity: perQuantity,
      quantity,
      type: 'buy',
    };

    try {
      const response = await fetch('/api/transactions', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(body),
      })

      if (!response.ok) {
        const {
          meta
        } = await response.json()
        throw new Error(meta.message);
      }

      const {
        meta,
        data
      } = await response.json();

      showAlert('success', "Your transaction has been successfully created, you will be redirected to the sellings page in 3 seconds...");
      setTimeout(() => {
        window.location.href = '/sell/' + item_id;
      }, 3000);
    } catch (error) {
      showAlert('error', error.message);
    }
  });

  function showAlert(type, message) {
    alertEl.hidden = true;

    if (!message) {
      return;
    }

    alertEl.classList.remove('success', 'error', 'warning');
    alertEl.classList.add(type);

    alertEl.innerText = message;
    alertEl.hidden = false;
  }
</script>