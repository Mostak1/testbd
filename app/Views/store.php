<?= $this->extend('components') ?>
<?= $this->section('content') ?>

<div class="container my-5">
    <div class="text-center fs-1">~ Chose Your Test Paper ~</div>

    <h1></h1>
    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php foreach ($sub as $row) { ?>
            <div class="col">
                <div class="card h-100">
                    <img src="<?= base_url() ?>/assets/HSC/<?= $row['images'] ?>" alt="<?= $row['images'] ?>" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title"><?= $row['subject']  ?></h5>
                        <p class="card-text">Price :<?= $row['price']  ?> </p>
                    </div>
                    <div class="card-footer">
                        <i id="cart" data-price="<?= $row['price']  ?>" data-sub="<?= $row['subject']  ?>" data-id=<?= $row['id'] ?> class="fa-solid fa-cart-plus cart"></i>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<!-- --------------------------
----------- -----------
-------------------------------- -->


<?= $this->endSection() ?>
<?= $this->section('script') ?>
<script>
    $(document).ready(function() {
        $('.cart').click(function() {
            let id = $(this).data('id');
            let sub = $(this).data('sub');
            let price = $(this).data('price');

            let item = {
                id: id,
                sub: sub,
                price: price
            };

            let cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];

            cartItems.push(item);

            localStorage.setItem('cartItems', JSON.stringify(cartItems));

            alert('Item added to cart successfully!');
        });
    });
</script>
<?= $this->endSection() ?>