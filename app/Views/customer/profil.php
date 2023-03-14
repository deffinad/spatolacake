<!DOCTYPE html>
<html lang="en">
<?= view('template/customer/head') ?>

<body>
    <?= view('template/customer/navbar') ?>

    <section id="profile">
        <div class="container">
            <h1 class="fw-bold" style="font-family: 'Poppins', sans-serif ;">Profil Anda</h1>

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

            <div class="row my-5">
                <div class="col-md-7 data-profile">
                    <form action="" method="POST">
                        <div class="mb-3">
                            <label for="inputName" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" name="nama" value="<?= $customer['nama'] ?>" required>
                        </div>
                        <div class="mb-3 d-flex flex-row gap-3">
                            <div class="flex-grow-1">
                                <label for="inputPhoneNumber" class="form-label">No.Telepon</label>
                                <input type="text" class="form-control" name="noTelp" value="<?= $customer['no_telp'] ?>" required>
                            </div>

                            <div class="flex-grow-1">
                                <label for="inputEmail" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" value="<?= $customer['email'] ?>" required readonly>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="inputGender" class="form-label">Jenis Kelamin</label>
                            <select class="form-select" style="background-color: white; border-radius: 7px;" name="jenisKelamin" required>
                                <option selected disabled>Pilih Jenis Kelamin</option>
                                <option <?php if ($customer['jenis_kelamin'] == "Laki-Laki") {
                                            echo 'selected';
                                        } ?>>Laki-Laki</option>
                                <option <?php if ($customer['jenis_kelamin'] == "Perempuan") {
                                            echo 'selected';
                                        } ?>>Perempuan</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="inputGender" class="form-label">Alamat</label>
                            <textarea type="text" class="form-control" name="alamat" style="height: 150px;"><?= $customer['alamat'] ?></textarea>
                        </div>
                        <div class="d-flex mt-5 flex-row gap-3">
                            <button class="button button-black" type="submit" name="submitProfil" style="width: 100%; border-radius: 7px;">Ubah
                                Profil</button>
                        </div>

                    </form>
                </div>

                <div class="data-diskon col-md-5 d-flex flex-column justify-content-start gap-4" style="padding-left: 2rem;">
                    <?php foreach ($promo as $prom) {
                        $tgl_dibuat = DateTime::createFromFormat('Y-m-d', $prom->tanggal_dibuat);
                        $tanggal = $tgl_dibuat->format('d F Y');
                        $tgl_dibuat = $tanggal;

                        $tgl_berakhir = DateTime::createFromFormat('Y-m-d', $prom->tanggal_berakhir);
                        $tanggal = $tgl_berakhir->format('d F Y');
                        $tgl_berakhir = $tanggal;
                    ?>
                        <div class="diskon d-flex flex-column justify-content-center align-items-center">
                            <span class="head">Kode Diskon</span>
                            <span class="body mt-3">Potongan Rp<?= number_format($prom->potongan, 0, ',', '.') ?></span>
                            <span class="text-center mt-2">Berlaku hingga <?= $tgl_dibuat ?> - <?= $tgl_berakhir ?></span>
                            <button type="button" class="button button-black mt-4 border-0 toogle toogle-<?= $prom->nama ?>" data-copy="<?= $prom->nama ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="Copy to Clipboard">
                                <span class="text-uppercase px-3 py-1"><?= $prom->nama ?></span>
                            </button>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>

    <?= view('template/customer/footer') ?>
</body>

</html>