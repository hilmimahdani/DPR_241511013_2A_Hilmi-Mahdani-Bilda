<?php

namespace App\Controllers;

use App\Models\KomponenGajiModel;

class KomponenGajiController extends BaseController
{
    protected $komponenGajiModel;

    public function __construct()
    {
        $this->komponenGajiModel = new KomponenGajiModel();
    }

    public function index()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'Admin') {
            return redirect()->to('/login');
        }

        $data['komponen'] = $this->komponenGajiModel->findAll();
        return view('komponen_gaji/index', $data);
    }

    public function create()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'Admin') {
            return redirect()->to('/login');
        }

        return view('komponen_gaji/create');
    }

    public function store()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'Admin') {
            return redirect()->to('/login');
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'nama_komponen' => 'required',
            'kategori' => 'required',
            'jabatan' => 'required|in_list[Ketua,Wakil Ketua,Anggota]',
            'nominal' => 'required|numeric',
            'satuan' => 'required|in_list[Bulanan,Tahunan]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $this->komponenGajiModel->save([
            'nama_komponen' => $this->request->getPost('nama_komponen'),
            'kategori' => $this->request->getPost('kategori'),
            'jabatan' => $this->request->getPost('jabatan'),
            'nominal' => $this->request->getPost('nominal'),
            'satuan' => $this->request->getPost('satuan')
        ]);

        return redirect()->to('/komponen_gaji')->with('success', 'Komponen gaji berhasil ditambahkan!');
    }

    public function edit($id)
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'Admin') {
            return redirect()->to('/login');
        }

        $komponen = $this->komponenGajiModel->find($id);
        if (!$komponen) {
            return redirect()->to('/komponen_gaji')->with('error', 'Komponen gaji tidak ditemukan!');
        }

        $data['komponen'] = $komponen;
        return view('komponen_gaji/edit', $data);
    }

    public function update($id)
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'Admin') {
            return redirect()->to('/login');
        }

        $komponen = $this->komponenGajiModel->find($id);
        if (!$komponen) {
            return redirect()->to('/komponen_gaji')->with('error', 'Komponen gaji tidak ditemukan!');
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'nama_komponen' => 'required',
            'kategori' => 'required',
            'jabatan' => 'required|in_list[Ketua,Wakil Ketua,Anggota]',
            'nominal' => 'required|numeric',
            'satuan' => 'required|in_list[Bulanan,Tahunan]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $this->komponenGajiModel->update($id, [
            'nama_komponen' => $this->request->getPost('nama_komponen'),
            'kategori' => $this->request->getPost('kategori'),
            'jabatan' => $this->request->getPost('jabatan'),
            'nominal' => $this->request->getPost('nominal'),
            'satuan' => $this->request->getPost('satuan')
        ]);

        return redirect()->to('/komponen_gaji')->with('success', 'Komponen gaji berhasil diperbarui!');
    }

    public function delete($id)
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'Admin') {
            return redirect()->to('/login');
        }

        $komponen = $this->komponenGajiModel->find($id);
        if (!$komponen) {
            return redirect()->to('/komponen_gaji')->with('error', 'Komponen gaji tidak ditemukan!');
        }

        $this->komponenGajiModel->delete($id);
        return redirect()->to('/komponen_gaji')->with('success', 'Komponen gaji berhasil dihapus!');
    }
}