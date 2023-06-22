<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test BD</title>

    <link rel="stylesheet" href="<?= base_url() ?>/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?= base_url() ?>/assets/css/style.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar shadow-lg  px-0 py-3">
        <div class="container-xl">
            <!-- Logo -->
            <a class="navbar-brand" href="#">
                <!-- <img src="https://preview.webpixels.io/web/img/logos/clever-light.svg" class="h-8" alt="..."> -->Test BD
            </a>
            <!-- Navbar toggle -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Collapse -->
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <!-- Nav -->
                <div class="navbar-nav mx-lg-auto">
                    <a class="nav-item me-4 fs-5 nav-link active" href="<?= base_url() ?>" aria-current="page">Home</a>
                    <a class="nav-item me-4 fs-5 nav-link" href="#">Shop</a>
                    <a class="nav-item me-4 fs-5 nav-link" href="#">Questions</a>
                    <a class="nav-item me-4 fs-5 nav-link" href="#">Pricing</a>
                </div>
                <!-- Right navigation -->

                <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php
                            if (session()->get("logged_in")) {
                                echo session()->get('username');
                            } else {
                            ?>
                                Account
                            <?php

                            }
                            ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <?php
                            if (session()->get("logged_in") && session()->get("role") == 2) {
                            ?>
                                <li><?= anchor("profile", "Profile", ['class' => "dropdown-item"]) ?></li>
                                <li><?= anchor("admin/dashboard", "Dashboard", ['class' => "dropdown-item", 'target' => "_blank"]) ?></li>
                                <li><?= anchor("logout", "Logout", ['class' => "dropdown-item"]) ?></li>
                            <?php
                            } elseif (session()->get("logged_in")) {
                            ?>
                            <?php

                            } else {
                            ?>
                                <li><?= anchor("login", "Login", ['class' => "dropdown-item"]) ?></li>
                                <li><?= anchor("registration", "Register", ['class' => "dropdown-item"]) ?></li>
                            <?php
                            }
                            ?>

                        </ul>
                    </li>
                </ul>

            </div>
        </div>
    </nav>


    <!-- -----------------
------Header End---------
------------------------- -->
    <!-- -----------------
------Main Content---------
------------------------- -->

    <?= $this->renderSection('content') ?>

    <!-- -----------------
------Footer---------
------------------------- -->
    <footer class="container-xl mt-5 text-center text-lg-start  text-dark">
        <!-- Section: Social media -->
        <section class="d-flex justify-content-center justify-content-lg-between p-4 border-bottom">
            <!-- Left -->
            <div class="me-5 d-none d-lg-block">
                <span>Get connected with us on social networks:</span>
            </div>
            <!-- Left -->

            <!-- Right -->
            <div>
                <a href="https://www.facebook.com/mdmostak.ahmedsarker" class="me-4 text-reset">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="https://twitter.com/MDSMOSTAK" class="me-4 text-reset">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="" class="me-4 text-reset">
                    <i class="fab fa-google"></i>
                </a>
                <a href="" class="me-4 text-reset">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="linkedin.com/in/md-mostak-ahmed-b936a1179" class="me-4 text-reset">
                    <i class="fab fa-linkedin"></i>
                </a>
                <a href="https://github.com/Mostak1" class="me-4 text-reset">
                    <i class="fab fa-github"></i>
                </a>
            </div>
            <!-- Right -->
        </section>
        <!-- Section: Social media -->

        <!-- Section: Links  -->
        <section class="">
            <div class="container text-center text-md-start mt-5">
                <!-- Grid row -->
                <div class="row mt-3">
                    <!-- Grid column -->
                    <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
                        <!-- Content -->
                        <h6 class="text-uppercase fw-bold mb-4">
                            <i class="fas fa-gem me-3"></i>Web Design & Development
                        </h6>

                        <p>
                            Web design and development is an umbrella term that
                            describes the process of creating a website. Like the name
                            suggests, it involves two major skill sets: web design and
                            web development. Web design determines the look and feel of
                            a website, while web development determines how it
                            functions.
                        </p>
                    </div>
                    <!-- Grid column -->

                    <!-- Grid column -->
                    <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
                        <!-- Links -->
                        <h6 class="text-uppercase fw-bold mb-4">Products</h6>
                        <p>
                            <a href="#!" class="text-reset">
                                Bootstrap
                            </a>
                        </p>
                        <p>
                            <a href="#!" class="text-reset">
                                JavaScript
                            </a>
                        </p>
                        <p>
                            <a href="#!" class="text-reset">
                                Vue
                            </a>
                        </p>
                        <p>
                            <a href="#!" class="text-reset">
                                Laravel
                            </a>
                        </p>
                    </div>
                    <!-- Grid column -->

                    <!-- Grid column -->
                    <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
                        <!-- Links -->
                        <h6 class="text-uppercase fw-bold mb-4">Useful links</h6>
                        <p>
                            <a href="#!" class="text-reset">
                                Pricing
                            </a>
                        </p>
                        <p>
                            <a href="#!" class="text-reset">
                                Settings
                            </a>
                        </p>
                        <p>
                            <a href="#!" class="text-reset">
                                Orders
                            </a>
                        </p>
                        <p>
                            <a href="#!" class="text-reset">
                                Help
                            </a>
                        </p>
                    </div>
                    <!-- Grid column -->

                    <!-- Grid column -->
                    <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                        <!-- Links -->
                        <h6 class="text-uppercase fw-bold mb-4">Contact</h6>
                        <p>
                            <i class="fas fa-home me-3"></i> Shenpara
                            Parbata,Mirpur-10, Dhaka-1216
                        </p>
                        <p>
                            <i class="fas fa-envelope me-3"></i>
                            mostakidb@gmail.com
                        </p>
                        <p>
                            <i class="fas fa-phone me-3"></i> +8801752243665
                        </p>
                        <p>
                            <i class="fas fa-print me-3"></i> + 01000000000
                        </p>
                    </div>
                    <!-- Grid column -->
                </div>
                <!-- Grid row -->
            </div>
        </section>
        <!-- Section: Links  -->

        <!-- Copyright -->
        <div class="text-center p-4">
            © 2023 Copyright:
            <a class="text-reset fw-bold" href="">
                Mostak Ahmed
            </a>
        </div>
        <!-- Copyright -->
    </footer>
    <!-- jQuery CDN Here -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <!-- bootstrap js -->
    <script src="<?= base_url() ?>/assets/js/bootstrap.bundle.min.js"></script>
    <?= $this->renderSection('script') ?>
</body>

</html>