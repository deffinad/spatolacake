<?php

namespace App\Controllers;

use App\Models\AuthModel;
use App\Models\CustomerModel;
use App\Models\KodePromoModel;
use App\Models\ProdukModel;

class Customer extends BaseController
{

    // variabel untuk inisialasasi model yang digunakan pada kelas customer 
    protected $mAuth;
    protected $mKodePromo;
    protected $mCustomer;
    protected $mProduk;
    protected $session;
    protected $validation;
    //variabel untuk inisiasisasi kirim email
    protected $email;
    //variabel untuk menentukan google client (login)
    protected $googleClient = NULL;

    //function yang digunakan ketika pertama kali menjalankan kelas customer
    function __construct()
    {
        //setup google client untuk login
        $this->googleClient = new \Google\Client();
        $this->googleClient->setClientId('663627518102-ou8e5n22uv19vftdj78b5ui1r7233guh.apps.googleusercontent.com');
        $this->googleClient->setClientSecret('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');
        $this->googleClient->setRedirectUri('http://localhost:8080/masuk/loginWithGoogle');
        $this->googleClient->addScope('email');
        $this->googleClient->addScope('profile');

        //deklarasi model
        $this->mProduk = new ProdukModel();
        $this->mAuth = new AuthModel();
        $this->mKodePromo = new KodePromoModel();
        $this->mCustomer = new CustomerModel();

        //session
        $this->session = \Config\Services::session();
        $this->session->start();

        //validation
        $this->validation = \Config\Services::validation();
        
        //email
        $this->email = \Config\Services::email();
    }

    //function menampilkan view landing page
    public function index()
    {
        //memanggil model produk dengan getKategoriLanding untuk menampilkan data produk setiap kategorinya
        $data['kategori'] = $this->mProduk->getKategoriLanding()->getResult();
        $this->session->set('route', 'landingPage');
        return view('customer/landingPage', $data);
    }

    //function menampilkan view masuk/login
    public function masuk()
    {
        //menghapus token pada session
        $this->googleClient->revokeToken();
        $this->session->remove('LoggedUser');
        $this->session->remove('AccessToken');

        //membuat url agar bisa memilih akun pada browser
        $data['url'] = $this->googleClient->createAuthUrl();
        $this->session->set('route', 'masuk');
        return view('customer/masuk', $data);
    }

    //proses login
    public function loginWithGoogle()
    {
        //memanggil token pada google client
        $token = $this->googleClient->fetchAccessTokenWithAuthCode($this->request->getVar('code'));

        //jika token tidak error
        if (!isset($token['error'])) {
            //mengakses token pada google client
            $this->googleClient->setAccessToken($token['access_token']);
            //membuat 
            $this->session->set('AccessToken', $token['access_token']);
            //menginisialisasi google service untuk login
            $googleService = new \Google\Service\Oauth2($this->googleClient);

            //mengambil data profil email yang digunakan sebagai login
            $data = $googleService->userinfo->get();
            //membuat tanggal untuk database createdAt atau updateAt
            $currentDate = date('Y-m-d H:i:s');

            //jika user terdaftar pada database
            if ($this->mAuth->userTerdaftar($data['id'])) {
                $userData = [
                    'id_user' => $data['id'],
                    'nama'  => $data['givenName'] . ' ' . $data['familyName'],
                    'email' => $data['email'],
                    'jabatan' => 'Customer',
                    'jenis_kelamin' => $data['gender'] == NULL ? '' : $data['gender'],
                    'diedit_pada' => $currentDate
                ];
                //maka dia akan mengedit datanya sendiri
                $this->mAuth->editUser($data['id'], $userData);
            } else { //jika belum terdaftar
                $userData = [
                    'id_user' => $data['id'],
                    'nama'  => $data['givenName'] . ' ' . $data['familyName'],
                    'email' => $data['email'],
                    'jabatan' => 'Customer',
                    'jenis_kelamin' => $data['gender'] == NULL ? '' : $data['gender'],
                    'dibuat_pada' => $currentDate,
                    'status_aktif' => 1
                ];
                //maka dia akan menambah user baru
                $this->mAuth->tambahUser($userData);
            }

            //membuat session login dengan data yang diambil dari email
            $this->session->set('LoggedUser', $userData);
        } else { //jika tokennya error maka akan menampilkan error pada view
            $this->session->setFlashdata('gagal', 'Terjadi Kesalahan');
            return redirect()->to('masuk');
        }
        return redirect()->to('/');
    }

    //menampilkan view tentang
    public function tentang()
    {
        $this->session->set('route', 'tentang');
        return view('customer/tentang');
    }

    //menampilkan view kontak dan prosesnya
    public function kontak()
    {
        unset($_SESSION['sukses']);
        unset($_SESSION['gagal']);
        $this->session->set('route', 'kontak');

        //jika tombol submit pada kontak ditekan
        if (isset($_POST['submitKontak'])) {
            //membuat data pesan untuk ditambah ke database
            $data['pesan'] = [
                'nama' => $this->request->getPost('nama'),
                'no_telp' => $this->request->getPost('noTelp'),
                'email' => $this->request->getPost('email'),
                'pesan' => $this->request->getPost('pesan'),
            ];

            $result = $this->mCustomer->tambahKontak($data['pesan']); //menambahkan kontak pada database
            //jika datanya berhasil ditambahkan
            if ($result) {
                //membuat pesan berhasil ketika ditambahkan
                $this->session->setFlashdata('sukses', 'Pesan/Masukan Berhasil Dikirim, Terimakasih');
                //lalu mengirim data tersebut melalui email ke akun spatola cake
                $this->kirimEmailKontak($_SESSION['LoggedUser']['email'], 'andinira@upi.edu', 'Pesan/Masukan Untuk Spatola Cake', $data);

                $data['pesan'] = [
                    'nama' => $this->request->getPost('nama'),
                    'pesan' => '',
                ];
                //dan mengirim data tersebut juga ke email yang mengirim kontak pesan
                $this->kirimEmailKontak('andinira@upi.edu', $_SESSION['LoggedUser']['email'], 'Pesan/Masukan Spatola Cake', $data);
            }
        }
        //menampilkan data customer yang login ke view kontak
        $data['customer'] = $this->mAuth->getCustomerById($_SESSION['LoggedUser']['id_user'])->getRowArray();
        return view('customer/kontak', $data);
    }

    //mengirim email untuk kontak pesan
    public function kirimEmailKontak($from, $to, $title, $data)
    {
        //membuat variabel pesan dengan isi view pada kontak yang nantinya dibuat sebagai tampilan pada email
        $pesan = view('email/kontak', $data);

        if ($from == 'andinira@upi.edu') {
            $user = 'Spatola Cake';
        } else {
            $user = 'Customer Spatola Cake';
        }
        $this->email->setFrom($from, $user); //kirim email dari siapa
        $this->email->setTo($to); //kirim email untuk siapa

        $this->email->setSubject($title); //membuat subject pada email
        $this->email->setMessage($pesan); //membuat isi pada email

        if (!$this->email->send()) { //jika email gagal dikirim 
            return false; //maka returnnya bernilai false
        } else {
            return true; //jika berhasil maka bernilai true
        }
    }

    //mengirim email untuk pengembalian produk
    public function kirimEmailPengembalian($from, $to, $title, $data)
    {
        //membuat variabel pesan dengan isi view pada kontak yang nantinya dibuat sebagai tampilan pada email
        $pesan = view('email/pengembalian', $data);

        if ($from == 'andinira@upi.edu') {
            $user = 'Spatola Cake';
        } else {
            $user = 'Customer Spatola Cake';
        }
        $this->email->setFrom($from, $user); //kirim email dari siapa
        $this->email->setTo($to); //kirim email untuk siapa

        $this->email->setSubject($title); //membuat subject pada email
        $this->email->setMessage($pesan); //membuat isi pada email

        if (!$this->email->send()) { //jika email gagal dikirim 
            return false; //maka returnnya bernilai false
        } else {
            return true; //jika berhasil maka bernilai true
        }
    }

    //menampilkan view profil dan prosesnya
    public function profil()
    {
        unset($_SESSION['sukses']);
        unset($_SESSION['gagal']);
        $this->session->set('route', 'profil');

        //jika tombol profil pada form ditekan
        if (isset($_POST['submitProfil'])) {
            $idUser = $_SESSION['LoggedUser']['id_user']; //membuat variabel id user sesuai dengan user yang login
            $data = [
                'nama' => $this->request->getPost('nama'),
                'no_telp' => $this->request->getPost('noTelp'),
                'jenis_kelamin' => $this->request->getPost('jenisKelamin') == NULL ? '' : $this->request->getPost('jenisKelamin'),
                'alamat' => $this->request->getPost('alamat')
            ];
            //memanggil model auth untuk mengedit user
            $result = $this->mAuth->editUser($idUser, $data);
            //jika berhasil diedit
            if ($result) {
                //maka menampilkan pesan
                $this->session->setFlashdata('sukses', 'Data Profil Anda Berhasil Diedit');
            }
        }
        $data['customer'] = $this->mAuth->getCustomerById($_SESSION['LoggedUser']['id_user'])->getRowArray(); //memanggil data user pada model auth
        $data['promo'] = $this->mKodePromo->getKodePromo('')->getResult(); //memanggil data kode promo
        return view('customer/profil', $data);
    }

    //menampilkan view pencarian dan prosesnya
    public function pencarian()
    {
        $this->session->set('route', 'pencarian');
        $data['produk'] = ''; //inisialisasi produk dengan nilai kosong
        $data['keyword'] = ''; //keyword yang dicari dengan nilai kosong

        if (isset($_POST['submit'])) { //jika form submit ditekan
            $keyword = $this->request->getPost('keyword'); //memanggil keyword pada form di view pencarian
            $data['produk'] = $this->mProduk->pencarian($keyword)->getResult(); //memanggil data produk sesuai dengan keyword yang dicari
            $data['keyword'] = $keyword;
        }
        return view('customer/pencarian', $data);
    }

    //menampilkan data pencarian produk berdasarkan harga
    public function filterPencarian()
    {
        $output = ''; //inisialisasi output kosong
        $keyword = ''; //keyword yang dicari 
        $namaKue = ''; //namakue yang dicari

        if ($this->request->getPost('keyword')) {
            $keyword = $this->request->getPost('keyword');
            $namaKue = $this->request->getPost('namaKue');
        }

        if ($keyword == 'Harga Termahal') { //jika keyword yang dicari harga termahal
            $filter = $this->mProduk->filterHarga('DESC', $namaKue)->getResult(); //maka menampilkan produk berdasarkan harga dari yang termahal
        } else { //jika keyword yang dicari harga terkecil
            $filter = $this->mProduk->filterHarga('ASC', $namaKue)->getResult(); //maka menampilkan produk berdasarkan harga dari yang termurah 
        }

        if (count($filter) > 0) { //jika datanya tidak kosong
            foreach ($filter as $filterProduk) { //maka membuat html dengan data yang dipanggil dari database
                $output .= '
                <div class="col-md-6 list-item">
                    <div class="box d-flex flex-column shadow">
                        <div class="user">
                            <div class="image">
                                <img src="' . base_url('gambarProduk/' . $filterProduk->gambar) . '" alt="">
                            </div>
                            <div class="user-info">
                                <h3>' . $filterProduk->namaKue . '</h3>
                                <span>Rp' . number_format($filterProduk->harga, 0, ',', '.') . ' </span>
                            </div>
                        </div>
                        <div class="content d-flex flex-row justify-content-center align-items-center gap-3">
                            <a href="' . base_url('detailproduk/' . $filterProduk->id_kue) . '" class="button button-green flex-grow-1 ">Pesan Sekarang</a>
                        </div>
                    </div>
                </div>
                ';
            }
        } else { //jika datanya kosong maka menampilkan view data tidak ditemukan
            $output .= '
            <div class="w-full d-flex justify-content-center align-items-center" style="height: 50vh;">
                <h1>Data Tidak Ditemukan</h1>
            </div>
            ';
        }

        //mengembalikan variabel output
        echo $output;
    }

    //menampilkan view faq
    public function faq()
    {
        $this->session->set('route', '');
        return view('customer/faq');
    }

    //menampilkan view cara pemesanan
    public function caraPemesanan()
    {
        $this->session->set('route', '');
        return view('customer/caraPemesanan');
    }

    //menampilkan view info pengiriman
    public function infoPengiriman()
    {
        $this->session->set('route', '');
        return view('customer/infoPengiriman');
    }

    //menampilkan view refund
    public function refund()
    {
        $this->session->set('route', '');
        unset($_SESSION['sukses']);
        unset($_SESSION['gagal']);

        //jika tombol submit pada kontak ditekan
        if (isset($_POST['submitPengembalian'])) {
            $file = $this->request->getFile('buktiGambar'); //mengambil file foto produk
            $namaFile = $file->getRandomName(); //membuat nama file menjadi random

            if (!$this->validation->run(['buktiGambar' => $file], 'buktiGambar')) { //validasi gambar gagal (gambar produk harus diisi, gambar produk harus jpg/png/jpeg, dan ukuran file maximal 4mb)
                $this->session->setFlashdata('gagal', 'Mohon Maaf, ' . $this->validation->getError()); //menampilkan pesan gagal
            } else { //jika validasi gambar benar
                //membuat data pesan untuk ditambah ke database
                $data['pengembalian'] = [
                    'nama' => $this->request->getPost('nama'),
                    'no_telp' => $this->request->getPost('noTelp'),
                    'email' => $this->request->getPost('email'),
                    'alasan' => $this->request->getPost('alasan'),
                    'buktiGambar' => $namaFile
                ];
                $result = $this->mCustomer->tambahPengembalian($data['pengembalian']); //menambahkan kontak pada database
                //jika datanya berhasil ditambahkan
                if ($result) {

                    $file->move('buktiGambar/', $namaFile);

                    //membuat pesan berhasil ketika ditambahkan
                    $this->session->setFlashdata('sukses', 'Pengembalian Produk Berhasil Dikirim, Terimakasih');
                    //lalu mengirim data tersebut melalui email ke akun spatola cake
                    $this->kirimEmailPengembalian($_SESSION['LoggedUser']['email'], 'andinira@upi.edu', 'Pengembalian Produk', $data);

                    $data['pengembalian'] = [
                        'nama' => $this->request->getPost('nama'),
                        'alasan' => '',
                    ];
                    //dan mengirim data tersebut juga ke email yang mengirim kontak pesan
                    $this->kirimEmailPengembalian('andinira@upi.edu', $_SESSION['LoggedUser']['email'], 'Pengembalian Produk', $data);
                }
            }
        }
        //menampilkan data customer yang login ke view kontak
        $data['customer'] = $this->mAuth->getCustomerById($_SESSION['LoggedUser']['id_user'])->getRowArray();
        return view('customer/refund', $data);
    }

    //proses keluar aplikasi
    public function keluar()
    {
        //menghapus token pada sesssion
        $this->googleClient->revokeToken();
        $this->session->remove('LoggedUser');
        $this->session->remove('AccessToken');

        if (!($this->session->get('LoggedUser') && $this->session->get('AccessToken'))) { //jika sessionnya berhasil dihapus
            $this->session->setFlashdata('sukses', "Berhasil Keluar"); //maka menampilkan pesan sukses berhasil keluar
        }
        return redirect()->to('masuk'); //memanggil route masuk atau halaman login
    }
}
