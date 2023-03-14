<!DOCTYPE html>
<html lang="en">
<?= view('template/customer/head') ?>

<body>
    <section id="form-login" class="d-flex justify-content-center align-items-center flex-column">
        <div class="form-container flex-grow-1 d-flex justify-content-center align-items-center flex-row gap-5">
            <div class="form-body">
                <?php if (session()->getFlashdata('sukses')) { ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Selamat!</strong> <?= session()->getFlashdata('sukses') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php } else if (session()->getFlashdata('gagal')) { ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Whoops!</strong> <?= session()->getFlashdata('gagal') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php } ?>

                <div class="form-content">
                    <h1 class="fw-bold mb-4 text-center">Masuk</h1>

                    <a href="<?= $url ?>" class="button button-black my-3 p-2 d-flex align-items-center justify-content-center flex-row">
                        <div>
                            <img src="../assets/images/google.png" width="50" height="50">
                        </div>
                        <div class="flex-grow-1 d-flex justify-content-center align-items-center">
                            <span class="fw-bold fs-5">Masuk Dengan Google</span>
                        </div>
                    </a>
                    </button>
                </div>

                <div class="form-content mt-4">
                    <h6 class="fw-bold text-center">Harap mempunyai akun Google Gmail terlebih dahulu untuk masuk website Spatola Cake.</h6>
                </div>

            </div>

            <div class="form-image">
                <a href="<?= base_url('/') ?>">
                    <img src="../assets/images/sc-2.png" alt="Logo Spatola Cake" width="400px" height="400px" />
                </a>
            </div>
        </div>
        <div class="text-center mt-4">
            <p class="fw-bold">Jika anda mempunyai masalah dalam login Spatola Cake, <br>harap menghubungi kontak kami di bawah ini.</p>

            <div class="d-flex flex-row justify-content-center gap-4">
                <div class="nav-content p-0 text-black">
                    <i class="fa fa-envelope"> </i>
                    <!-- <a href="mailto: spatola@gmail.com" style="text-decoration:none; color: #000">
                        <span>spatola@gmail.com</span>
                    </a> -->
                    <span>spatola@gmail.com</span>
                </div>
                <div class="nav-content p-0 text-black">
                    <i class="fa fa-phone-alt"> </i>
                    <!-- <a href="https://wa.me/082166271806" style="text-decoration:none; color: #000">
                        <span>082166271806</span>
                    </a> -->
                    <span>082166271806</span>
                </div>
            </div>
        </div>
    </section>

    <style>
        .nav-content i {
            color: #b7d7b2;
        }
    </style>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/simplePagination.js/1.6/jquery.simplePagination.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
    <script src="<?= base_url('assets/js/main.js') ?>"></script>
</body>

</html>