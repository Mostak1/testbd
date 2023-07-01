<?= $this->extend('components') ?>
<?= $this->section('content') ?>

<div class="container my-5">
    <div class="text-center fs-1">Checkout</div>

    <div class="row">
        <div class="col">
            <h2>Cart Items:</h2>
            <ul id="cartItemsList"></ul>
            <div id="totalPrice"></div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col">
            <label class="form-label">Shipping Address:</label>
        </div>
        <div class="col">
            <input class="form-control" type="text" name="saddress" id="saddress">
        </div>
    </div>
    <div class="row mt-3">
        <div class="col">
            <label class="form-label">Billing Address:</label>
        </div>
        <div class="col">
            <input class="form-control" type="text" name="baddress" id="baddress">
        </div>
    </div>

    <div class="row mt-3">
        <div class="col">
            <h2>Payment Method:</h2>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col">
            <button id="placeOrder" class="btn btn-primary">Place Order</button>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
<?= $this->section('script') ?>
<script>
    $(document).ready(function() {
        // Retrieve cart items from local storage
        let cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];

        // Display cart items and calculate total price
        let totalPrice = 0;
        let cartItemsList = document.getElementById('cartItemsList');
        for (let i = 0; i < cartItems.length; i++) {
            let item = cartItems[i];
            let listItem = document.createElement('li');
            listItem.textContent = item.sub + ' - Price: ' + item.price;
            cartItemsList.appendChild(listItem);
            totalPrice += parseFloat(item.price);
        }

        // Display total price
        let totalPriceElement = document.getElementById('totalPrice');
        totalPriceElement.textContent = 'Total Price: $' + totalPrice.toFixed(2);

        // Handle place order button click
        $('#placeOrder').click(function() {
            // Perform the order placement logic here, such as submitting the form data to a server-side endpoint
            // You can include AJAX or form submission code to handle the order placement

            // After successfully placing the order, you can clear the cart items from local storage
            localStorage.removeItem('cartItems');

            // Display a success message or redirect to a confirmation page
            alert('Order placed successfully!');
        });
    });
</script>
<?= $this->endSection() ?>