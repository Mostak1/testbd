<?= $this->extend('components') ?>
<?= $this->section('content') ?>

<div class="container my-5">
    <div class="text-center fs-1">Checkout</div>
    <div class="row">
        <div class="col-md-7">
            <!-- Billing Details -->
            <div class="billing-details">
                <div class="section-title">
                    <h3 class="title">User Information</h3>
                </div>
                <form action="" method="post">
                    <div class="mb-2">
                        <input id="name" class="form-control" type="text" name="name" value="<?= session()->get('username') ?>" placeholder="Name">
                    </div>
                    <div class="mb-2">
                        <input class="form-control" type="text" name="phn" value="<?= session()->get('mobile') ?>" placeholder="Phone">
                    </div>
                    <div class="mb-2">
                        <input class="form-control" type="email" name="email" value="<?= session()->get('email') ?>" placeholder="Email">
                    </div>
                    <h3 class="title">Billing Address</h3>
                    <div class="mb-2">
                        <input id="bAddress" class="form-control" type="text" name="b_address" placeholder="Billing Address">
                    </div>
                    <h3 class="title">Shipping Address</h3>
                    <div class="mb-2">
                        <input id="sAddress" class="form-control" type="text" name="s_address" placeholder="Shipping Address">
                    </div>
                    <div>
                        <input value="<?= session()->get('id') ?>" id="u_id" name="u_id" type="hidden">
                    </div>
            </div>
        </div>
        <!-- ........................order......................... -->
        <div class="col-md-5 order-details">
            <div class="section-title text-center">
                <h3 class="title">Your Order</h3>
            </div>

            <div class="row">
                <div class="col">
                    <h2>Cart Items:</h2>
                    <ol id="cartItemsList"></ol>
                    <div class="row mb-4">
                        <div class="col-6">Total Price:</div>
                        <div id="totalPrice" class="col-3"></div>
                    </div>
                </div>
            </div>





            <!-- ...................payment................................ -->
            <div class="row mx-0 mb-2">
                <div class="col-sm-4 p-0 d-inline">
                    <h6>Payment</h6>
                </div>
                <div class="col-sm-8 p-0">
                    <select name="payment" id="payment" class="form-control">
                        <option value="-1">Select</option>
                        <option value="cash">Cash</option>
                        <option value="bkash">bKash</option>
                        <option value="nogod">Nogod</option>
                        <option value="cod">Cash On Delivery</option>
                    </select>
                </div>
            </div>
            <div class="row mx-0 mb-2">
                <div class="col-sm-4 p-0 d-inline">
                    <h6>TrxID</h6>
                </div>
                <div class="col-sm-8 p-0">
                    <input type="text" id="trxid" class="form-control">
                </div>
            </div>
            <div class="row mx-0 mb-2">
                <div class="col-sm-4 p-0 d-inline">
                    <h6>Comment</h6>
                </div>
                <div class="col-sm-8 p-0">
                    <textarea name="comment" id="comment" class="form-control"></textarea>
                </div>
            </div>
            <input id="orderBtn" type="submit" class="btn btn-danger" name="sub">
        </div>

        </form>
    </div>
</div>

<?= $this->endSection() ?>
<?= $this->section('script') ?>
<script>
    $(document).ready(function() {
        // Retrieve cart items from local storage
        let cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
        let totalPrice = 0;
        let cartItemsList = $('#cartItemsList');
        for (let i = 0; i < cartItems.length; i++) {
            let item = cartItems[i];
            let listItem = $('<li></li>');
            listItem.text(item.sub + ' - Price: ' + item.price + ' TK');
            listItem.data('price', item.price); // Store the price data as a data attribute
            listItem.append('<input type="number" name="q" class="val w-25" value="1" min="1">');
            cartItemsList.append(listItem);
            totalPrice += parseFloat(item.price);
        }
        // Display total price
        let totalPriceElement = document.getElementById('totalPrice');
        totalPriceElement.textContent = totalPrice.toFixed(2) + ' TK';

        // Handle quantity change
        $('#cartItemsList').on('change', '.val', function() {
            let totalPrice = 0;
            $('.val').each(function() {
                let quantity = parseInt($(this).val());
                let price = parseFloat($(this).closest('li').data('price'));
                let itemTotal = quantity * price;
                totalPrice += itemTotal;
            });
            totalPriceElement.textContent = totalPrice.toFixed(2) + ' TK';
        });
        $('#placeOrder').click(function() {
            // Prepare the form data
            let formData = {
                name: $('#name').val(),
                phn: $('#phn').val(),
                email: $('#email').val(),
                bAddress: $('#bAddress').val(),
                sAddress: $('#sAddress').val(),
                u_id: $('#u_id').val(),
                payment: $('#payment').val(),
                trxid: $('#trxid').val(),
                comment: $('#comment').val()
            };
            // Perform additional form validation if needed
            // Submit the form data to a server-side endpoint
            $.ajax({
                url: '/place-order', // Replace with the actual server-side endpoint URL
                type: 'POST',
                data: formData,
                success: function(response) {
                    // Clear the cart items from local storage
                    localStorage.removeItem('cartItems');
                    // Clear the form fields
                    $('#orderForm input, #orderForm textarea').val('');
                    // Display a success message or redirect to a confirmation page
                    alert('Order placed successfully!');
                },
                error: function(xhr, status, error) {
                    // Display an error message or handle the error condition
                    alert('Failed to place the order. Please try again.');
                }
            });
        });
    });
</script>
<?= $this->endSection() ?>