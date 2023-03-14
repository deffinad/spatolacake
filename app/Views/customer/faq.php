<!DOCTYPE html>
<html lang="en">

<?= view('template/customer/head') ?>

<body>
  <?= view('template/customer/navbar') ?>

  <section id="faq">
    <div class="container">
      <h1 class="fw-bold">FAQ</h1>
      <div class="row my-4">
        <div class="col data-faq">
          <h3>Apakah Spatola Cake terdapat offline store?</h3>
          <p>Saat ini Spatola Cake hanya terdapat di online store.</p>
        </div>
      </div>
      <div class="row my-4">
        <div class="col data-faq">
          <h3>Apakah produk Spatola Cake selalu menyediakan produk yang fresh?</h3>
          <p>Spatola Cake selalu mengutamakan kuliatas dan produk yang kami buat merupakan produk homemade dan tentunya fresh from the oven.</p>
        </div>
      </div>
      <div class="row my-4">
        <div class="col data-faq">
          <h3>Apakah pelanggan dapat memilih ukuran dan bentuk kue lainnya?</h3>
          <p>Pelanggan dapat memilih ukuran yang diinginkan sesuai dengan ketersediaan yang terdapat di website Spatola Cake.</p>
        </div>
      </div>
      <div class="row my-4">
        <div class="col data-faq">
          <h3>Apakah terdapat refund (pengembalian) produk?</h3>
          <p>Spatola Cake selalu mengutamakan kepuasan pelanggan. Jika produk tersebut tidak sesuai dengan
            pilihan pelanggan, silahkan untuk menghubungi kami dalam waktu 1 x 24 jam. Untuk melihat lebih
            detail mengenai pengembalian produk, anda bisa melihat di halaman <a href="<?= base_url('refund') ?>">Pengembalian Produk</a>
          </p>
        </div>
      </div>
    </div>
  </section>

  <?= view('template/customer/footer') ?>
</body>

</html>