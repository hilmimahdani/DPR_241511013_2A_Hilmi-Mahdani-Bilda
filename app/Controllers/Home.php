<?php

namespace App\Controllers;

class Home extends BaseController
{
    
    public function index()
    {
        $data = [];
        $data['is_admin'] = session()->get('logged_in') && session()->get('role') === 'Admin';
        return view('home', $data);
    }

}