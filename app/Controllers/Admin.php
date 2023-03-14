<?php

namespace App\Controllers;

use App\Models\AdminModel;
use App\Models\AuthModel;

class Admin extends BaseController
{
    //variabel session
    protected $session;

    //variabel model
    protected $mAdmin;
    protected $mAuth;

    //function ketika controller pertama kali dijalankan
    public function __construct()
    {
        //inisialisasi model
        $this->mAdmin = new AdminModel();
        $this->mAuth = new AuthModel();
        //inisialisasi session
        $this->session = \Config\Services::session();
        $this->session->start();
    }

    //menampilkan view dashboard
    public function index()
    {
        //menampilkan data yang dibutuhkan pada dashboard dengan memanggil model
        $data['banyakProduk'] = $this->mAdmin->getBanyakProduk();
        $data['banyakPesanan'] = $this->mAdmin->getBanyakPesanan();
        $data['banyakPembayaran'] = $this->mAdmin->getBanyakPembayaran();
        $data['banyakAdmin'] = $this->mAdmin->getBanyakAdmin();
        $data['banyakUser'] = $this->mAdmin->getBanyakUser();
        $data['banyakPesan'] = $this->mAdmin->getBanyakPesan();
        $this->session->set('route', 'dashboard');

        return view('admin/dashboard', $data);
    }

    //menampilkan view masuk atau login dan prosesnya
    public function masuk()
    {
        $this->session->set('route', 'masuk');

        //jika tombol form login ditekan
        if (isset($_POST['submit'])) {

            //memanggil variabel yang ada di view
            $email = $this->request->getPost('email');
            $pass = $this->request->getPost('password');
            $currentDate = date('Y-m-d H:i:s');

            $data = $this->mAuth->login($email, $pass); //mengecek username dan password
            if ($data > 0) { //jika data nya ada
                $userData = [
                    'id_user' => $data['id_user'],
                    'nama'  => $data['nama'],
                    'email' => $data['email'],
                    'jabatan' => 'Admin',
                    'jenis_kelamin' => $data['jenis_kelamin'],
                    'diedit_pada' => $currentDate
                ];

                $this->mAuth->editUser($data['id_user'], $userData); //maka dia mengedit data
                $this->session->set('LoggedAdmin', $userData); //membuat session untuk login
                return redirect()->to('dashboard/'); //memanggil route dashboard
            } else { //jika datanya salah
                //maka menampilkan pesan
                $this->session->setFlashdata('gagal', 'Mohon Maaf Email/Password Salah');
            }
        }
        return view('admin/masuk');
    }

    //menampilkan view daftar dan prosesnya
    public function daftar()
    {
        $this->session->set('route', 'daftar');

        if (isset($_POST['submit'])) { //jika tombol submit pada form daftar ditekan
            //mengambil data pada view
            $id_user = $this->randomId();
            $email = $this->request->getPost('email');
            $nama = $this->request->getPost('nama');
            $noTelp = $this->request->getPost('noTelp');
            $jenisKelamin = $this->request->getPost('jenisKelamin') == NULL ? '' : $this->request->getPost('jenisKelamin');
            $password = $this->request->getPost('password');
            $konfirmasiPassword = $this->request->getPost('konfirmasiPassword');
            $currentDate = date('Y-m-d H:i:s');

            if ($password == $konfirmasiPassword) { //jika password sama dengan konfirmasi password
                $userData = [
                    'id_user' => $id_user,
                    'nama'  => $nama,
                    'email' => $email,
                    'password' => $password,
                    'no_telp' => $noTelp,
                    'jabatan' => 'Admin',
                    'jenis_kelamin' => $jenisKelamin,
                    'dibuat_pada' => $currentDate,
                    'status_aktif' => 1
                ];
                $this->mAuth->tambahUser($userData); //maka data ditambahkan
                $this->session->set('LoggedAdmin', $userData);
                return redirect()->to('dashboard/'); //dan langsung mengarah pada halaman dashboard
            } else { //jika data salah maka menampilkan pesan
                $this->session->setFlashdata('gagal', 'Mohon Maaf Konfirmasi Password Tidak Sesuai');
            }
        }
        return view('admin/daftar');
    }

    //function random id untuk id user ketika proses daftar
    function randomId()
    {
        $id = 0;
        for ($i = 0; $i < 20; $i++) {
            $id .= mt_rand(0, 9);
        }
        return $id;
    }

    //menampilkan view daftar pelanggan 
    public function akunPelanggan()
    {
        $data['user'] = $this->mAdmin->getUser('')->getResult(); //memanggil data customer
        $this->session->set('route', 'akunpelanggan');
        return view('admin/akunPelanggan', $data);
    }

    //proses pencarian akun pelanggan
    public function pencarianAkunPelanggan()
    {
        $output = '';
        $keyword = '';

        if ($this->request->getPost('keyword')) { //jika data pada form diisi
            $keyword = $this->request->getPost('keyword'); //maka memanggil data keyword pada form
        }
        $user = $this->mAdmin->getUser($keyword)->getResult(); //mengambil data customer berdasarkan keyword yang dicari
        if (count($user) == 0) { //jika data customer tidak ada
            //menampilkan view data tidak ditemukan
            $output .= '
                <div class="w-full d-flex justify-content-center align-items-center" style="height: 50vh;">
                    <h1>Data Tidak Ditemukan</h1>
                </div>
            ';
        } else {
            //menampilkan tabel dengan data customer
            $output .= '
                <table class="table table-borderless">
                    <thead>
                        <tr class="tabel-1">
                            <th scope="col">Email User</th>
                            <th scope="col">Nama Pelanggan</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>

                    <tbody class="table-group-divider table-bordered list-wrapper">
            ';
            foreach ($user as $dataUser) {
                $output .= '
                    <tr class="list-item">
                        <td>' . $dataUser->email . '</td>
                        <td>' . $dataUser->nama . '</td>
                        <td>
                            <div class="d-flex flex-row gap-2 justify-content-center">
                                <a data-bs-toggle="modal" href="#modalHapus" data-id="' . $dataUser->id_user . '" data-email="' . $dataUser->email . '" role="button" class="btn btn-danger">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                ';
            }
            $output .= '
                    </tbody>
                </table>
            ';
        }

        //mengembalikan output
        echo $output;
    }

    //proses menghapus akun customer dengan parameter id dan email
    public function hapusPelanggan($id, $email)
    {
        $result = $this->mAdmin->hapusUser($id); //menghapus data customer dengan id yang akan dihapus
        if ($result) { //jika berhasil dihapus
            //menampilkan pesan
            $this->session->setFlashdata('sukses', 'Data Akun Pelanggan Dengan Email <strong>' . $email . ' </strong>Berhasil Dihapus');
        } else { //jika gagal dihapus
            //menampilkan pesan
            $this->session->setFlashdata('gagal', 'Data Akun Pelanggan Dengan Email <strong>' . $email . ' </strong>Gagal Dihapus');
        }

        $this->session->set('route', 'akunpelanggan');
        //mengarahkan dengan route ke akun pelanggan
        return redirect()->to('akunpelanggan/');
    }

    //menampilkan view daftar admin
    public function akunAdmin()
    {
        $data['admin'] = $this->mAdmin->getAdmin('')->getResult(); //mengambil data admin dari model
        $this->session->set('route', 'akunadmin');
        return view('admin/akunAdmin', $data);
    }

    //proses pencarian data admin
    public function pencarianAkunAdmin()
    {
        $output = '';
        $keyword = '';

        if ($this->request->getPost('keyword')) { //jika keyword yang dicari diisi
            $keyword = $this->request->getPost('keyword'); //maka mengambil data keyword dari view
        }
        $admin = $this->mAdmin->getAdmin($keyword)->getResult(); //mengambil data dengan keyword yang akan dicari pada model
        if (count($admin) == 0) { //jika data admin kosong
            //maka menampilkan view data tidak ditemukan
            $output .= '
                <div class="w-full d-flex justify-content-center align-items-center" style="height: 50vh;">
                    <h1>Data Tidak Ditemukan</h1>
                </div>
            ';
        } else { //jika data admin tidak kosong
            //menampilkan tabel dengan daftar data admin
            $output .= '
                <table class="table table-borderless">
                    <thead>
                        <tr class="tabel-1">
                            <th scope="col">Email Admin</th>
                            <th scope="col">Nama Admin</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>

                    <tbody class="table-group-divider table-bordered list-wrapper">
            ';
            foreach ($admin as $dataAdmin) {
                $output .= '
                    <tr class="list-item">
                        <td>' . $dataAdmin->email . '</td>
                        <td>' . $dataAdmin->nama . '</td>
                        <td>
                            <div class="d-flex flex-row gap-2 justify-content-center">
                                <a data-bs-toggle="modal" href="#modalEdit" data-id="' . $dataAdmin->id_user . '" data-email="' . $dataAdmin->email . '" role="button" class="btn btn-warning">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <a data-bs-toggle="modal" href="#modalHapus" data-id="' . $dataAdmin->id_user . '" data-email="' . $dataAdmin->email . '" role="button" class="btn btn-danger">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                ';
            }
            $output .= '
                    </tbody>
                </table>
            ';
        }

        //mengembalikan variabel output
        echo $output;
    }

    //proses menghapus admin
    public function hapusAdmin($idUser, $email)
    {
        $result = $this->mAdmin->hapusUser($idUser); //menghapus data admin dengan parameter id pada model
        if ($result) { //jika berhasil dihapus
            //maka menampilkan pesan
            $this->session->setFlashdata('sukses', 'Data Akun Admin Dengan Email <strong>' . $email . ' </strong>Berhasil Dihapus');
        } else { //jika tidak berhasil
            //menampilkan pesan
            $this->session->setFlashdata('gagal', 'Data Akun Admin Dengan Email <strong>' . $email . ' </strong>Gagal Dihapus');
        }

        $this->session->set('route', 'akunpelanggan');
        return redirect()->to('akunadmin/'); //mengarahkan pada route akun admin
    }

    //proses mengedit akun admin berdasarkan email dan id user
    public function editAdmin($idUser, $email)
    {

        //mengambil data pada view
        $passwordLama = $this->request->getPost('passwordLama');
        $passwordBaru = $this->request->getPost('passwordBaru');
        $konfirmasiPassword = $this->request->getPost('konfirmasiPassword');

        $dataAdmin = $this->mAdmin->getAdmin('')->getResult(); //mengambil semua data admin
        $password = '';

        //mengambil password lama pada akun admin
        foreach ($dataAdmin as $data) { //looping data admin
            if ($data->id_user == $idUser) { //mengecek id user apakah sesuai dengan yang ada pada database
                $password = $data->password; //mengambil password lama
            }
        }

        if ($passwordLama && $passwordBaru && $konfirmasiPassword) { //mengecek jika passwordnya tidak kosong
            if ($password == $passwordLama) { //jika password yang baru sama dengan password lama
                if ($passwordBaru == $konfirmasiPassword) { // kondisi dimana password baru sama dengan konfirmasi password
                    $data = [
                        'password' => $passwordBaru
                    ];
                    $result = $this->mAdmin->editUser($idUser, $data); //mengedit data admin dengan data password yang baru
                    if ($result) { //jika data admin berhasil diedit
                        //maka menampilkan pesan berhasil
                        $this->session->setFlashdata('sukses', 'Data Akun Admin Dengan Email <strong>' . $email . ' </strong>Berhasil Diedit');
                    } else {
                        //maka menampilkan pesan gagal
                        $this->session->setFlashdata('gagal', 'Data Akun Admin Dengan Email <strong>' . $email . ' </strong>Gagal Diedit');
                    }
                } else { //menampilkan pesan bahwa konfirmasi tidak sama
                    $this->session->setFlashdata('gagal', 'Konfirmasi Password Tidak Sama');
                }
            } else {
                //menampilkan pesan bahwa password lama tidak sesuai
                $this->session->setFlashdata('gagal', 'Password Lama Tidak Sesuai');
            }
        }

        return redirect()->to('akunadmin'); //memanggil route akun admin
    }

    //menampilkan view pesan
    public function pesan()
    {
        $data['kontak'] = $this->mAdmin->getKontak()->getResult(); //mengambil semua data kontak pada model
        $this->session->set('route', 'pesan');
        return view('admin/pesan', $data);
    }

    //proses menghapus pesan dengan parameter id kontak
    public function hapusPesan($idKontak)
    {
        $result = $this->mAdmin->hapusKontak($idKontak); //menghapus kontak berdasarkan id yang akan dihapus pada model
        if ($result) { //jika berhasil dihapus
            //maka menampilkan pesan berhasil
            $this->session->setFlashdata('sukses', 'Pesan Berhasil Dihapus');
        } else { //maka menampilkan pesan gagal
            $this->session->setFlashdata('gagal', 'Pesan Gagal Dihapus');
        }

        $this->session->set('route', 'pesan');
        return redirect()->to('pesan');
    }

    //menampilkan view pengembalian
    public function pengembalian()
    {
        $data['pengembalian'] = $this->mAdmin->getPengembalian()->getResult(); //mengambil semua data pengembalian pada model
        $this->session->set('route', 'pengembalian');
        return view('admin/pengembalian', $data);
    }

    //proses menghapus pengembalian dengan parameter id pengembalian
    public function hapusPengembalian($idPengembalian)
    {
        $result = $this->mAdmin->hapusPengembalian($idPengembalian); //menghapus pengembalian berdasarkan id yang akan dihapus pada model
        if ($result) { //jika berhasil dihapus
            //maka menampilkan pesan berhasil
            $this->session->setFlashdata('sukses', 'Pengembalian Berhasil Dihapus');
        } else { //maka menampilkan pesan gagal
            $this->session->setFlashdata('gagal', 'Pengembalian Gagal Dihapus');
        }

        $this->session->set('route', 'pengembalian');
        return redirect()->to('pengembalian');
    }

    public function buktiGambar($gambar){
        $data['gambar'] = $gambar;
        return view('admin/buktiGambar', $data);
    }

    //proses keluar
    public function keluar()
    {
        $this->session->set('route', 'logout');
        //proses menghapus session
        $this->session->remove('LoggedAdmin');

        if (!($this->session->get('LoggedAdmin'))) { //jika berhasil dihapus session
            $this->session->setFlashdata('sukses', "Berhasil Keluar"); //menampilkan pesan berhasil
        }
        return redirect()->to('masukadmin');
    }
}
