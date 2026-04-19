<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <title>E-posta Doğrulama</title>
</head>
<body style="margin:0;padding:0;background:#f5f7fb;font-family:Arial,sans-serif;color:#1f2937;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#f5f7fb;padding:32px 16px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:520px;background:#ffffff;border-radius:8px;overflow:hidden;">
                    <tr>
                        <td style="padding:28px 28px 12px;">
                            <h1 style="margin:0;font-size:22px;color:#111827;">E-posta adresinizi doğrulayın</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:0 28px 20px;font-size:15px;line-height:1.6;color:#4b5563;">
                            <p>Merhaba <?= esc($name ?: ''); ?>,</p>
                            <p>Smart Appointment hesabınızı aktifleştirmek için aşağıdaki kodu kullanın.</p>
                            <p style="margin:24px 0;text-align:center;">
                                <span style="display:inline-block;letter-spacing:8px;font-size:30px;font-weight:bold;color:#111827;background:#eef2ff;border-radius:8px;padding:14px 18px;">
                                    <?= esc($code); ?>
                                </span>
                            </p>
                            <p>Bu kod <?= esc((string) $expiresInMinutes); ?> dakika geçerlidir.</p>
                            <p style="margin-bottom:0;color:#6b7280;">Bu işlemi siz başlatmadıysanız bu e-postayı yok sayabilirsiniz.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
