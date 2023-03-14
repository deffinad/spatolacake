<?php

namespace App\Models;

use CodeIgniter\Model;

class PemesananModel extends Model
{
    //mengambil semua pemesanan
    public function getPemesanan($keyword)
    {
        return $this->db->table('t_pemesanan as p')
            ->select('p.id_pemesanan, p.id_user, p.id_keranjang, p.tgl_pemesanan, p.tgl_perkiraanselesai, p.konfirmasi_status, p.total_pembayaran, u.email, u.nama, u.no_telp, u.alamat, u.jabatan, u.jenis_kelamin, k.total, k.catatan, k.diskon, k.biaya_pengiriman')
            ->join('t_user as u', 'p.id_user = u.id_user')
            ->join('t_keranjang as k', 'p.id_keranjang = k.id_keranjang')
            ->orderBy('p.id_pemesanan DESC')
            ->where('p.status_aktif', 1)
            ->like('p.id_pemesanan', $keyword)
            ->get();
    }
    //mengambil detail pemesanan form
    public function getDetailPemesananForm($idPemesanan)
    {
        return $this->db->table('t_pemesanan as p')
            ->select('p.id_pemesanan, p.id_user, p.id_keranjang, p.tgl_pemesanan, p.tgl_perkiraanselesai, p.konfirmasi_status, p.total_pembayaran, u.email, u.nama, u.no_telp, u.alamat, k.total, k.catatan, k.diskon, k.biaya_pengiriman')
            ->join('t_formulirpemesanan as u', 'p.id_pemesanan = u.id_pemesanan')
            ->join('t_keranjang as k', 'p.id_keranjang = k.id_keranjang')
            ->orderBy('p.id_pemesanan DESC')
            ->where('p.id_pemesanan', $idPemesanan)
            ->get();
    }
    //mengambil detail pemesanan
    public function getDetailPemesanan($idPemesanan)
    {
        return $this->db->table('t_pemesanan as p')
            ->select('p.id_pemesanan, p.id_user, p.id_keranjang, p.tgl_pemesanan, p.tgl_perkiraanselesai, p.konfirmasi_status, p.total_pembayaran, u.email, u.nama, u.no_telp, u.alamat, k.total, k.catatan, k.diskon, k.biaya_pengiriman')
            ->join('t_user as u', 'p.id_user = u.id_user')
            ->join('t_keranjang as k', 'p.id_keranjang = k.id_keranjang')
            ->orderBy('p.id_pemesanan DESC')
            ->where('p.id_pemesanan', $idPemesanan)
            ->get();
    }
    //mengambil histori pemesanan
    public function getHistoriPemesanan($idUser, $keyword)
    {
        return $this->db->table('t_pemesanan as p')
            ->select('p.id_pemesanan, p.id_user, p.id_keranjang, p.tgl_pemesanan, p.tgl_perkiraanselesai, p.konfirmasi_status, p.status_aktif, p.total_pembayaran, u.email, u.nama, u.no_telp, u.alamat, k.total, k.catatan, k.diskon, k.biaya_pengiriman')
            ->join('t_user as u', 'p.id_user = u.id_user')
            ->join('t_keranjang as k', 'p.id_keranjang = k.id_keranjang')
            ->orderBy('p.id_pemesanan DESC')
            ->where('p.id_user', $idUser)
            ->like('p.tgl_pemesanan', $keyword)
            ->get();
    }
    //mengecek customer sudah bayar apa belum
    public function sudahBayar($idUser)
    {
        return $this->db->table('t_pemesanan')->where('id_user', $idUser)->get();
    }
    //menambah pemesanan
    public function tambahPemesanan($data)
    {
        return $this->db->table('t_pemesanan')->set($data)->insert();
    }
    //menambah form pemesanan
    public function tambahFormPemesanan($data)
    {
        return $this->db->table('t_formulirpemesanan')->set($data)->insert();
    }
    //mengedit pemesanan 
    public function editPemesanan($idPemesanan, $data)
    {
        return $this->db->table('t_pemesanan')->set($data)->where('id_pemesanan', $idPemesanan)->update();
    }
    //mengedit form pemesanan 
    public function editFormPemesanan($idPemesanan, $data)
    {
        return $this->db->table('t_formulirpemesanan')->set($data)->where('id_pemesanan', $idPemesanan)->update();
    }
    //menghapus pemesanan
    public function hapusPemesanan($idPemesanan)
    {
        return $this->db->table('t_pemesanan')->where('id_pemesanan', $idPemesanan)->set('status_aktif', 0)->update();
    }
    //mengambil id terakhir dari pemesanan
    public function getIdTerakhir()
    {
        return $this->db->table('t_pemesanan')->selectMax('id_pemesanan')->get()->getRow('id_pemesanan');
    }
    //mengambil id berikutnya dari pemesanan
    public function getIdBerikutnya($id)
    {
        if ($id == '') {
            $nomorBerikutnya = 'ORDR001';
        } else {
            $huruf = substr($id, 0, 4);
            $tempNomor = (int) substr($id, 4, null);
            $nomor = $tempNomor + 1;

            $nomorString = sprintf('%03s', $nomor);
            $nomorBerikutnya = $huruf . $nomorString;
        }
        return $nomorBerikutnya;
    }
}
