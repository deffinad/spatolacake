<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Spatola Cake Website</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css"> -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
</head>


<body>

<section id="form-login" class="d-flex justify-content-center align-items-center">
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
                <form action="<?= base_url('daftaradmin')?>" method="POST">
                    <h1 class="fw-bold mb-5">Daftar Admin</h1>
                    <div class="mb-3">
                        <input type="text" class="form-control fs-6" name="email" placeholder="Email" required/>
                    </div>

                    <div class="mb-3">
                        <input type="text" class="form-control fs-6" name="nama" placeholder="Nama Pengguna" required/>
                    </div>

                    <div class="mb-3">
                        <input type="text" class="form-control fs-6" name="noTelp" placeholder="No.Telp" required/>
                    </div>

                    <div class="mb-3">
                        <select class="form-select fs-6" name="jenisKelamin" required style="background-color:white; border-radius: 0.375rem; color:#6c757d !important;">
                            <option selected disabled>Pilih Jenis Kelamin</option>
                            <option value="Laki-Laki">Laki-Laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <input type="password" class="form-control fs-6" name="password" placeholder="Kata sandi" required/>
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control fs-6" name="konfirmasiPassword" placeholder="Konfirmasi kata sandi" required/>
                    </div>
                    <button class="button button-black my-4 p-2" type="submit" name="submit" style="border:none;width: 100%; border-radius: 20px;">Daftar</button>

                </form>
            </div>
        </div>

        <div class="form-image">
            <a href="#">
                <img src="../assets/images/sc-2.png" alt="Logo Spatola Cake" width="400px" height="400px" />
            </a>
        </div>
    </div>
</section>

    <script src="../assets/js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
    <script src="../assets/js/main.js"></script>
</body>

</html>