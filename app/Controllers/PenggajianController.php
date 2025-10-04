<?php

namespace App\Controllers;

use App\Models\PenggajianModel;
use App\Models\AnggotaModel;
use App\Models\KomponenGajiModel;

class PenggajianController extends BaseController
{
    protected $penggajianModel;
    protected $anggotaModel;
    protected $komponenGajiModel;

    public function __construct()
    {
        $this->penggajianModel = new PenggajianModel();
        $this->anggotaModel = new AnggotaModel();
        $this->komponenGajiModel = new KomponenGajiModel();
    }

    public function index()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'Admin') {
            return redirect()->to('/login');
        }

        $data['penggajian'] = $this->penggajianModel->getPenggajianWithDetails();
        $data['anggota'] = $this->anggotaModel->findAll();
        $data['komponen'] = $this->komponenGajiModel->findAll();
        return view('penggajian/index', $data);
    }

    public function create()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'Admin') {
            return redirect()->to('/login');
        }

        $data['anggota'] = $this->anggotaModel->findAll();
        $data['komponen'] = $this->komponenGajiModel->findAll();
        return view('penggajian/create', $data);
    }

    public function store()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'Admin') {
            return redirect()->to('/login');
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'id_anggota' => 'required|integer|greater_than[0]',
            'id_komponen_gaji' => 'required|integer|greater_than[0]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'id_anggota' => $this->request->getPost('id_anggota'),
            'id_komponen_gaji' => $this->request->getPost('id_komponen_gaji')
        ];

        // Cek apakah kombinasi sudah ada
        $existing = $this->penggajianModel->where($data)->first();
        if ($existing) {
            return redirect()->back()->withInput()->with('error', 'Kombinasi ID Anggota dan Komponen Gaji sudah ada!');
        }

        $this->penggajianModel->save($data);
        return redirect()->to('/penggajian')->with('success', 'Data penggajian berhasil ditambahkan!');
    }

    public function edit($id_komponen_gaji, $id_anggota)
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'Admin') {
            return redirect()->to('/login');
        }

        $penggajian = $this->penggajianModel->where(['id_komponen_gaji' => $id_komponen_gaji, 'id_anggota' => $id_anggota])->first();
        if (!$penggajian) {
            return redirect()->to('/penggajian')->with('error', 'Data penggajian tidak ditemukan!');
        }

        $data['penggajian'] = $penggajian;
        $data['anggota'] = $this->anggotaModel->findAll();
        $data['komponen'] = $this->komponenGajiModel->findAll();
        return view('penggajian/edit', $data);
    }

    public function update($id_komponen_gaji, $id_anggota)
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'Admin') {
            return redirect()->to('/login');
        }

        $penggajian = $this->penggajianModel->where(['id_komponen_gaji' => $id_komponen_gaji, 'id_anggota' => $id_anggota])->first();
        if (!$penggajian) {
            return redirect()->to('/penggajian')->with('error', 'Data penggajian tidak ditemukan!');
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'id_anggota' => 'required|integer|greater_than[0]',
            'id_komponen_gaji' => 'required|integer|greater_than[0]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $newData = [
            'id_anggota' => $this->request->getPost('id_anggota'),
            'id_komponen_gaji' => $this->request->getPost('id_komponen_gaji')
        ];

        // Cek apakah kombinasi baru sudah ada (kecuali data yang sama)
        $existing = $this->penggajianModel->where($newData)->first();
        if ($existing && ($existing['id_anggota'] != $id_anggota || $existing['id_komponen_gaji'] != $id_komponen_gaji)) {
            return redirect()->back()->withInput()->with('error', 'Kombinasi ID Anggota dan Komponen Gaji sudah ada!');
        }

        $this->penggajianModel->update([$id_komponen_gaji, $id_anggota], $newData);
        return redirect()->to('/penggajian')->with('success', 'Data penggajian berhasil diperbarui!');
    }

    public function delete($id_komponen_gaji, $id_anggota)
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'Admin') {
            return redirect()->to('/login');
        }

        $penggajian = $this->penggajianModel->where(['id_komponen_gaji' => $id_komponen_gaji, 'id_anggota' => $id_anggota])->first();
        if (!$penggajian) {
            return redirect()->to('/penggajian')->with('error', 'Data penggajian tidak ditemukan!');
        }

        $this->penggajianModel->delete([$id_komponen_gaji, $id_anggota]);
        return redirect()->to('/penggajian')->with('success', 'Data penggajian berhasil dihapus!');
    
        
    }

            public function detail($id_anggota)
        {
            $anggota = $this->anggotaModel->find($id_anggota);
            if (!$anggota) {
                return redirect()->to('/penggajian')->with('error', 'Data anggota tidak ditemukan!');
            }

            $penggajian = $this->penggajianModel->getPenggajianWithDetails($id_anggota);

            return view('public/penggajian_detail', [
                'penggajian' => $penggajian,
                'anggota'    => $anggota
            ]);
        }

}