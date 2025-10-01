<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $data = [
            'role' => session()->get('role'),
            'username' => session()->get('username')
        ];

        return view('dashboard', $data);
    }
}