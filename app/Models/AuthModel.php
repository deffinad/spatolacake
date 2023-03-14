<?php

namespace App\Models;

use CodeIgniter\Model;

class AuthModel extends Model
{
    //mengecek user terdaftar dengan parameter id user
    public function userTerdaftar($idUser)
    {
        return $this->db->table('t_user')->where('id_user', $idUser)->get()->getRowArray() > 0 ? true : false;
    }
    //mengecek email dan password untuk login
    public function login($email, $password)
    {
        return $this->db->table('t_user')->where(['email' => $email, 'password' => $password])->get()->getRowArray();
    }
    //menambah user dengan data data user
    public function tambahUser($data)
    {
        return $this->db->table('t_user')->set($data)->insert();
    }
    //mengedit user dengan parameter id user dan data
    public function editUser($idUser, $data)
    {
        return $this->db->table('t_user')->where('id_user', $idUser)->set($data)->update();
    }
    //mengambil customer berdasarkan id
    public function getCustomerById($idCustomer)
    {
        return $this->db->table('t_user')->where('id_user', $idCustomer)->get();
    }
}
