<!DOCTYPE html>
<html lang="en">
<?= view('template/admin/head') ?>

<body>
    <div class="wrapper">
        <!-- Sidebar  -->
        <?= view('template/admin/sidebar') ?>

        <div id="content">
            <div class="content-main">
                <?= view('template/admin/navbar') ?>

                <div class="d-flex flex-row mb-4">
                    <div class="flex-grow-1 d-flex gap-3 flex-row align-items-center">
                        <a href="<?= base_url('kelolaproduk') ?>">
                            <i class="fas fa-arrow-left fs-3"></i>
                        </a>
                        <h1 class="title">Edit Produk</h1>
                    </div>
                </div>

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

                <?php
                $idKue = '';
                $namaKue = '';
                $kategori = '';
                $dasarKue = array();
                $deskripsi = '';
                $informasi = '';
                $fotoKue = '';
                foreach ($produk as $dataProduk) {
                    $idKue = $dataProduk->id_kue;
                    $namaKue = $dataProduk->namaKue;
                    $kategori = $dataProduk->id_kategori;
                    $deskripsi = $dataProduk->deskripsi;
                    $informasi = $dataProduk->informasi;
                    $fotoKue = $dataProduk->gambar;
                }

                foreach ($lapisanKue as $val) {
                    array_push($dasarKue, $val->nama);
                }
                if ($input) {
                    if ($input['namaKue']) {
                        $namaKue = $input['namaKue'];
                    }
                    if ($input['idKue']) {
                        $idKue = $input['idKue'];
                    }
                    if (array_key_exists('kategori', $input)) {
                        $kategori = $input['kategori'];
                    }

                    if (array_key_exists('dasarKue', $input)) {
                        $dasarKue = array();
                        foreach ($input['dasarKue'] as $val) {
                            array_push($dasarKue, $val);
                        }
                    } else {
                        $dasarKue = array();
                    }
                    if ($input['deskripsi']) {
                        $deskripsi = $input['deskripsi'];
                    }
                    if ($input['informasi']) {
                        $informasi = $input['informasi'];
                    }
                }
                ?>

                <div class="content-box">
                    <form action="<?= base_url('kelolaproduk/edit/' . $idKue) ?>" method="POST" enctype="multipart/form-data">
                        <div class="row detail mb-3">
                            <div class="col-4">
                                <label for="inputId" class="form-label">ID Kue</label>
                                <input type="text" class="form-control" value="<?= $idKue ?>" name="idKue" readonly />
                            </div>
                            <div class="col-4">
                                <label for="inputId" class="form-label">Nama Kue</label>
                                <input type="text" class="form-control" name="namaKue" value="<?= $namaKue ?>" />
                            </div>
                            <div class="col-4">
                                <label for="inputName" class="form-label">Kategori</label>
                                <select class="form-select py-2" name="kategori">
                                    <option selected disabled>Pilih Kategori</option>
                                    <?php foreach ($listKategori as $dataKategori) { ?>
                                        <option value="<?= $dataKategori->id_kategori ?>" <?php if ($kategori == $dataKategori->id_kategori) {
                                                                                                echo 'selected';
                                                                                            } ?>>
                                            <?= $dataKategori->nama ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="row detail mb-3">
                            <div class="col-6">
                                <label for="inputPhoneNumber" class="form-label">Dasar Kue</label>
                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="dasarKue[]" value="Lapis Surabaya" <?php if (in_array('Lapis Surabaya', $dasarKue)) {
                                                                                                                                            echo 'checked';
                                                                                                                                        } ?>>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                Lapis Surabaya
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="dasarKue[]" value="Pondan Sponge Cake" <?php if (in_array('Pondan Sponge Cake', $dasarKue)) {
                                                                                                                                                echo 'checked';
                                                                                                                                            } ?>>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                Pondan Sponge Cake
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="dasarKue[]" value="Vanilla Sponge Cake" <?php if (in_array('Vanilla Sponge Cake', $dasarKue)) {
                                                                                                                                                echo 'checked';
                                                                                                                                            } ?>>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                Vanilla Sponge Cake
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="dasarKue[]" value="Double Chocolate" <?php if (in_array('Double Chocolate', $dasarKue)) {
                                                                                                                                            echo 'checked';
                                                                                                                                        } ?>>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                Double Chocolate
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="dasarKue[]" value="Chocolate Sponge Cake" <?php if (in_array('Chocolate Sponge Cake', $dasarKue)) {
                                                                                                                                                echo 'checked';
                                                                                                                                            } ?>>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                Chocolate Sponge Cake
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="dasarKue[]" value="Cotton Cake" <?php if (in_array('Cotton Cake', $dasarKue)) {
                                                                                                                                        echo 'checked';
                                                                                                                                    } ?>>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                Cotton Cake
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <label for="inputDate" class="form-label">Foto Kue</label>
                                <div class="d-flex flex-row gap-3">
                                    <img src="<?= base_url('gambarProduk/' . $fotoKue) ?>" id="previewProduk" alt="foto kue" class="rounded" style="width: 120px; height: 120px;">

                                    <div class="d-flex flex-grow-1 align-items-center" style="height: 120px;">
                                        <input type="file" class="form-control" name="fotoKue" onchange="previewGambar(this);" />
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="row detail mb-3">
                            <div class="col-12">
                                <label for="inputAddress" class="form-label">Ukuran Kue</label>

                                <div class="row">
                                    <div class="col-2">
                                        <input type="number" class="form-control" placeholder="cm" name="ukuran" />
                                    </div>
                                    <div class="col-2">
                                        <input type="text" class="form-control" placeholder="harga" name="harga" />
                                    </div>
                                    <div class="col-2">
                                        <button class="button button-green" type="submit" name="submitUkuran">Simpan</button>
                                    </div>
                                </div>

                                <div class="row my-4">
                                    <?php foreach ($ukuranKue as $dataUkuranKue) { ?>
                                        <div class="col-6 mt-3">
                                            <div class="box-ukuran d-flex flex-row justify-content-between align-items-center">
                                                <div class="d-flex flex-column">
                                                    <label class="fw-bold">Ukuran</label>
                                                    <span><?= $dataUkuranKue->ukuran ?></span>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <label class="fw-bold">Harga</label>
                                                    <span>Rp<?= number_format($dataUkuranKue->harga, 0, ',', '.') ?></span>
                                                </div>

                                                <button type="submit" name="submitHapus" value="<?= $dataUkuranKue->id_ukurankue ?>" class="btn btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>

                            </div>
                        </div>

                        <div class="row detail mb-3">
                            <div class="col-6">
                                <label for="inputId" class="form-label">Deskripsi</label>
                                <textarea type="text" class="form-control" name="deskripsi" style="height: 250px;"><?= $deskripsi ?></textarea>
                            </div>
                            <div class="col-6">
                                <label for="inputName" class="form-label">Informasi</label>
                                <textarea type="text" class="form-control" name="informasi" style="height: 250px;"><?= $informasi ?></textarea>
                            </div>
                        </div>

                        <div class="d-flex mt-4 justify-content-end">
                            <button class="button button-green px-5 py-2" type="submit" name="simpanProduk">Edit</button>
                        </div>
                    </form>
                </div>
            </div>

            <script>
                $('.noEnterSubmit').bind('keypress', false);

                function previewGambar(input) {
                    if (input.files && input.files[0]) {
                        var reader = new FileReader()
                        reader.onload = function(e) {
                            $('#previewProduk').attr('src', e.target.result).removeClass('d-none')
                            localStorage.setItem('previewGambar', reader.result)
                        }
                        reader.readAsDataURL(input.files[0])
                    }
                }
            </script>

            <?= view('template/admin/footer') ?>
        </div>
    </div>
</body>

</html>