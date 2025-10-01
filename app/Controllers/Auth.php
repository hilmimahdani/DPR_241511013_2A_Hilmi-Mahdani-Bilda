<?php

namespace App\Controllers;

use App\Models\UserModel;

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
                    'user_id'   => $user['id'],
                    'username'  => $user['username'],
                    'role'      => $user['role'], // simpan role
                    'logged_in' => true
                ]);
                return redirect()->to(base_url('home'));
            } else {
                $session->setFlashdata('error', 'Password salah!');
                return redirect()->to(base_url('login'));
            }
        } else {
            $session->setFlashdata('error', 'User tidak ditemukan!');
            return redirect()->to(base_url('login'));
        }
    }

    public function register()
    {
        return view('auth/register');
    }

    public function doRegister()
    {
        $model = new UserModel();

        $data = [
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => $this->request->getPost('role') ?? 'student'
        ];

        $model->save($data);
        return redirect()->to(base_url('login'))->with('success', 'Register berhasil, silakan login!');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'));
    }
}
