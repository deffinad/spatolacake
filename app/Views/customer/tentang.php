<!DOCTYPE html>
<html lang="en">
<?= view('template/customer/head') ?>

<body>
  <?= view('template/customer/navbar') ?>

  <section id="heading-1">
    <div class="content">
      <h3>Tentang Spatola Cake</h3>
      <p>Dimulai sejak tahun 2004</p>
    </div>
  </section>

  <section id="about-1" class="d-flex justify-content-center align-items-center gap-3">
    <div class="row about-1-content shadow">
      <div class="image col-md-5 text-center">
        <img src="<?= base_url('assets/images/sc-2.png') ?>">
      </div>

      <div class="header d-flex flex-column justify-content-center col-md-7 gap-3">
        <h1>Spatola Cake</h1>
        <p>Spatola Cake berdiri pada tahun 2004 dimulai tanpa nama dan hanya menjual khusus kue kering pada saat hari raya Idul Fitri.
          Kemudian pendiri Spatola Cake memulai mempromosikan berbagai produk kue dan kukisnya pada tahun 2016 dengan menggunakan merk Spatola Cake.
          Spatola Cake menawarkan berbagai macam jenis-jenis kue, seperti whole cake, kue ulang tahun, dessert box, kue kering dan roti.</p>
      </div>


    </div>
  </section>

  <section id="about-2" class="d-flex justify-content-center align-items-center gap-3">
    <div class="row about-2-content shadow">
      <div class="header d-flex flex-column justify-content-center col-md-7 gap-3">
        <h1>Homemade Cake & Cookies</h1>
        <p>Produk kami dibuat 100% homemade dan selalu fresh from the oven. Kami menawarkan kue-kue yang berkualitas sekaligus memberikan kontribusi terbaik kami untuk anda, baik untuk merayakan, memperingati, atau untuk menyebar kesenangan terhadap orang tersayang.</p>
      </div>
      <div class="image col-md-5 text-center d-flex justify-content-center align-items-center">
        <img src="<?= base_url('assets/images/contoh5.png') ?>" class="shadow">
      </div>
    </div>
  </section>

  <section id="about-3" class="d-flex justify-content-center align-items-center gap-3">
    <div class="row about-3-content shadow">
      <div class="image col-md-5 text-center d-flex justify-content-center align-items-center">
        <img src="<?= base_url('assets/images/contoh20.png') ?>" class="shadow">
      </div>
      <div class="header d-flex flex-column justify-content-center col-md-7 gap-3">
        <h1>Bahan dan Kualitas Premium</h1>
        <p>Spatola Cake memiliki ciri khas pada cake dan krim, dengan bahan-bahan premium dan kualitas kelezatan yang membuat siapapun akan kembali untuk membeli produk kami.
          Spatola Cake yang bertempat di Kota Bandung, sudah memberikan kontribusi terbaik kami untuk melayani pelanggan dengan kemampuan kami dalam mendekorasi kue, memanggang kue dan lainnya dengan bahan-bahan yang berkualitas tinggi.
          Kue yang kami buat menggunakan keju premium terbaik, cokelat terbaik, mentega alami murni, dan tanpa aditif atau pengawet.</p>
      </div>
    </div>
  </section>

  <?= view('template/customer/footer') ?>
</body>

</html>