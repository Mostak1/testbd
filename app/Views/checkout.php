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
                <?= csrf_field() ?>
                <input id="u_id" class="form-control" type="text" name="u_id" value="<?= session()->get('uid')  ?>" hidden placeholder="id">
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

            </div>
        </div>
        <!-- ........................order......................... -->
        <div class="col-md-5 order-details">
            <div class="section-title text-center">
                <h3 class="title">Your Order</h3>
            </div>

            <div class="row">
                <div class="col">
                    <h2>My Cart Items:</h2>
                    <ol id="cartItemsList"></ol>
                    <div class="row mb-4">
                        <div class="col-6">Total Price:</div>
                        <div id="totalPrice" class="col-3"></div>
                        <div id="" class="col-1">TK</div>
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
            <?php
            if (session()->get("logged_in")) {
            ?>
                <input id="orderBtn" type="submit" class="btn btn-danger" name="sub">
            <?php
            } else {
            ?>
                <div class="text-danger">Please Login to Submit Order</div>
            <?php

            }
            ?>
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
            let listItem = $('<li class="row"></li>');
            listItem.text(item.sub + ' - Price: ' + item.price + ' TK');
            listItem.data('price', item.price); // Store the price data as a data attribute
            listItem.append('<input type="number" name="q" class="val w-25 form-control col-2" value="1" min="1">');
            listItem.append(`<input type="number" name="q" class="pid w-25 form-control d-none" value="${item.id}" min="1">`);

            // Add delete button
            let deleteBtn = $('<button class="btn btn-outline-danger col-1"><i class="fa-regular fa-trash-can"></i></button>');
            deleteBtn.data('index', i); // Store the index of the item
            deleteBtn.on('click', function() {
                let index = $(this).data('index');
                cartItems.splice(index, 1); // Remove the item from the cartItems array
                $(this).closest('li').remove(); // Remove the item from the list
                localStorage.setItem('cartItems', JSON.stringify(cartItems)); // Update the cartItems in local storage
            });
            listItem.append(deleteBtn);
            cartItemsList.append(listItem);
            totalPrice += parseFloat(item.price);
        }
        // Display total price
        let totalPriceElement = document.getElementById('totalPrice');
        totalPriceElement.textContent = totalPrice.toFixed(2);

        // Handle quantity change
        $('#cartItemsList').on('change', '.val', function() {
            let totalPrice = 0;
            $('.val').each(function() {
                let quantity = parseInt($(this).val());
                let price = parseFloat($(this).closest('li').data('price'));
                let itemTotal = quantity * price;
                totalPrice += itemTotal;
            });
            totalPriceElement.textContent = totalPrice.toFixed(2);
        });



        // addBtn
        $("#orderBtn").click(function() {
            let pa = $('#payment').val();
            let tid = $('#trxid').val();
            if (pa == "-1") {
                alert("Please select a payment method");
                return;
            }
            if (pa == "bkash" || pa == "nogod") {
                if (tid.length == 0) {
                    alert("Please provide a transaction ID if you select bKash or Nogod");
                    return;
                }
            }
            let formData = {
                bAddress: $('#bAddress').val(),
                sAddress: $('#sAddress').val(),
                u_id: $('#u_id').val(),
                u_name: $('#name').val(),
                payment: $('#payment').val(),
                trxid: $('#trxid').val(),
                comment: $('#comment').val(),
                price: $('#totalPrice').text(),
                action: "insert"
            };

            for (let i = 0; i < cartItems.length; i++) {
                let item = cartItems[i];
                formData['sub_' + i] = item.sub; // Add item.sub with a dynamic key (e.g., sub_0, sub_1, etc.)
                formData['id_' + i] = item.id; // Add item.id with a dynamic key (e.g., id_0, id_1, etc.)
                formData['qu_' + i] = $('.val').eq(i).val();
            }

            $.post("<?= site_url("checkout/new") ?>", formData, function(d) {
                if (d.success) {
                    Swal.fire(
                        'Order placed successfully!',
                        d.message,
                        'success'
                    ).then(() => {
                        loaddata();
                    });
                }
            });

            localStorage.removeItem('cartItems');
        });
        // addBtn end
    });
</script>
<?= $this->endSection() ?>