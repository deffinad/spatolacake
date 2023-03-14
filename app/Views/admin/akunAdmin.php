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
                        <h1 class="title">Akun Admin</h1>
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

                <div class="d-flex">
                    <a href="<?= base_url('daftaradmin') ?>" class="button button-green mb-5">Tambah Admin</a>
                </div>

                <div id="data">
                    <?php if (count($admin) == 0) { ?>
                        <div class="w-full d-flex justify-content-center align-items-center" style="height: 50vh;">
                            <h1>Data Tidak Ditemukan</h1>
                        </div>
                    <?php } else { ?>
                        <table class="table table-borderless">
                            <thead>
                                <tr class="tabel-1">
                                    <th scope="col">Email Admin</th>
                                    <th scope="col">Nama Admin</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>

                            <tbody class="table-group-divider table-bordered list-wrapper">
                                <?php foreach ($admin as $dataAdmin) { ?>
                                    <tr class="list-item">
                                        <td><?= $dataAdmin->email ?></td>
                                        <td><?= $dataAdmin->nama ?></td>
                                        <td>
                                            <div class="d-flex flex-row gap-2 justify-content-center">
                                                <a data-bs-toggle="modal" href="#modalEdit" data-id="<?= $dataAdmin->id_user ?>" data-email="<?= $dataAdmin->email ?>" role="button" class="btn btn-warning">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                                <a data-bs-toggle="modal" href="#modalHapus" data-id="<?= $dataAdmin->id_user ?>" data-email="<?= $dataAdmin->email ?>" role="button" class="btn btn-danger">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    <?php } ?>
                </div>

                <div id="dataFilter"></div>

            </div>

            <div class="modal fade p-3" id="modalEdit" tabindex="-1" aria-labelledby="exampleModalLabel">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header" style="border: none">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body py-2 px-4 text-center">
                            <h4 class="modal-title mb-3">Edit Admin</h4>
                            <form method="POST" id="formEdit">
                                <div class="mb-3 text-start">
                                    <input type="text" class="form-control py-2" style="background-color: #f4f4f4" id="email" name="email" placeholder="Masukan Email" readonly />
                                </div>
                                <div class="mb-3 text-start">
                                    <input type="password" class="form-control py-2" style="background-color: #f4f4f4" name="passwordLama" placeholder="Ketik Password Lama" required />
                                </div>
                                <div class="mb-3 text-start">
                                    <input type="password" class="form-control py-2" style="background-color: #f4f4f4" name="passwordBaru" placeholder="Ketik Password Baru" required />
                                </div>
                                <div class="mb-3 text-start">
                                    <input type="password" class="form-control py-2" style="background-color: #f4f4f4" name="konfirmasiPassword" placeholder="Konfirmasi Password Baru" required />
                                </div>
                                <button type="submit" class="button my-4 w-100 py-2">
                                    Edit
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade p-3" id="modalHapus" tabindex="-1" aria-labelledby="exampleModalLabel">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Pemberitahuan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-4">
                            Apakah anda yakin akan menghapus data admin dengan email <span class="fw-bold email"></span> ini?
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
                            url: "<?= base_url('pencarianakunadmin'); ?>",
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
                    $(this).find("a").attr("href", "<?= base_url('/akunadmin/hapus') ?>" + "/" + id + '/' + email)
                });

                $('#modalEdit').on('show.bs.modal', function(event) {
                    var email = $(event.relatedTarget).data('email');
                    var id = $(event.relatedTarget).data('id');
                    $(this).find("#email").val(email);
                    $(this).find("#formEdit").attr('action', '<?= base_url('/akunadmin/edit') ?>' + "/" + id + '/' + email);
                });
            </script>

            <?= view('template/admin/footer') ?>
        </div>
    </div>
</body>

</html>