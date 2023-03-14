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
                    <div class="flex-grow-1 d-flex align-items-start">
                        <h1 class="title">Akun Pelanggan</h1>
                    </div>

                    <div class="search d-flex align-items-start">
                        <form class="flex-fill">
                            <div class="input-group">
                                <input type="text" class="form-control" id="filter" placeholder="Cari berdasarkan nama" name="keyword" />
                                <button class="btn" type="submit" name="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </form>
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

                <div id="data">
                    <?php if (count($user) == 0) { ?>
                        <div class="w-full d-flex justify-content-center align-items-center" style="height: 50vh;">
                            <h1>Data Tidak Ditemukan</h1>
                        </div>
                    <?php } else { ?>
                        <table class="table table-borderless">
                            <thead>
                                <tr class="tabel-1">
                                    <th scope="col">Email User</th>
                                    <th scope="col">Nama Pelanggan</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>

                            <tbody class="table-group-divider table-bordered list-wrapper">
                                <?php foreach ($user as $dataUser) { ?>
                                    <tr class="list-item">
                                        <td><?= $dataUser->email ?></td>
                                        <td><?= $dataUser->nama ?></td>
                                        <td>
                                            <div class="d-flex flex-row gap-2 justify-content-center">
                                                <a data-bs-toggle="modal" href="#modalHapus" data-id="<?= $dataUser->id_user ?>" data-email="<?= $dataUser->email ?>" role="button" class="btn btn-danger">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <div id="pagination-container"></div>
                    <?php } ?>
                </div>

                <div id="dataFilter"></div>
            </div>

            <div class="modal fade p-3" id="modalHapus" tabindex="-1" aria-labelledby="exampleModalLabel">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Pemberitahuan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-4">
                            Apakah anda yakin akan menghapus data pelanggan dengan email <span class="fw-bold email"></span> ini?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                Tidak
                            </button>
                            <a class="btn btn-primary">Ya</a>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                $(document).ready(function() {
                    function load_data(query) {
                        $.ajax({
                            url: "<?= base_url('pencarianakunpelanggan'); ?>",
                            method: "POST",
                            data: {
                                keyword: query,
                            },
                            success: function(data) {
                                $('#dataFilter').html(data);
                            }
                        })
                    }

                    $('#filter').keyup(function() {
                        var search = $(this).val();
                        if (search != '') {
                            $('#dataFilter').css('display', 'block')
                            $('#data').css('display', 'none')
                        } else {
                            $('#dataFilter').css('display', 'none')
                            $('#data').css('display', 'block')
                        }
                        load_data(search)
                    });
                });

                $('#modalHapus').on('show.bs.modal', function(event) {
                    var email = $(event.relatedTarget).data('email');
                    var id = $(event.relatedTarget).data('id');
                    $(this).find(".email").text(email);
                    $(this).find("a").attr("href", "<?= base_url('/akunpelanggan/hapus') ?>" + "/" + id + '/' + email)
                });
            </script>

            <?= view('template/admin/footer') ?>
        </div>
    </div>
</body>

</html>