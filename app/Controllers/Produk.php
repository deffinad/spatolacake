<?php

namespace App\Controllers;

use App\Models\ProdukModel;

class Produk extends BaseController
{
    //variabel session
    protected $session;
    //variabel model
    protected $mProduk;
    //variabel validation
    protected $validation;

    public function __construct()
    {
        //inisialisasi variabel
        $this->mProduk = new ProdukModel();
        $this->session = \Config\Services::session();
        $this->validation = \Config\Services::validation();
        $this->session->start();
    }

    //menampilkan view katalog
    public function katalog($keyword = '')
    {
        $data['produk'] = $this->mProduk->getSemuaProduk($keyword)->getResult(); //mengambil data produk sesuai dengan keyword, untuk pertama kali keywordnya di set kosong
        $data['kategori'] = $this->mProduk->getKategoriLanding()->getResult(); //mengambil data produk berdasarkan kategori
        $this->session->set('route', 'katalog');
        return view('customer/katalog', $data);
    }

    //proses pencarian data produk berdasarkan katalog
    public function dataKatalog()
    {
        $output = '';
        $keyword = '';

        if ($this->request->getPost('keyword')) {
            $keyword = $this->request->getPost('keyword');
        }
        $produk = $this->mProduk->getSemuaProduk($keyword)->getResult(); //mengambil data produk berdasarkan keyword yang akan dicari

        if (count($produk) > 0) { //jika datanya ada
            foreach ($produk as $dataProduk) { //maka menampilkan data tersebut
                $output .= '
                    <div class="col-md-6 list-item">
                        <div class="box d-flex flex-column shadow">
                        <div class="user">
                            <div class="image">
                            <img src="' . base_url('gambarProduk/' . $dataProduk->gambar) . '" alt="">
                            </div>
                            <div class="user-info">
                            <h3>' . $dataProduk->namaKue . '</h3>
                            <span>Rp' . number_format($dataProduk->harga, 0, ',', '.') . '</span>
                            </div>
                        </div>
                        <div class="content d-flex flex-row justify-content-center align-items-center gap-3">
                            <a href="' . base_url('detailproduk/' . $dataProduk->id_kue) . '" class="button button-green my-3 flex-grow-1 ">Pesan Sekarang</a>
                        </div>
                        </div>
                    </div>
                ';
            }
        } else { //jika kosong maka menampilkan view data tidak ditemukan
            $output .= '
                <div class="w-full d-flex justify-content-center align-items-center" style="height: 50vh;">
                <h1>Data Tidak Ditemukan</h1>
                </div>
            ';
        }

        //mengembalikan variabel output
        echo $output;
    }

    //menampilkan view detail produk dengan parameter id produk
    public function detailProduk($idProduk)
    {
        $data['detailProduk'] = $this->mProduk->getProdukById($idProduk)->getResult(); //mengambil data detail produk pada model
        $data['ukuranKue'] = $this->mProduk->getUkuranKue($idProduk)->getResult(); //mengambil data ukuran kue berdasarkan id produk
        $data['dasarKue'] = $this->mProduk->getDasarKue($idProduk)->getResult(); //mengambil data dasar kue berdasarkan id produk

        $id_kategori = ''; //mengambil id kategori dari data detail produk
        foreach ($data['detailProduk'] as $val) {
            $id_kategori = $val->id_kategori;
        }

        $data['pilihanLain'] = $this->mProduk->pilihanLain($id_kategori, $idProduk)->getResult(); //mengambil data pilihan lain  
        $this->session->set('route', 'katalog');
        return view('customer/detailProduk', $data);
    }

    //menampilkan view kelola produk
    public function kelolaProduk()
    {
        $data['produk'] = $this->mProduk->getSemuaProduk('')->getResult(); //mengambil data semua produk
        $arrK1 = array(); //variabel untuk kategori 1
        $arrK2 = array(); //variabel untuk kategori 2
        $arrK3 = array(); //variabel untuk kategori 3
        $arrK4 = array(); //variabel untuk kategori 4

        foreach ($data['produk'] as $produk) { //looping produk
            if ($produk->namaKategori == 'Whole Cake') { //jika kategori 1
                array_push($arrK1, $produk); //maka di push ke array K1
            } else if ($produk->namaKategori == 'Kue Ulang Tahun') {
                array_push($arrK2, $produk);
            } else if ($produk->namaKategori == 'Dessert Box') {
                array_push($arrK3, $produk);
            } else if ($produk->namaKategori == 'Kue Kering & Roti') {
                array_push($arrK4, $produk);
            }
        }

        //membuat data produk sesuai kategori yang nantinya akan dikirim ke view
        $data['produkK1'] = $arrK1;
        $data['produkK2'] = $arrK2;
        $data['produkK3'] = $arrK3;
        $data['produkK4'] = $arrK4;
        $this->session->set('route', 'kelolaproduk');
        return view('admin/kelolaProduk', $data);
    }

    //proses pencarian produk
    public function pencarianProduk()
    {
        $output = '';
        $keyword = '';

        if ($this->request->getPost('keyword')) { //jika keyword diisi pada view
            $keyword = $this->request->getPost('keyword'); //maka mengambil data keyword pada view
        }

        $produk = $this->mProduk->pencarian($keyword)->getResult(); //mengambil data produk berdasarkan keyword yang akan dicari

        $output .= '
            <div class="catalog-body">
                <div class="row list-wrapper">
        ';
        if (count($produk) > 0) { //jika data produk ada
            foreach ($produk as $dataProduk) { //maka menampilkan data produk
                $output .= '
                    <div class="col-md-6 list-item">
                        <div class="box d-flex flex-column shadow">
                            <div class="user">
                                <div class="image">
                                    <img src="' . base_url('gambarProduk/' . $dataProduk->gambar) . '" alt="">
                                </div>
                                <div class="user-info">
                                    <h3>' . $dataProduk->namaKue . '</h3>
                                    <span>Rp' . number_format($dataProduk->harga, 0, ',', '.') . '</span>
                                </div>
                            </div>
                            <div class="content d-flex flex-row justify-content-center align-items-center gap-3">
                                <a href="' . base_url('kelolaproduk/edit/' .  $dataProduk->id_kue) . '" class="button button-green flex-grow-1">Edit</a>
                                <a data-bs-toggle="modal" href="#modalHapus" data-id="' . $dataProduk->id_kue . '" role="button" class="button button-green flex-grow-1">Hapus</a>
                            </div>
                        </div>
                    </div>
                ';
            }
        } else { //jika data produk tidak ada
            //menampilkan view data tidak ditemukan
            $output .= '
                <div class="w-full d-flex justify-content-center align-items-center" style="height: 50vh;">
                    <h1>Data Tidak Ditemukan</h1>
                </div>
            ';
        }
        $output .= '
                </div>
            </div>
        ';

        //mengembalikan variabel ouput
        echo $output;
    }

    //menampilkan view tambah produk dan proses
    public function tambahProduk()
    {
        $this->session->set('route', 'kelolaproduk');
        $id = $this->mProduk->getIdTerakhir(); //mengambil id terakhir dari data produk

        $nextId = $this->mProduk->getIdBerikutnya($id); //mengambil id berikutnya dari data produk
        $id_kue = $this->mProduk->getProdukById($id)->getRow('id_kue'); //mengambil id kue terakhir
        $nama_kue = $this->mProduk->getProdukById($id)->getRow('namaKue'); //mengambil nama kue terakhir
        $harga = $this->mProduk->getProdukById($id)->getRow('harga'); //mengambil harga kue terakhir

        if ($id_kue && $nama_kue && $harga || $id == '') { //jika id masih kosong atau id kue sebelumnya sudah diisi dan nama kue sebelumnya sudah diisi dan harga sebelumnya sudah diisi
            $dataKue = [
                'id_kue' => $nextId,
                'id_kategori' => 'KT01',
                'status_aktif' => 0
            ];
            $this->mProduk->tambahProduk($dataKue); //maka menambah data produk baru
        }

        $id = $this->mProduk->getIdTerakhir(); //mengambil id terakhir dari data produk
        $data['id'] = $id;
        $data['input'] = array();
        $data['listKategori'] = $this->mProduk->getKategori()->getResult(); //mengambil semua daftar kategori

        if (isset($_POST['submitUkuran'])) { //jika tombol submit ukuran ditekan maka
            $data['input'] = $this->request->getPost(); //mengambil input yang sudah dimasukan sebelumnya
            if ($_POST['ukuran'] != '' && $_POST['harga'] != '') { //kondisi dimana ukuran dan harga harus diisi
                $dataTambah = [
                    'id_kue' => $id,
                    'ukuran' => $this->request->getPost('ukuran') . 'cm',
                    'harga' => $this->request->getPost('harga'),
                ];
                $this->mProduk->tambahUkuranKue($dataTambah); //maka tambah ukuran kue berdasarkan id produk
            }
        }

        if (isset($_POST['submitHapus'])) { //jika tombol submit hapus ukuran di tekan
            $data['input'] = $this->request->getPost(); //mengambil input yang sudah dimasukan sebelumnya
            $id_ukurankue = $_POST['submitHapus']; //mengambil id ukuran kue
            $this->mProduk->hapusUkuranKue($id_ukurankue); //menghapus ukuran kue berdasarkan id ukuran kue
        }

        if (isset($_POST['simpanProduk'])) { //jika tombol submit produk ditekan
            $file = $this->request->getFile('fotoKue'); //mengambil file foto produk
            $namaFile = $file->getRandomName(); //membuat nama file menjadi random

            if (!$this->validation->run(['fotoKue' => $file], 'gambar')) { //validasi gambar gagal (gambar produk harus diisi, gambar produk harus jpg/png/jpeg, dan ukuran file maximal 4mb)
                $data['input'] = $this->request->getPost(); //mengambil input yang sudah dimasukan sebelumnya
                $this->session->setFlashdata('gagal', 'Mohon Maaf, ' . $this->validation->getError()); //menampilkan pesan gagal
            } else { //jika validasi gambar benar
                $ukuranKue = $this->mProduk->getUkuranKue($this->request->getPost('idKue'))->getResult(); //mengambil daftar ukuran kue berdasarkan dengan id produk

                if (count($ukuranKue) == 0 || $this->request->getPost('namaKue') == '' || $this->request->getPost('kategori') == '') { //jika ukuran kue tidak diisi atau nama kue tidak diisi atau kategori tidak diisi
                    //menampilkan pesan gagal
                    $data['input'] = $this->request->getPost();
                    $this->session->setFlashdata('gagal', 'Mohon Masukan Data Dengan Benar');
                } else { //jika diisi
                    $dataKue = [
                        'nama' => $this->request->getPost('namaKue'),
                        'gambar' => $namaFile,
                        'id_kategori' => $this->request->getPost('kategori'),
                        'deskripsi' => $this->request->getPost('deskripsi'),
                        'informasi' => $this->request->getPost('informasi'),
                        'status_aktif' => 1
                    ];

                    if ($this->request->getPost('dasarKue')) { //jika dasar kue diisi
                        foreach ($this->request->getPost('dasarKue') as $val) { //looping dasar kue yang dipilih oleh customer
                            $dataDasarKue = [
                                'id_kue' => $id,
                                'nama' => $val
                            ];
                            $this->mProduk->tambahDasarKue($dataDasarKue); //memasukan dasar kue yang dipilih customer ke database
                        }
                    }

                    //mengedit produk dengan memanggil model
                    $result = $this->mProduk->editProduk($id, $dataKue);
                    if ($result) { //jika berhasil ditambahkan
                        //memindahkan file foto ke dalam folder public/gambarProduk
                        $file->move('gambarProduk/', $namaFile);
                        //menampilkan pesan berhasil
                        $this->session->setFlashdata('sukses', 'Data Produk Dengan Nama <strong>' . $this->request->getPost('namaKue') . ' </strong>Berhasil Ditambahkan');
                    } else { //jika gagal
                        //menampilkan pesan gagal
                        $this->session->setFlashdata('gagal', 'Data Produk Dengan Nama <strong>' . $this->request->getPost('namaKue') . ' </strong>Gagal Ditambahkan');
                    }
                    return redirect()->to('kelolaproduk');
                }
            }
        }
        $data['ukuranKue'] = $this->mProduk->getUkuranKue($id)->getResult(); //mengambil data ukuran kue berdasarkan id produk
        return view('admin/tambahProduk', $data);
    }

    //menampilkan view edit produk dan produk dengan parameter id produk
    public function editProduk($idProduk)
    {
        $data['input'] = array(); //mengambil input yang dimasukan 
        $data['produk'] = $this->mProduk->getProdukById($idProduk)->getResult(); //mengambil data produk berdasarkan id produk
        $data['listKategori'] = $this->mProduk->getKategori()->getResult(); //mengambil semua data produk berdasarkan kategori
        $data['lapisanKue'] = $this->mProduk->getDasarKue($idProduk)->getResult(); //menampilkan data dasar kue berdasarkan id produk

        if (isset($_POST['submitUkuran'])) { //jika tombol submit pada form edit ditekan
            $data['input'] = $this->request->getPost(); //mengambil input yang sudah dimasukan
            if ($_POST['ukuran'] != '' && $_POST['harga'] != '') { //kondisi dimana ukuran dan harga harus diisi
                $dataTambah = [
                    'id_kue' => $idProduk,
                    'ukuran' => $this->request->getPost('ukuran') . 'cm',
                    'harga' => $this->request->getPost('harga'),
                ];
                //menambah ukuran kue dengan memanggil model
                $this->mProduk->tambahUkuranKue($dataTambah);
            }
        }

        if (isset($_POST['submitHapus'])) { //jika tombol hapus pada form edit ditekan
            $data['input'] = $this->request->getPost(); //mengambil input yang sudah dimasukan
            $id_ukurankue = $_POST['submitHapus']; //mengambil id ukuran kue
            $this->mProduk->hapusUkuranKue($id_ukurankue); //menghapus ukuran kue berdasarkan id kue
        }

        if (isset($_POST['simpanProduk'])) { //jika tombol simpan produk pada form edit ditekan
            $file = $this->request->getFile('fotoKue'); //mengambil file gambar produk
            $namaFile = $file->getRandomName(); //membuat nama produk menjadi random

            $ukuranKue = $this->mProduk->getUkuranKue($this->request->getPost('idKue'))->getResult(); //mengambil data ukuran kue berdasarkan id produk

            if (count($ukuranKue) == 0 || $this->request->getPost('namaKue') == '' || $this->request->getPost('kategori') == '') { //jika ukuran kue tidak diisi, atau nama kue tidak diisi atau kategori tidak diisi
                //menampilkan pesan gagal
                $data['input'] = $this->request->getPost();
                $this->session->setFlashdata('gagal', 'Mohon Masukan Data Dengan Benar');
            } else { //jika diisi
                if ($file->getSize() == 0) { //mengecek file gambar produk jika sizenya 0 atau tidak diisi
                    //menginisialisi data produk tidak menggunakan gambar
                    $dataKue = [
                        'nama' => $this->request->getPost('namaKue'),
                        'id_kategori' => $this->request->getPost('kategori'),
                        'deskripsi' => $this->request->getPost('deskripsi'),
                        'informasi' => $this->request->getPost('informasi')
                    ];
                } else { //jika gambar produk diisi
                    //menginisialisi data produk menggunakan gambar
                    $dataKue = [
                        'nama' => $this->request->getPost('namaKue'),
                        'gambar' => $namaFile,
                        'id_kategori' => $this->request->getPost('kategori'),
                        'deskripsi' => $this->request->getPost('deskripsi'),
                        'informasi' => $this->request->getPost('informasi')
                    ];
                }

                $this->mProduk->hapusDasarKue($idProduk); //menghapus semua dasar kue berdasarkan id produk
                if ($this->request->getPost('dasarKue')) { //mengecek kondisi jika dasar kue diisi

                    foreach ($this->request->getPost('dasarKue') as $val) { //looping dasar kue yang dipilih ole customer
                        $dataDasarKue = [
                            'id_kue' => $idProduk,
                            'nama' => $val
                        ];

                        //menambah dasar kue dengan yang baru
                        $this->mProduk->tambahDasarKue($dataDasarKue);
                    }
                }
                //mengedit data produk dengan memanggil model
                $result = $this->mProduk->editProduk($idProduk, $dataKue);
                if ($result) { //jika berhasil
                    //dan file jika ada gambar yang baru
                    if ($file->getSize() != 0) {

                        //maka dipindahkan kedalam folder public/gambarProduk
                        $file->move('gambarProduk/', $namaFile);
                    }
                    //menampilkan pesan sukses
                    $this->session->setFlashdata('sukses', 'Data Produk Dengan Nama <strong>' . $this->request->getPost('namaKue') . ' </strong>Berhasil Diedit');
                } else { //jika gagal
                    //menampilkan pesan gagal
                    $this->session->setFlashdata('gagal', 'Data Produk Dengan Nama <strong>' . $this->request->getPost('namaKue') . ' </strong>Gagal Diedit');
                }
                return redirect()->to('kelolaproduk');
            }
        }

        $data['ukuranKue'] = $this->mProduk->getUkuranKue($idProduk)->getResult(); //mengambil data ukuran kue berdasarkan id produk
        $this->session->set('route', 'kelolaproduk');
        return view('admin/editProduk', $data);
    }
    //proses menghapus data produk berdasarkan id produk yang dipilih
    public function hapusProduk($idProduk)
    {
        $this->session->set('route', 'kelolaproduk');
        $result = $this->mProduk->hapusProduk($idProduk); //menghapus data produk dengan memanggil model
        if ($result) { //jika berhasil
            //maka menampilkan pesan berhasil
            $this->session->setFlashdata('sukses', 'Data Produk Dengan ID <strong>' . $idProduk . ' </strong>Berhasil Dihapus');
        } else { //jika gagal
            //maka menampilkan pesan gagal
            $this->session->setFlashdata('gagal', 'Data Produk Dengan ID <strong>' . $idProduk . ' </strong>Gagal Dihapus');
        }

        return redirect()->to('/kelolaproduk');
    }
}
