<?php

namespace App\Controllers;

use App\Models\AnggotaModel;
use App\Models\PenggajianModel;
use App\Models\KomponenGajiModel;

class PublicController extends BaseController
{
    protected $anggotaModel;
    protected $penggajianModel;
    protected $komponenGajiModel;

    public function __construct()
    {
        $this->anggotaModel = new AnggotaModel();
        $this->penggajianModel = new PenggajianModel();
        $this->komponenGajiModel = new KomponenGajiModel();
    }

    public function anggota()
    {
        $data['anggota'] = $this->anggotaModel->findAll();
        return view('public/anggota', $data);
    }

    public function penggajian()
    {
        $data['penggajian'] = $this->penggajianModel->getPenggajianWithDetails();
        return view('public/penggajian', $data);
    }

    public function penggajianDetail($id_anggota)
    {
        $data['penggajian'] = $this->penggajianModel->getPenggajianWithDetails($id_anggota);
        $data['anggota'] = $this->anggotaModel->find($id_anggota);
        if (!$data['anggota']) {
            return redirect()->to('/public/penggajian')->with('error', 'Anggota tidak ditemukan!');
        }
        return view('public/penggajian_detail', $data);
    }
}