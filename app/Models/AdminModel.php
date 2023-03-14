<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    //mengambil banyak produk dengan status produknya aktif
    public function getBanyakProduk()
    {
        return $this->db->table('t_kue')->where('status_aktif', 1)->countAllResults();
    }

    //mengambil banyak data pesanan dengan status pesanan aktif
    public function getBanyakPesanan()
    {
        return $this->db->table('t_pemesanan')->where('status_aktif', 1)->countAllResults();
    }

    //mengambil banyak data pembayaran berdasarkan bukti pembayarannya kosong dan status aktif nya kosong
    public function getBanyakPembayaran()
    {
        $where = array(
            'konfirmasi_status' => 'Selesaikan Pembayaran',
            'status_aktif' => 0
        );
        return $this->db->table('t_pemesanan')->where($where)->countAllResults();
    }

    //mengambil banyak data admin berdasarkan jabatannya admin
    public function getBanyakAdmin()
    {
        return $this->db->table('t_user')->where('jabatan', 'Admin')->countAllResults();
    }

    //mengambil banyak data customer berdasarkan jabatannya customer
    public function getBanyakUser()
    {
        return $this->db->table('t_user')->where('jabatan', 'Customer')->countAllResults();
    }

    //mengambil banyak pesanan 
    public function getBanyakPesan()
    {
        return $this->db->table('t_kontak')->countAllResults();
    }

    //mengambil get user berdasarkan keyword
    public function getUser($keyword)
    {
        return $this->db->table('t_user')->where(['jabatan' => 'Customer', 'status_aktif' => 1])->like('nama', $keyword)->get();
    }

    //mengambil get admin berdasarkan admin
    public function getAdmin($keyword)
    {
        return $this->db->table('t_user')->where(['jabatan' => 'Admin', 'status_aktif' => 1])->like('nama', $keyword)->get();
    }

    //menghapus user berdasarkan id user
    public function hapusUser($idUser)
    {
        return $this->db->table('t_user')->where('id_user', $idUser)->set('status_aktif', 0)->update();
    }

    //mengedit user dengan parameter id user dan data
    public function editUser($idUser, $data)
    {
        return $this->db->table('t_user')->where('id_user', $idUser)->set($data)->update();
    }

    //menampilkan semua kontak
    public function getKontak()
    {
        return $this->db->table('t_kontak')->get();
    }
    //menghapus kontak berdasarkan id kontak
    public function hapusKontak($idKontak)
    {
        return $this->db->table('t_kontak')->where('id_kontak', $idKontak)->delete();
    }
    
    //menampilkan semua pengembalian
    public function getPengembalian()
    {
        return $this->db->table('t_pengembalian')->get();
    }
    //menghapus pembelian berdasarkan id pengembalian
    public function hapusPengembalian($idPengembalian)
    {
        return $this->db->table('t_pengembalian')->where('id_pengembalian', $idPengembalian)->delete();
    }
}
