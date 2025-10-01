<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\AnggotaModel;

class AnggotaController extends BaseController
{

    public function index()
    {
        if (! session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to('/login');
        }

        $db = \Config\Database::connect();
        $builder = $db->table('anggota');
        $builder->select('anggota.anggota_id, anggota.nim, students.full_name, students.age, students.entry_year, users.username, users.email');
        $builder->join('users', 'users.id = students.user_id'); // pastikan 'id' benar
        $data['students'] = $builder->get()->getResultArray();

        return view('students/index', $data);
    }


    public function create()
    {
        return view('students/create');
    }

    public function store()
    {
        $userModel = new \App\Models\UserModel();
        $studentModel = new \App\Models\StudentModel();

        // Simpan data user dulu
        $userData = [
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => 'student'
        ];
        $userModel->save($userData);
        $userId = $userModel->getInsertID();

        // Simpan data student (link ke user_id)
        $studentModel->save([
            'user_id'    => $userId,
            'nim'        => $this->request->getPost('nim'),
            'full_name'  => $this->request->getPost('full_name'),
            'age'        => $this->request->getPost('age'),
            'entry_year' => $this->request->getPost('entry_year'),
        ]);

        return redirect()->to('/students')->with('success', 'Mahasiswa berhasil ditambahkan!');
    }


    public function edit($id)
    {
        $studentModel = new StudentModel();
        $data['student'] = $studentModel->find($id);
        return view('students/edit', $data);
    }

    public function update($id)
    {
        $studentModel = new StudentModel();
        $studentModel->update($id, [
            'nim'        => $this->request->getPost('nim'),
            'full_name'  => $this->request->getPost('full_name'),
            'age'        => $this->request->getPost('age'),
            'entry_year' => $this->request->getPost('entry_year'),
        ]);
        return redirect()->to('/students')->with('success', 'Student berhasil diperbarui!');
    }

    public function delete($id)
    {
        $studentModel = new StudentModel();
        $studentModel->delete($id);
        return redirect()->to('/students')->with('success', 'Student berhasil dihapus!');
    }
}

