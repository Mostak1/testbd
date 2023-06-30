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
                        <small class="text-body-black fw-bold"><i class="fa-solid fa-cart-plus"></i>Buy</small>
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

</script>
<?= $this->endSection() ?>