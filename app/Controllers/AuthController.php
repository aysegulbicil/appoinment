<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    public function register()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to(base_url('/dashboard'));
        }

        return view('auth/register', [
            'pageTitle' => 'Kayit Ol',
        ]);
    }

    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to(base_url('/dashboard'));
        }

        return view('auth/login', [
            'pageTitle' => 'Giris Yap',
        ]);
    }

    public function attemptRegister()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to(base_url('/dashboard'));
        }

        $rules = [
            'full_name'        => 'required|min_length[3]|max_length[120]',
            'email'            => 'required|valid_email|is_unique[users.email]',
            'phone'            => 'required|min_length[10]|max_length[25]',
            'password'         => 'required|min_length[6]|max_length[255]',
            'password_confirm' => 'required|matches[password]',
            'company_name'     => 'permit_empty|max_length[150]',
        ];

        $messages = [
            'email' => [
                'is_unique' => 'Bu e-posta adresi zaten kayitli.',
            ],
            'password_confirm' => [
                'matches' => 'Sifre tekrari sifre ile ayni olmali.',
            ],
        ];

        if (! $this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userModel = new UserModel();
        $userModel->insert([
            'name'          => (string) $this->request->getPost('full_name'),
            'email'         => (string) $this->request->getPost('email'),
            'phone'         => (string) $this->request->getPost('phone'),
            'company_name'  => (string) $this->request->getPost('company_name'),
            'password_hash' => password_hash((string) $this->request->getPost('password'), PASSWORD_DEFAULT),
            'is_active'     => 1,
        ]);

        return redirect()->to(base_url('/login'))->with('success', 'Kayit basarili. Simdi giris yapabilirsiniz.');
    }

    public function attemptLogin()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to(base_url('/dashboard'));
        }

        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required|min_length[6]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userModel = new UserModel();
        $user      = $userModel->where('email', (string) $this->request->getPost('email'))->first();

        if (! $user || ! password_verify((string) $this->request->getPost('password'), $user['password_hash'])) {
            return redirect()->back()->withInput()->with('error', 'E-posta veya sifre hatali.');
        }

        if (! (bool) $user['is_active']) {
            return redirect()->back()->withInput()->with('error', 'Hesabiniz pasif durumda.');
        }

        session()->set([
            'userId'     => $user['id'],
            'userName'   => $user['name'],
            'userEmail'  => $user['email'],
            'isLoggedIn' => true,
        ]);

        return redirect()->to(base_url('/dashboard'));
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to(base_url('/'))->with('success', 'Cikis yapildi.');
    }
}
