<?php

namespace App\Libraries;

use CodeIgniter\Email\Email;

class MailService
{
    private Email $email;

    public function __construct(?Email $email = null)
    {
        $this->email = $email ?? service('email');
    }

    /**
     * @param array<string, mixed> $data
     */
    public function sendTemplate(string $to, string $subject, string $view, array $data = []): bool
    {
        $this->email->clear(true);
        $this->email->setTo($to);
        $this->email->setSubject($subject);
        $this->email->setMailType('html');
        $this->email->setMessage(view($view, $data));

        return $this->email->send(false);
    }

    public function sendVerificationCode(string $to, string $name, string $code, int $expiresInMinutes): bool
    {
        return $this->sendTemplate(
            $to,
            'E-posta doğrulama kodunuz',
            'emails/verification_code',
            [
                'name' => $name,
                'code' => $code,
                'expiresInMinutes' => $expiresInMinutes,
            ]
        );
    }

    public function sendStaffInvitation(string $to, string $name, string $businessName, string $role): bool
    {
        return $this->sendTemplate(
            $to,
            $businessName . ' işletmesine davet edildiniz',
            'emails/staff_invitation',
            [
                'name'         => $name,
                'businessName' => $businessName,
                'role'         => $role,
                'loginUrl'     => base_url('login'),
                'registerUrl'  => base_url('register'),
            ]
        );
    }
}
