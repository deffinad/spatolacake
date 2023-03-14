<!DOCTYPE html>
<html lang="en">

<?= view('template/customer/head') ?>

<body>
  <?= view('template/customer/navbar') ?>

  <section id="info-pengiriman">
    <div class="container">
      <h1 class="fw-bold" style="font-family: 'Poppins', sans-serif ;">Informasi Pengiriman</h1>
      <div class="row my-5">
        <div class="col data-1">
          <h3>Pengiriman produk Spatola Cake</h3>
          <li>Spatola Cake hanya menerima pemesanan khusus Kota Bandung, Kota Cimahi, dan Sekitarnya.</li>
          <li>Untuk pengiriman produk, Spatola Cake hanya menggunakan kurir instan seperti Grab Express dan Gosend.</li>
          <li>Konfirmasi pengiriman produk akan diberitahukan melalui website Spatola Cake dan Email.</li>
        </div>
      </div>
    </div>
  </section>

  <?= view('template/customer/footer') ?>
</body>

</html>