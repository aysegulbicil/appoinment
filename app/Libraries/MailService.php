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
        $body = view($view, $data);

        // SMTP yapilandirilmadan production disinda gercek gonderim denenmez;
        // mail writable/logs/emails altina yazilir ve akis calismaya devam eder.
        if (! $this->isSmtpConfigured() && ENVIRONMENT !== 'production') {
            return $this->writeToLogFile($to, $subject, $body);
        }

        $this->email->clear(true);
        $this->email->setTo($to);
        $this->email->setSubject($subject);
        $this->email->setMailType('html');
        $this->email->setMessage($body);

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

    private function isSmtpConfigured(): bool
    {
        $config = config('Email');

        return $config->protocol === 'smtp' && trim((string) $config->SMTPHost) !== '';
    }

    private function writeToLogFile(string $to, string $subject, string $body): bool
    {
        $directory = WRITEPATH . 'logs/emails';

        if (! is_dir($directory) && ! mkdir($directory, 0775, true)) {
            log_message('error', 'MailService: e-posta log dizini olusturulamadi: ' . $directory);

            return false;
        }

        $fileName = date('Ymd-His') . '-' . preg_replace('/[^a-z0-9]+/i', '-', $to) . '.html';
        $header   = sprintf("<!-- To: %s | Subject: %s | %s -->\n", $to, $subject, date('c'));

        if (file_put_contents($directory . '/' . $fileName, $header . $body) === false) {
            return false;
        }

        log_message('info', 'MailService (dev): "' . $subject . '" e-postasi ' . $to . ' icin logs/emails/' . $fileName . ' dosyasina yazildi.');

        return true;
    }
}
