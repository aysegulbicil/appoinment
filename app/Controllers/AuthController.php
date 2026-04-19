<?php

namespace App\Controllers;

use App\Libraries\PackageCatalog;
use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class AuthController extends BaseController
{
    public function register()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to(base_url('/dashboard/businesses'));
        }

        return view('auth/register', [
            'pageTitle'       => 'Kayıt Ol',
            'selectedPackage' => $this->getSelectedPackage(),
        ]);
    }

    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to(base_url('/dashboard/businesses'));
        }

        return view('auth/login', [
            'pageTitle'       => 'Giriş Yap',
            'selectedPackage' => $this->getSelectedPackage(),
        ]);
    }

    public function selectPackage(string $packageCode)
    {
        $package = PackageCatalog::find($packageCode);

        if ($package === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        session()->set(PackageCatalog::SESSION_KEY, $package['code']);

        if (session()->get('isLoggedIn')) {
            $this->syncPackageToUser((int) session()->get('userId'));

            return redirect()->to(base_url('/dashboard/businesses'))
                ->with('success', $package['name'] . ' seçildi. Şimdi işletme bilgilerinizi tamamlayabilirsiniz.');
        }

        return redirect()->to(base_url('/login'))
            ->with('success', $package['name'] . ' seçildi. Devam etmek için giriş yapın veya kayıt olun.');
    }

    public function attemptRegister()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to(base_url('/dashboard/businesses'));
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
                'is_unique' => 'Bu e-posta adresi zaten kayıtlı.',
            ],
            'password_confirm' => [
                'matches' => 'Şifre tekrarı şifre ile aynı olmalı.',
            ],
        ];

        if (! $this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userModel = new UserModel();
        $package   = $this->getSelectedPackage();

        $userId = $userModel->insert([
            'name'          => (string) $this->request->getPost('full_name'),
            'email'         => (string) $this->request->getPost('email'),
            'phone'         => (string) $this->request->getPost('phone'),
            'company_name'  => (string) $this->request->getPost('company_name'),
            'package_code'  => $package['code'],
            'password_hash' => password_hash((string) $this->request->getPost('password'), PASSWORD_DEFAULT),
            'is_active'     => 1,
        ]);

        session()->set([
            'userId'          => $userId,
            'userName'        => (string) $this->request->getPost('full_name'),
            'userEmail'       => (string) $this->request->getPost('email'),
            'userPackageCode' => $package['code'],
            'userPackageName' => $package['name'],
            'isLoggedIn'      => true,
        ]);

        return redirect()->to(base_url('/dashboard/businesses'))
            ->with('success', 'Kayıt tamamlandı. Şimdi işletmenizi ekleyebilirsiniz.');
    }

    public function attemptLogin()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to(base_url('/dashboard/businesses'));
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
            return redirect()->back()->withInput()->with('error', 'E-posta veya şifre hatalı.');
        }

        if (! (bool) $user['is_active']) {
            return redirect()->back()->withInput()->with('error', 'Hesabınız pasif durumda.');
        }

        session()->set([
            'userId'          => $user['id'],
            'userName'        => $user['name'],
            'userEmail'       => $user['email'],
            'userPackageCode' => $user['package_code'] ?? null,
            'isLoggedIn'      => true,
        ]);

        $this->syncPackageToUser((int) $user['id']);

        return redirect()->to(base_url('/dashboard/businesses'))
            ->with('success', 'Giriş başarılı. Şimdi işletme bilgilerinizi tamamlayabilirsiniz.');
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to(base_url('/'))->with('success', 'Çıkış yapıldı.');
    }

    /**
     * @return array<string, mixed>
     */
    private function getSelectedPackage(): array
    {
        $pendingPackageCode = session()->get(PackageCatalog::SESSION_KEY);
        if (is_string($pendingPackageCode) && $pendingPackageCode !== '') {
            $pendingPackage = PackageCatalog::find($pendingPackageCode);
            if ($pendingPackage !== null) {
                return $pendingPackage;
            }
        }

        $userPackageCode = session()->get('userPackageCode');
        if (is_string($userPackageCode) && $userPackageCode !== '') {
            $userPackage = PackageCatalog::find($userPackageCode);
            if ($userPackage !== null) {
                return $userPackage;
            }
        }

        return PackageCatalog::default();
    }

    private function syncPackageToUser(int $userId): void
    {
        $package = $this->getSelectedPackage();

        (new UserModel())->update($userId, ['package_code' => $package['code']]);

        session()->set([
            'userPackageCode' => $package['code'],
            'userPackageName' => $package['name'],
        ]);
    }
}
