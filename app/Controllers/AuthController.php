<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    public function login()
    {
        return view('login');
    }

    public function processLogin()
    {
        $userModel = new UserModel();

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $userModel
            ->where('email', $email)
            ->first();

        if ($user) {

            if ($password == $user['password']) {

                session()->set([ //session login
                    'user_id' => $user['id'],
                    'nama' => $user['nama'],
                    'role' => $user['role'],
                    'logged_in' => true
                ]);

                return redirect()->to('/')
                    ->with('success', 'Login berhasil');
            }
        }

        return redirect()->back()
            ->with('error', 'Email / password salah');
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to('/login')
            ->with('success', 'Logout berhasil');
    }
}