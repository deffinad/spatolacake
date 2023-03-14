<!DOCTYPE html>
<html lang="en">

<?= view('template/customer/head') ?>

<body>
  <?= view('template/customer/navbar') ?>

  <section id="refund">
    <div class="container">
      <h1 class="fw-bold" style="font-family: 'Poppins', sans-serif ;">Kebijakan Pengembalian</h1>

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

      <div class="row refund-content my-5">
        <div class="form-refund col-md-6">
          <form method="POST" action="<?= base_url('refund/') ?>" enctype="multipart/form-data">
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
              <label for="inputMessages" class="form-label">Alasan Pengembalian</label>
              <textarea type="text" class="form-control" name="alasan" rows="4" required></textarea>
            </div>
            <div class="mb-3">
              <label for="inputMessages" class="form-label">Bukti Gambar Produk Yang Diterima</label>
              <input type="file" class="form-control" name="buktiGambar" required>
            </div>
            <button class="button button-black mt-5" type="submit" name="submitPengembalian" style="width: 100%; border-radius: 7px;">Kirim
              Masukan</button>
          </form>
        </div>

        <div class="info-refund d-flex flex-column gap-2 col-md-6">
          <h2>Kebijakan dalam pengembalian produk Spatola Cake</h2>
          <ul>
            <li>Jika terdapat kesalahan produk, seperti ukuran dan pilihan produk yang tidak sesuai dengan yang ada di halamanan pesanan. Silahkan untuk mengisi formulir pengembalian produk dan menyertakan bukti gambar produk yang diterima oleh pelanggan.</li>
            <li>Konfirmasi pengembalian produk akan kami proses secepat mungkin.</li>
            <li>Proses pengembalian akan kami hubungi melalui whatsapp.</li>
            <li>Pastikan anda mengecek kembali produk, deskripsi produk, dan jumlah produk. Karena kami tidak bertanggung jawab apablia terjadi kesalahan pemesanan.</li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <?= view('template/customer/footer') ?>
</body>

</html>