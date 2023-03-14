<!DOCTYPE html>
<html lang="en">
<?= view('template/customer/head') ?>

<body>
    <?= view('template/customer/navbar') ?>

    <section id="contact">
        <div class="container">
            <h1 class="fw-bold" style="font-family: 'Poppins', sans-serif ;">Kontak Kami</h1>

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

            <div class="row contact-content my-5">
                <div class="form-contact col-md-6">
                    <form method="POST" action="<?= base_url('kontak/') ?>">
                        <div class="mb-3">
                            <label for="inputName" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" name="nama" value="<?= $customer['nama'] ?>" required>
                        </div>
                        <div class="mb-3 d-flex flex-row gap-3">
                            <div class="flex-grow-1">
                                <label for="inputPhoneNumber" class="form-label">Nomor Telepon</label>
                                <input type="number" class="form-control" name="noTelp" value="<?= $customer['no_telp'] ?>" required>
                            </div>
                            <div class="flex-grow-1">
                                <label for="inputEmail" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" value="<?= $customer['email'] ?>" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="inputMessages" class="form-label">Pesan/Masukan</label>
                            <textarea type="text" class="form-control" name="pesan" rows="3" required></textarea>
                        </div>
                        <button class="button button-black mt-5" type="submit" name="submitKontak" style="width: 100%; border-radius: 7px;">Kirim
                            Masukan</button>
                    </form>
                </div>

                <div class="info-contact d-flex flex-column gap-2 col-md-6">
                    <h2>Informasi Kontak</h2>
                    <p>Apabila anda ingin bertanya, kami sangat terbuka kepada anda. Anda bisa mengirim pesan kepada kami ataupun cukup mengisi formulir pertanyaan</p>
                    <ul class="nav flex-column gap-3">
                        <li class="nav-item mb-2">
                            <div class="nav-content p-0 text-black d-flex flex-row align-items-start">
                                <i class="fa fa-map-marker-alt"> </i>
                                <span> &nbsp; &nbsp; Melati No. 1 Bandung</span>
                            </div>
                        </li>

                        <li class="nav-item mb-2">
                            <div class="nav-content p-0 text-black d-flex flex-row align-items-start">
                                <i class="fa fa-phone-alt"> </i>
                                <a href="https://wa.me/082166271806" style="text-decoration:none; color: #000">
                                    <span> &nbsp; &nbsp;081212121212</span>
                                </a>
                            </div>
                        </li>

                        <li class="nav-item mb-2">
                            <div class="nav-content p-0 text-black d-flex flex-row align-items-start">
                                <i class="fa fa-envelope"> </i>
                                <a href="mailto: spatola@gmail.com" style="text-decoration:none; color: #000">
                                    <span>&nbsp; &nbsp;spatola@gmail.com</span>
                                </a>
                            </div>
                        </li>

                        <li class="nav-item mb-2">
                            <div class="nav-content p-0 text-black d-flex flex-row align-items-start">
                                <i class="fab fa-instagram"> </i>
                                <a href="https://www.instagram.com/spatola_cake/" style="text-decoration:none; color: #000">
                                    <span>&nbsp; &nbsp;spatola_cake</span>
                                </a>
                            </div>
                        </li>

                        <li class="nav-item mb-2">
                            <div class="nav-content p-0 text-black d-flex flex-row align-items-start">
                                <i class="fab fa-facebook"> </i>
                                <a href="https://web.facebook.com/spatolaid" style="text-decoration:none; color: #000">
                                    <span>&nbsp; &nbsp;spatola_cake</span>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <?= view('template/customer/footer') ?>
</body>

</html>