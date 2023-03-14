<!DOCTYPE html>
<html lang="en">

<?= view('template/customer/head') ?>

<body>
  <?= view('template/customer/navbar') ?>

  <section id="cara-pemesanan">
    <div class="container">
      <h1 class="fw-bold" style="font-family: 'Poppins', sans-serif ;">Cara Pemesanan</h1>
      <div class="row my-5">
        <div class="col data-1">
          <h3>Cara melakukan pemesanan di Spatola Cake</h3>
          <p>1. Setelah memilih produk yang diinginkan.</p>
          <p>2. Klik "Pesan Sekarang.</p>
          <p>3. Setelah masuk ke halaman keranjang anda, perhatikan kembali produk yang akan dipesan.
            Jika terdapat catatan dan kode promo, harap untuk diisi jika anda memerlukannya. </p>
          <p>4. Pastikan anda mengisi wilayah atau domisili, untuk menentukan biaya pengiriman.</p>
          <p>5. Klik “Bayar Sekarang” jika ingin melanjutkan proses pembayaran. </p>
          <p>6. Isi data formulir pemesanan.</p>
          <p>7. Setelah mengisi formulir pemesanan, dilanjutkan dengan pembayaran yang sudah dicantumkan di halaman formulir pesanan. </p>
          <p>8. Upload atau kirimkan bukti pembayaran.</p>
          <p>9. Terima kasih telah memesan produk Spatola Cake, untuk konfirmasi status akan diberitahukan kembali. Anda bisa melihat konfirmasi status di halaman <a href="<?= base_url('riwayatpemesanan') ?>">Pesanan Saya</a></p>
        </div>
      </div>
    </div>
  </section>

  <?= view('template/customer/footer') ?>
</body>

</html>