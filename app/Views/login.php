<?= $this->extend('components') ?>
<?= $this->section('content') ?>

<div class="container my-5">
    <div class="row contact">
        <div class="col-md-6">
            <!-- <Lottie animationData={contactm} loop={true} /> -->

            <lottie-player src="https://assets7.lottiefiles.com/packages/lf20_mjlh3hcy.json" background="transparent" speed="1" style="width: 600px; height: 400px;" loop autoplay></lottie-player>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12">
                    <div class="titlepage mx-auto text-center">
                        <h2>LogIn Here</h2>
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
            <?= form_open('login') ?>



            <label class="form-label">Email</label>
            <input class="form-control" type="email" name="email" />

            <label class="form-label">Password</label>
            <input class="form-control" type="password" name="password" />


            <input class="btn btn-outline-primary my-4" type="submit" value="LogIn" />
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>