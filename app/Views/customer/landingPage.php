<!DOCTYPE html>
<html lang="en">
<?= view('template/customer/head') ?>

<body>
  <?= view('template/customer/navbar') ?>

  <section id="hero" class="d-flex justify-content-center align-items-center">
    <div class="row hero-content shadow">
      <div class="header d-flex flex-column justify-content-center col-md-7 gap-2">
        <h1 class="fw-bold">Best Cake in Town!</h1>
        <p>Spatola Cake memiliki ciri khas pada cake dan krim, dengan bahan-bahan premium dan kualitas kelezatan yang membuat siapapun akan kembali untuk membeli produk kami.
          Spatola Cake yang bertempat di Kota Bandung, sudah memberikan kontribusi terbaik kami untuk melayani pelanggan dengan kemampuan kami dalam mendekorasi kue, memanggang kue dan lainnya dengan bahan-bahan yang berkualitas tinggi.
        </p>

        <div class="info d-flex flex-row gap-2">
          <a href="<?= base_url('/tentang') ?>" class="button button-black" aria-pressed="true">Baca Selanjutnya</a>
          <a href="<?= base_url('/katalog') ?>" class="button button-black">Pesan Sekarang</a>
        </div>
      </div>

      <div class="image col-md-5 text-center">
        <img src="<?= base_url('assets/images/contoh-1.png') ?>">
      </div>
    </div>
  </section>

  <section id="info">
    <div class="container">
      <div class="d-flex flex-row justify-content-center align-items-center gap-4 ">
        <div class="box d-flex flex-column justify-content-center align-items-center gap-2 shadow">
          <img src="<?= base_url('assets/images/place.png') ?>" alt="" width="30" height="35">
          <h3>Bandung & Bandung Outside</h3>
          <span>Pengiriman khusus area Kota Bandung dan Sekitarnya</span>
        </div>

        <div class="box d-flex flex-column justify-content-center align-items-center gap-2 shadow">
          <img src="<?= base_url('assets/images/order.png') ?>" alt="" width="30" height="35">
          <h3>Made to Order</h3>
          <span>Kue akan dibuat setelah pemesanan dilakukan</span>
        </div>

        <div class="box d-flex flex-column justify-content-center align-items-center gap-2 shadow">
          <img src="<?= base_url('assets/images/cake-1.png') ?>" alt="" width="30" height="35">
          <h3>High Quality</h3>
          <span>Kue dibuat menggunakan bahan premium</span>
        </div>

      </div>
    </div>
  </section>

  <section id="about">
    <div class="row about-content shadow">
      <div class="image col-md-5">
        <img src="<?= base_url('assets/images/contoh-9.png') ?>">
      </div>

      <div class="header d-flex flex-column justify-content-center col-md-7 gap-2">
        <h1 class="fw-bold">Tentang Spatola Cake</h1>
        <p>Spatola Cake berdiri pada tahun 2004 dimulai tanpa nama dan hanya menjual khusus kue kering pada saat hari raya Idul Fitri.
          Kemudian pendiri Spatola Cake memulai mempromosikan berbagai produk kue dan kukisnya pada tahun 2016 dengan menggunakan merk Spatola Cake.
          Spatola Cake menawarkan berbagai macam jenis-jenis kue, seperti whole cake, kue ulang tahun, dessert box, kue kering dan roti.
        </p>

        <div class="d-flex flex-row gap-2">
          <a href="<?= base_url('/tentang') ?>" class="button button-black">Baca Selanjutnya</a>
        </div>
      </div>
    </div>
  </section>

  <section id="catalog">
    <div class="catalog-content d-flex flex-column justify-content-center align-items-center shadow">
      <h1 class="fw-bold">Katalog Spatola Cake</h1>
      <div class="catalog-body d-flex flex-row align-items-center justify-content-center gap-4 mt-5">
        <?php foreach ($kategori as $dataKategori) { ?>
          <a href="<?= base_url('katalog/' . $dataKategori->namaKategori) ?>" class="catalog-item d-flex flex-column justify-content-center align-items-center gap-3 shadow">
            <img src="<?= base_url('gambarProduk'), '/', $dataKategori->gambar ?>" class="rounded-circle" />
            <p><?= $dataKategori->namaKategori ?></p>
          </a>
        <?php } ?>
      </div>

    </div>
  </section>

  <section id="review">
    <div class="review-content shadow">
      <h1 class="fw-bold">Ulasan dari Pelanggan Spatola Cake</h1>
      <div class="owl-carousel owl-review" id="owl-carousel">
        <div class="item box shadow d-flex flex-column">
          <p class="flex-grow-1 d-flex align-items-center">
            Browniesnya sangat enak dan chewy, sangat cocok dimakan dengan ice cream. Klepon cakenya pun enak.
          </p>
          <div class="d-flex">
            <div class="user flex-grow-1 d-flex align-items-center align-content-center">
              <img src="<?= base_url('assets/images/org-1.jpg') ?>" alt="">
              <div class="user-info">
                <h3>Grey</h3>
                <span>Ibu Rumah Tangga</span>
              </div>
            </div>
          </div>
        </div>

        <div class="item box shadow d-flex flex-column">
          <p class="flex-grow-1 d-flex align-items-center">
            Dessert boxnya enak, kemudian untuk blueberry cheesecakenya enak sekali.
          </p>
          <div class="d-flex">
            <div class="user flex-grow-1 d-flex align-items-center align-content-center">
              <img src="<?= base_url('assets/images/org-1.jpg') ?>" alt="">
              <div class="user-info">
                <h3>Andin</h3>
                <span>Mahasiswi</span>
              </div>
            </div>
          </div>
        </div>

        <div class="item box shadow d-flex flex-column">
          <p class="flex-grow-1 d-flex align-items-center">Donut gula halusnya enak dan sangat pas dimakan hangat-hangat.</p>
          <div class="d-flex">
            <div class="user flex-grow-1 d-flex align-items-center align-content-center">
              <img src="<?= base_url('assets/images/org-1.jpg') ?>" alt="">
              <div class="user-info">
                <h3>Hani</h3>
                <span>Guru</span>
              </div>
            </div>
          </div>
        </div>

        <div class="item box shadow d-flex flex-column">
          <p class="flex-grow-1 d-flex align-items-center">Kue kering khususnya kastangle benar-benar enak dan lembut.</p>
          <div class="d-flex">
            <div class="user flex-grow-1 d-flex align-items-center align-content-center">
              <img src="<?= base_url('assets/images/org-1.jpg') ?>" alt="">
              <div class="user-info">
                <h3>Sania</h3>
                <span>Mahasiswi</span>
              </div>
            </div>
          </div>
        </div>

        <div class="item box shadow d-flex flex-column">
          <p class="flex-grow-1 d-flex align-items-center">Enak sekali kue kering putri saljunya</p>
          <div class="d-flex">
            <div class="user flex-grow-1 d-flex align-items-center align-content-center">
              <img src="<?= base_url('assets/images/org-1.jpg') ?>" alt="">
              <div class="user-info">
                <h3>Sri</h3>
                <span>Ibu Rumah Tangga</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <?= view('template/customer/footer') ?>
</body>

</html>