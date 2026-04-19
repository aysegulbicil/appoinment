<?php

namespace App\Controllers;

use App\Libraries\PackageCatalog;
use App\Libraries\MailService;
use App\Models\UserModel;
use App\Models\BusinessStaffModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\I18n\Time;

class AuthController extends BaseController
{
    public function register()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to($this->postAuthRedirectUrl());
        }

        return view('auth/register', [
            'pageTitle'       => 'Kayıt Ol',
            'selectedPackage' => $this->getSelectedPackage(),
        ]);
    }

    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to($this->postAuthRedirectUrl());
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
            return redirect()->to($this->postAuthRedirectUrl());
        }

        $rules = [
            'full_name'        => 'required|min_length[3]|max_length[120]',
            'email'            => 'required|valid_email',
            'phone'            => 'required|min_length[10]|max_length[25]',
            'password'         => 'required|min_length[6]|max_length[255]',
            'password_confirm' => 'required|matches[password]',
            'company_name'     => 'permit_empty|max_length[150]',
        ];

        $messages = [
            'password_confirm' => [
                'matches' => 'Şifre tekrarı şifre ile aynı olmalı.',
            ],
        ];

        if (! $this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userModel = new UserModel();
        $package   = $this->getSelectedPackage();
        $email     = strtolower(trim((string) $this->request->getPost('email')));
        $existingUser = $userModel->where('email', $email)->first();

        if ($existingUser !== null && $this->isEmailVerified($existingUser)) {
            return redirect()->back()->withInput()->with('errors', [
                'email' => 'Bu e-posta adresi zaten kayıtlı.',
            ]);
        }

        $verificationCode = $this->generateVerificationCode();
        $verificationData = $this->verificationFields($verificationCode);

        $userData = [
            'name'          => (string) $this->request->getPost('full_name'),
            'email'         => $email,
            'role'          => 'business_owner',
            'phone'         => (string) $this->request->getPost('phone'),
            'company_name'  => (string) $this->request->getPost('company_name'),
            'package_code'  => $package['code'],
            'password_hash' => password_hash((string) $this->request->getPost('password'), PASSWORD_DEFAULT),
            'is_active'     => 1,
        ] + $verificationData;

        if ($existingUser !== null) {
            $userId = (int) $existingUser['id'];
            $userModel->update($userId, $userData);
        } else {
            $userId = (int) $userModel->insert($userData, true);
        }

        if (! $this->sendVerificationCode($email, $userData['name'], $verificationCode)) {
            if ($existingUser === null) {
                $userModel->delete($userId);
            }

            return redirect()->back()->withInput()->with('error', 'Doğrulama e-postası gönderilemedi. SMTP ayarlarınızı kontrol edin.');
        }

        session()->set('pendingVerificationEmail', $email);

        return redirect()->to(base_url('/verify-email'))
            ->with('success', 'Doğrulama kodu e-posta adresinize gönderildi.');
    }

    public function attemptLogin()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to($this->postAuthRedirectUrl());
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

        if (! $this->isEmailVerified($user)) {
            $verificationCode = $this->generateVerificationCode();
            (new UserModel())->update((int) $user['id'], $this->verificationFields($verificationCode));

            if (! $this->sendVerificationCode($user['email'], $user['name'], $verificationCode)) {
                return redirect()->back()->withInput()->with('error', 'Doğrulama e-postası gönderilemedi. SMTP ayarlarınızı kontrol edin.');
            }

            session()->set('pendingVerificationEmail', $user['email']);

            return redirect()->to(base_url('/verify-email'))
                ->with('success', 'Hesabınızı doğrulamak için e-posta adresinize kod gönderdik.');
        }

        $this->loginUser($user);

        $this->syncPackageToUser((int) $user['id']);
        $this->syncStaffMemberships((int) $user['id'], (string) $user['email']);

        $successMessage = $this->hasPendingPackageSelection()
            ? 'Giriş başarılı. Şimdi işletme bilgilerinizi tamamlayabilirsiniz.'
            : 'Giriş başarılı.';

        return redirect()->to($this->postAuthRedirectUrl())
            ->with('success', $successMessage);
    }

    public function verifyEmail()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to($this->postAuthRedirectUrl());
        }

        if (! session()->get('pendingVerificationEmail')) {
            return redirect()->to(base_url('/login'))->with('error', 'Doğrulama bekleyen bir hesap bulunamadı.');
        }

        return view('auth/verify_email', [
            'pageTitle' => 'E-posta Doğrulama',
            'email'     => session()->get('pendingVerificationEmail'),
        ]);
    }

    public function attemptVerifyEmail()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to($this->postAuthRedirectUrl());
        }

        $rules = [
            'email' => 'required|valid_email',
            'code'  => 'required|exact_length[6]|numeric',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $email = strtolower(trim((string) $this->request->getPost('email')));
        $code  = trim((string) $this->request->getPost('code'));
        $user  = (new UserModel())->where('email', $email)->first();

        if ($user === null || $this->isEmailVerified($user)) {
            return redirect()->to(base_url('/login'))->with('error', 'Doğrulama bekleyen bir hesap bulunamadı.');
        }

        if (! $this->isVerificationCodeValid($user, $code)) {
            session()->set('pendingVerificationEmail', $email);

            return redirect()->back()->withInput()->with('errors', [
                'code' => 'Doğrulama kodu hatalı veya süresi dolmuş.',
            ]);
        }

        $verifiedAt = Time::now()->toDateTimeString();
        (new UserModel())->update((int) $user['id'], [
            'email_verified_at'             => $verifiedAt,
            'email_verification_code_hash'  => null,
            'email_verification_expires_at' => null,
        ]);

        $user['email_verified_at'] = $verifiedAt;
        session()->remove('pendingVerificationEmail');
        $this->loginUser($user);
        $this->syncPackageToUser((int) $user['id']);
        $this->syncStaffMemberships((int) $user['id'], (string) $user['email']);

        return redirect()->to($this->postAuthRedirectUrl())
            ->with('success', 'E-posta adresiniz doğrulandı.');
    }

    public function resendVerificationCode()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to($this->postAuthRedirectUrl());
        }

        $email = strtolower(trim((string) ($this->request->getPost('email') ?: session()->get('pendingVerificationEmail'))));
        $user  = (new UserModel())->where('email', $email)->first();

        if ($user === null || $this->isEmailVerified($user)) {
            return redirect()->to(base_url('/login'))->with('error', 'Doğrulama bekleyen bir hesap bulunamadı.');
        }

        $verificationCode = $this->generateVerificationCode();
        (new UserModel())->update((int) $user['id'], $this->verificationFields($verificationCode));

        if (! $this->sendVerificationCode($user['email'], $user['name'], $verificationCode)) {
            return redirect()->back()->with('error', 'Doğrulama e-postası gönderilemedi. SMTP ayarlarınızı kontrol edin.');
        }

        session()->set('pendingVerificationEmail', $email);

        return redirect()->to(base_url('/verify-email'))
            ->with('success', 'Yeni doğrulama kodu gönderildi.');
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to(base_url('/'))->with('success', 'Çıkış yapıldı.');
    }

    /**
     * @param array<string, mixed> $user
     */
    private function loginUser(array $user): void
    {
        session()->set([
            'userId'          => $user['id'],
            'userName'        => $user['name'],
            'userEmail'       => $user['email'],
            'userRole'        => $user['role'] ?? 'business_owner',
            'userPackageCode' => $user['package_code'] ?? null,
            'isLoggedIn'      => true,
        ]);
    }

    private function generateVerificationCode(): string
    {
        return (string) random_int(100000, 999999);
    }

    /**
     * @return array<string, string|null>
     */
    private function verificationFields(string $code): array
    {
        return [
            'email_verified_at'             => null,
            'email_verification_code_hash'  => password_hash($code, PASSWORD_DEFAULT),
            'email_verification_expires_at' => Time::now()->addMinutes($this->verificationCodeTtl())->toDateTimeString(),
        ];
    }

    /**
     * @param array<string, mixed> $user
     */
    private function isEmailVerified(array $user): bool
    {
        return ! empty($user['email_verified_at']);
    }

    /**
     * @param array<string, mixed> $user
     */
    private function isVerificationCodeValid(array $user, string $code): bool
    {
        $codeHash = $user['email_verification_code_hash'] ?? null;
        $expiresAt = $user['email_verification_expires_at'] ?? null;

        if (! is_string($codeHash) || $codeHash === '' || ! is_string($expiresAt) || $expiresAt === '') {
            return false;
        }

        if (Time::parse($expiresAt)->getTimestamp() < Time::now()->getTimestamp()) {
            return false;
        }

        return password_verify($code, $codeHash);
    }

    private function sendVerificationCode(string $email, string $name, string $code): bool
    {
        return (new MailService())->sendVerificationCode($email, $name, $code, $this->verificationCodeTtl());
    }

    private function syncStaffMemberships(int $userId, string $email): void
    {
        (new BusinessStaffModel())->syncUserByEmail($userId, $email);
    }

    private function verificationCodeTtl(): int
    {
        return 15;
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

    private function hasPendingPackageSelection(): bool
    {
        $packageCode = session()->get(PackageCatalog::SESSION_KEY);

        return is_string($packageCode)
            && $packageCode !== ''
            && PackageCatalog::find($packageCode) !== null;
    }

    private function postAuthRedirectUrl(): string
    {
        if ($this->hasPendingPackageSelection()) {
            return base_url('/dashboard/businesses');
        }

        return base_url('/dashboard');
    }
}
