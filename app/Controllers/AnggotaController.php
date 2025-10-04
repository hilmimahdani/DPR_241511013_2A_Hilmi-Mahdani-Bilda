<?php

namespace App\Controllers;

use App\Models\AnggotaModel;

class AnggotaController extends BaseController
{
    protected $anggotaModel;

    public function __construct()
    {
        $this->anggotaModel = new AnggotaModel();
    }

    public function index()
    {
        if (! session()->get('logged_in') || session()->get('role') !== 'Admin') {
            return redirect()->to('/login');
        }

        $seacrh = $this->request->getGet('search');
        $data['anggota'] = $this->anggotaModel->getAnggotaWithSearch($seacrh);

        return view('anggota/index', $data);
    }

    public function create()
    {
        if (! session()->get('logged_in') || session()->get('role') !== 'Admin') {
            return redirect()->to('/login');
        }
        return view('anggota/create');
    }
    
    public function store()
    {
        if (! session()->get('logged_in') || session()->get('role') !== 'Admin') {
            return redirect()->to('/login');
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'nama_depan' => 'required',
            'nama_belakang' => 'required',
            'jabatan' => 'required|in_list[Ketua,Wakil Ketua,Anggota]',
            'status_pernikahan' => 'required|in_list[Kawin,Belum Kawin]',
            'jumlah_anak' => 'required|integer|greater_than_equal_to[0]'
        ]);

        if (! $validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $this->anggotaModel->save([
            'gelar_depan' => $this->request->getPost('gelar_depan'),
            'nama_depan' => $this->request->getPost('nama_depan'),
            'nama_belakang' => $this->request->getPost('nama_belakang'),
            'gelar_belakang' => $this->request->getPost('gelar_belakang'),
            'jabatan' => $this->request->getPost('jabatan'),
            'status_pernikahan' => $this->request->getPost('status_pernikahan'),
            'jumlah_anak' => $this->request->getPost('jumlah_anak')
        ]);

        return redirect()->to('/anggota')->with('success', 'Data anggota berhasil ditambahkan!');
    }

    public function edit($id)
    {
        if (! session()->get('logged_in') || session()->get('role') !== 'Admin') {
            return redirect()->to('/login');
        }

        $data['anggota'] = $this->anggotaModel->find($id);
        if (! $data['anggota']) {
            return redirect()->to('/anggota')->with('error', 'Data anggota tidak ditemukan!');
        }

        return view('anggota/edit', $data);
    }

    public function update($id)
    {
        if (! session()->get('logged_in') || session()->get('role') !== 'Admin') {
            return redirect()->to('/login');
        }

        $anggota = $this->anggotaModel->find($id);
        if (!$anggota) {
            return redirect()->to('/anggota')->with('error', 'Data anggota tidak ditemukan!');
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'nama_depan' => 'required',
            'nama_belakang' => 'required',
            'jabatan' => 'required|in_list[Ketua,Wakil Ketua,Anggota]',
            'status_pernikahan' => 'required|in_list[Kawin,Belum Kawin]',
            'jumlah_anak' => 'required|integer|greater_than_equal_to[0]'
        ]);

        if (! $validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $this->anggotaModel->update($id, [
            'gelar_depan' => $this->request->getPost('gelar_depan'),
            'nama_depan' => $this->request->getPost('nama_depan'),
            'nama_belakang' => $this->request->getPost('nama_belakang'),
            'gelar_belakang' => $this->request->getPost('gelar_belakang'),
            'jabatan' => $this->request->getPost('jabatan'),
            'status_pernikahan' => $this->request->getPost('status_pernikahan'),
            'jumlah_anak' => $this->request->getPost('jumlah_anak')
        ]);

        return redirect()->to('/anggota')->with('success', 'Data anggota berhasil diperbarui!');
    }

    public function delete($id)
    {
        if (! session()->get('logged_in') || session()->get('role') !== 'Admin') {
            return redirect()->to('/login');
        }

        // Cek apakah ID valid
        log_message('error', 'ID yang diterima di deleter:' . $id);
        if (!$id || !is_numeric($id) || $id == 0) {
            return redirect()->to('/anggota')->with('error', 'ID tidak valid!');
        }
        
        
        
        $anggota = $this->anggotaModel->find($id);
        if (!$anggota) {
            log_message('error', 'Data dengan ID ' . $id . ' tidak ditemukan');
            return redirect()->to('/anggota')->with('error', 'Data anggota tidak ditemukan!');
        }

        $result = $this->anggotaModel->delete($id);
        $this->anggotaModel->delete($id);
        return redirect()->to('/anggota')->with('success', 'Data anggota berhasil dihapus!');
    }

    public function publicIndex()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'Public') {
            return redirect()->to('/login');
        }
        $data['anggota'] = $this->anggotaModel->findAll(); // Ambil semua data
        return view('public/anggota', $data);
    }

}

