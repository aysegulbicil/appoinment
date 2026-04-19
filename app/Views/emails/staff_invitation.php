<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <title>İşletme Daveti</title>
</head>
<body style="margin:0;padding:0;background:#f5f7fb;font-family:Arial,sans-serif;color:#1f2937;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#f5f7fb;padding:32px 16px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:560px;background:#ffffff;border-radius:8px;overflow:hidden;">
                    <tr>
                        <td style="padding:28px 28px 12px;">
                            <h1 style="margin:0;font-size:22px;color:#111827;">Smart Appointment işletme daveti</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:0 28px 28px;font-size:15px;line-height:1.6;color:#4b5563;">
                            <p>Merhaba <?= esc($name); ?>,</p>
                            <p><strong><?= esc($businessName); ?></strong> işletmesine <strong><?= esc($role); ?></strong> rolüyle çalışan olarak eklendiniz.</p>
                            <p>Bu e-posta adresiyle giriş yaptığınızda işletmeye erişiminiz açılacaktır. Hesabınız yoksa aynı e-posta adresiyle kayıt olabilirsiniz.</p>
                            <p style="margin:24px 0;">
                                <a href="<?= esc($loginUrl); ?>" style="display:inline-block;background:#2563eb;color:#ffffff;text-decoration:none;border-radius:6px;padding:12px 18px;">Giriş Yap</a>
                                <a href="<?= esc($registerUrl); ?>" style="display:inline-block;color:#2563eb;text-decoration:none;margin-left:12px;">Kayıt Ol</a>
                            </p>
                            <p style="margin-bottom:0;color:#6b7280;">Bu daveti beklemiyorsanız bu e-postayı yok sayabilirsiniz.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
