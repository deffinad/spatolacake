<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdukModel extends Model
{
    //mengambil data produk berdasarkan kategori
    public function getKategoriLanding()
    {
        return $this->db->table('t_kue as k')
            ->select('k.id_kue, k.nama as namaKue, k.gambar, k.deskripsi, k.informasi, kt.nama as namaKategori')
            ->join('t_kategori as kt', 'k.id_kategori = kt.id_kategori')
            ->groupBy('k.id_kategori')
            ->where('status_aktif', 1)
            ->get();
    }

    //mengambil semua kategori
    public function getKategori()
    {
        return $this->db->table('t_kategori')->get();
    }
    //mengambil dasar kue berdasarkan berdasarkan id kue
    public function getDasarKue($idKue)
    {
        return $this->db->table('t_dasarkue')->where('id_kue', $idKue)->get();
    }
    //mengambil semua dasar kue
    public function getSemuaDasarKue()
    {
        return $this->db->table('t_dasarkue')->get();
    }
    //menghapus dasar kue berdasarkan id kue
    public function hapusDasarKue($idKue)
    {
        return $this->db->table('t_dasarkue')->where('id_kue', $idKue)->delete();
    }
    //mengambil ukuran kue berdasarkan id kue
    public function getUkuranKue($idKue)
    {
        return $this->db->table('t_ukurankue')->where('id_kue', $idKue)->get();
    }
    //menambah ukuran kue
    public function tambahUkuranKue($data)
    {
        return $this->db->table('t_ukurankue')->set($data)->insert();
    }
    //menghapus ukuran kue
    public function hapusUkuranKue($id_ukurankue)
    {
        return $this->db->table('t_ukurankue')->where('id_ukurankue', $id_ukurankue)->delete();
    }
    //mengambil semua produk berdasarkan kategori
    public function getSemuaProduk($kategori)
    {
        return $this->db->table('t_kue as k')
            ->select('k.id_kue, k.nama as namaKue, k.gambar, k.deskripsi, k.informasi, kt.nama as namaKategori, kt.id_kategori, u.id_ukurankue, u.ukuran, u.harga')
            ->join('t_kategori as kt', 'k.id_kategori = kt.id_kategori')
            ->join('t_ukurankue as u', 'k.id_kue = u.id_kue')
            ->groupBy('k.id_kue')
            ->where('status_aktif', 1)
            ->like('kt.nama', $kategori)
            ->get();
    }
    //mengambil data produk berdasarkan kategori dan id produk
    public function pilihanLain($idKategori, $idProduk)
    {
        return $this->db->table('t_kue as k')
            ->select('k.id_kue, k.nama as namaKue, k.gambar, k.deskripsi, k.informasi, kt.nama as namaKategori,  kt.id_kategori, u.id_ukurankue, u.ukuran, u.harga')
            ->join('t_kategori as kt', 'k.id_kategori = kt.id_kategori')
            ->join('t_ukurankue as u', 'k.id_kue = u.id_kue')
            ->groupBy('k.id_kue')
            ->where(['k.id_kategori' => $idKategori, 'k.id_kue !=' => $idProduk, 'status_aktif' => 1])
            ->get();
    }
    //mengambil data produk berdasarkan id kue
    public function getProdukById($idKue)
    {
        return $this->db->table('t_kue as k')
            ->select('k.id_kue, k.nama as namaKue, k.gambar, k.deskripsi, k.informasi, kt.nama as namaKategori, kt.id_kategori, u.id_ukurankue, u.ukuran, u.harga')
            ->join('t_kategori as kt', 'k.id_kategori = kt.id_kategori')
            ->join('t_ukurankue as u', 'k.id_kue = u.id_kue')
            ->groupBy('k.id_kue')
            ->where('k.id_kue', $idKue)
            ->get();
    }
    //menambah produk
    public function tambahProduk($data)
    {
        return $this->db->table('t_kue')->set($data)->insert();
    }
    //menambah dasar kue
    public function tambahDasarKue($data)
    {
        return $this->db->table('t_dasarkue')->set($data)->insert();
    }
    //mengedit edit produk
    public function editProduk($idKue, $data)
    {
        return $this->db->table('t_kue')->set($data)->where('id_kue', $idKue)->update();
    }
    //menghapus produk
    public function hapusProduk($idKue)
    {
        return $this->db->table('t_kue')->set('status_aktif', 0)->where('id_kue', $idKue)->update();
    }
    //mengambil id terakhir dari produk
    public function getIdTerakhir()
    {
        return $this->db->table('t_kue')->selectMax('id_kue')->get()->getRow('id_kue');
    }
    //mengambil id berikutanya dari produk
    public function getIdBerikutnya($id)
    {
        if ($id == '') {
            $nomorBerikutnya = 'K001';
        } else {
            $huruf = substr($id, 0, 1);
            $tempNomor = (int) substr($id, 1, null);
            $nomor = $tempNomor + 1;

            $nomorString = sprintf('%03s', $nomor);
            $nomorBerikutnya = $huruf . $nomorString;
        }
        return $nomorBerikutnya;
    }

    //mengambil data produk berdasarkan nama kue
    public function pencarian($namaKue)
    {
        return $this->db->table('t_kue as k')
            ->select('k.id_kue, k.nama as namaKue, k.gambar, k.deskripsi, k.informasi, kt.nama as namaKategori, kt.id_kategori, u.id_ukurankue, u.ukuran, u.harga')
            ->join('t_kategori as kt', 'k.id_kategori = kt.id_kategori')
            ->join('t_ukurankue as u', 'k.id_kue = u.id_kue')
            ->groupBy('k.id_kue')
            ->where('status_aktif', 1)
            ->like('k.nama', $namaKue)
            ->get();
    }
    //mengambil data produk berdasarkan harga
    public function filterHarga($filter, $namaKue)
    {
        return $this->db->table('t_kue as k')
            ->select('k.id_kue, k.nama as namaKue, k.gambar, k.deskripsi, k.informasi, kt.nama as namaKategori, kt.id_kategori, u.id_ukurankue, u.ukuran, u.harga')
            ->join('t_kategori as kt', 'k.id_kategori = kt.id_kategori')
            ->join('t_ukurankue as u', 'k.id_kue = u.id_kue')
            ->groupBy('k.id_kue')
            ->where('status_aktif', 1)
            ->orderBy('u.harga', $filter)
            ->like('k.nama', $namaKue)
            ->get();
    }
}
