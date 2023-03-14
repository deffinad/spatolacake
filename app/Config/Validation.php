<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\CreditCardRules;
use CodeIgniter\Validation\FileRules;
use CodeIgniter\Validation\FormatRules;
use CodeIgniter\Validation\Rules;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var string[]
     */
    public $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    public $gambar = [
        'fotoKue' => [
            'rules' => 'uploaded[fotoKue]|mime_in[fotoKue,image/jpg,image/jpeg,image/png]|max_size[fotoKue,4096]',
            'errors' => [
                'uploaded' => 'Gambar Kue Wajib Diisi',
                'mime_in' => 'Format Gambar Kue Harus JPG/JPEG/PNG',
                'max_size' => 'Maximal Gambar Kue Harus Kurang Dari 4 MB'
            ]
        ]
    ];

    public $buktiPembayaran = [
        'buktiPembayaran' => [
            'rules' => 'uploaded[buktiPembayaran]|mime_in[buktiPembayaran,image/jpg,image/jpeg,image/png]|max_size[buktiPembayaran,4096]',
            'errors' => [
                'uploaded' => 'Bukti Pembayaran Wajib Diisi',
                'mime_in' => 'Format Bukti Pembayaran Harus JPG/JPEG/PNG',
                'max_size' => 'Maximal Bukti Pembayaran Harus Kurang Dari 4 MB'
            ]
        ]
    ];
    
    public $buktiGambar = [
        'buktiGambar' => [
            'rules' => 'uploaded[buktiGambar]|mime_in[buktiGambar,image/jpg,image/jpeg,image/png]|max_size[buktiGambar,4096]',
            'errors' => [
                'uploaded' => 'Bukti Gambar Wajib Diisi',
                'mime_in' => 'Format Bukti Gambar Harus JPG/JPEG/PNG',
                'max_size' => 'Maximal Bukti Gambar Harus Kurang Dari 4 MB'
            ]
        ]
    ];
    // --------------------------------------------------------------------
    // Rules
    // --------------------------------------------------------------------
}
