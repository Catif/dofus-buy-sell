<?php

use Catif\Dofus\Http\Controller\BuyController;

$data = BuyController::$data;

?>

<section class="container mx-auto flex items-center flex-grow">
  <div class="card">
    <div class="card-header">
      <h1 class="card-title">Buy</h1>
    </div>

    <div class="card-body">
      <form id="buy-form">
        <div class="flex justify-center w-full h-32">
          <img id="item-image" class="w-32 h-32" src="" alt="Item image" hidden>
        </div>

        <label for="item">Item</label>
        <input type="text" id="search-item" oninput="searchItems()" class="form-control" placeholder="Search item" required>

        <select id="select-items" name="item" class="form-control" disabled required>
          <option value="loading" selected>Search something before selecting items</option>
        </select>

        <button id="submit" type="submit" class="btn btn-primary" disabled>Continue</button>
      </form>
    </div>
</section>

<script>
  const inputSearch = document.getElementById('search-item');
  const selectItems = document.getElementById('select-items');
  const itemImage = document.getElementById('item-image');
  const formEl = document.getElementById('buy-form');
  const submitEl = document.getElementById('submit');

  let lastSearch = '';
  let listItems = [];

  async function searchItems() {
    const search = inputSearch.value.trim();
    if (search == lastSearch) {
      return;
    }

    lastSearch = search;

    if (search.length < 3) {
      selectItems.innerHTML = '<option value="nothing" selected>You should write at least 3 letters</option>';
      selectItems.disabled = true;

      setPictureItem(null);
      return;
    }

    selectItems.innerHTML = '<option value="loading" selected>Loading...</option>';

    const query = "?query=" + search;
    const response = await fetch('/api/items' + query);
    const {
      data
    } = await response.json();

    listItems = data;

    selectItems.innerHTML = '';

    data.forEach(item => {
      const option = document.createElement('option');
      option.value = item.id;
      option.innerText = item.name;
      selectItems.appendChild(option);
    });

    selectItems.disabled = false;

    if (data.length == 0) {
      selectItems.innerHTML = '<option value="nothing" selected>No items found</option>';
      selectItems.disabled = true;

      setPictureItem(null);
      return;
    }

    setPictureItem(data[0].id);
  }

  selectItems.addEventListener('change', async ($event) => {
    setPictureItem($event.target.value);
  });

  function setPictureItem(idItem) {
    itemImage.hidden = true;
    submitEl.disabled = true;

    if (!idItem) {
      return;
    }

    const item = listItems.find(item => item.id == idItem);

    itemImage.src = item.link_image;
    itemImage.hidden = false;
    submitEl.disabled = false;
  }

  formEl.addEventListener('submit', async ($event) => {
    $event.preventDefault();

    const idItem = selectItems.value;
    if (!idItem) {
      return;
    }

    // redirect to /buy/{idItem}
    document.location.href = `/buy/${idItem}`;
  });
</script>