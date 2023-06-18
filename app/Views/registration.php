<?= $this->extend('components') ?>
<?= $this->section('content') ?>

<div class="container my-5">
    <div class="row contact">
        <div class="col-md-6">
            <!-- <Lottie animationData={contactm} loop={true} /> -->
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12">
                    <div class="titlepage mx-auto text-center">
                        <h2>Contact Now</h2>
                    </div>
                </div>
            </div>
            <?php if (session()->has('message')) : ?>
                <div class="alert alert-primary message text-center" role="alert">
                    <?php echo session('message'); ?>
                </div>
            <?php endif; ?>

            <?php if (session()->has('errors')) : ?>
                <div class="alert alert-danger text-center">
                    <ul>
                        <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                            <div>**<?= $error ?>** </div>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- <form method="post" action="registration/store">/ -->
            <?= form_open('registration/store') ?>


            <label class="form-label" for="">Name</label>
            <input class="form-control" type="text" name="name" />
            <label class=" form-label" for="">Email</label>
            <input class="form-control" type="email" name="email" />
            <label class=" form-label" for="">Mobile</label>
            <input class="form-control" type="number" name="mobile" />
            <label class=" form-label">Password</label>
            <input class="form-control" type="password" name="password" />
            <label class="form-label">Confirm Password</label>
            <input class="form-control" type="password" name="passconf" />

            <input class="btn btn-outline-primary my-4" type="submit" value="Register" />
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>