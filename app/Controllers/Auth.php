<?php
namespace App\Controllers;
use App\Models\PenggunaModel;

class Auth extends BaseController
{
    public function login()
    {
        return view('auth/login');
    }

    public function doLogin()
    {
        $session = session();
        $model = new PenggunaModel();

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $model->where('username', $username)->first();

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $session->set([
                    'id_pengguna'   => $user['id_pengguna'],
                    'username'  => $user['username'],
                    'role'      => $user['role'], 
                    'logged_in' => true
                ]);
                if ($user['role'] === 'Admin') {
                    return redirect()->to(base_url('home'))->with('success', 'Login berhasil sebagai Admin!');
                } else {
                    return redirect()->to(base_url('public/anggota'))->with('success', 'Login berhasil sebagai Public!');
                }
            } else {
                $session->setFlashdata('error', 'Password salah!');
                return redirect()->to(base_url('login'));
            }
        } else {
            $session->setFlashdata('error', 'User tidak ditemukan!');
            return redirect()->to(base_url('login'));
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'))->with('success', 'Logout berhasil!');
    }

    public function register()
    {
        return view('auth/register');
    }

    public function doRegister()
    {
        $model = new PenggunaModel();

        $data = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'nama_depan' => $this->request->getPost('nama_depan'),
            'nama_belakang' => $this->request->getPost('nama_belakang'),
            'role' => $this->request->getPost('role') ?? 'Public'
        ];

        $model->save($data);
        return redirect()->to(base_url('login'))->with('success', 'Register berhasil, silakan login!');
    }
}
