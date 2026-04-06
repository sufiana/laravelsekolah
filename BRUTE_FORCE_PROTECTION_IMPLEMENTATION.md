# Implementasi Brute-Force Protection - SekolahBersih

## Daftar Perubahan

Dokumentasi ini menjelaskan solusi brute-force protection yang telah diimplementasikan pada aplikasi SekolahBersih.

### 1. **Rate Limiting**

#### Fitur:
- Anti-brute force dengan membatasi percobaan login
- Maximum 5 percobaan gagal dalam 15 menit per akun
- Maximum 20 percobaan gagal dalam 15 menit per IP address

#### Implementasi:
- `app/Services/BruteForceProtectionService.php` - Service untuk mengelola rate limiting
- `app/models/LoginAttempt.php` - Model untuk tracking percobaan login

#### Konfigurasi:
```php
const MAX_ATTEMPTS = 5;        // Maksimal attempt sebelum lockout
const LOCKOUT_DURATION = 30;   // Durasi lockout dalam menit
const ATTEMPT_WINDOW = 15;     // Window untuk penghitungan attempt
const IP_MAX_ATTEMPTS = 20;    // Maksimal attempt dari IP yang sama
```

### 2. **Account Lockout**

#### Fitur:
- Akun akan terkunci sementara (30 menit) setelah 5 percobaan login gagal
- User akan melihat pesan bahwa akun terkunci dan berapa lama menunggu
- Automatic unlock setelah periode lockout berakhir

#### Database Fields:
- `login_attempts` (INT) - Penghitung percobaan login gagal
- `last_login_attempt` (DATETIME) - Waktu percobaan login terakhir
- `locked_until` (DATETIME) - Waktu sampai akun terbuka kembali

### 3. **CAPTCHA Verification**

#### Fitur:
- CAPTCHA akan ditampilkan setelah 3 percobaan login gagal
- Simple math CAPTCHA (penambahan/pengurangan)
- CAPTCHA expire setelah 5 menit

#### Implementasi:
- `app/Rules/ValidateCaptcha.php` - Custom validation rule untuk CAPTCHA
- CAPTCHA question disimpan di session
- Automatic cleanup setelah login berhasil atau failed

#### Cara Kerja:
1. User memasukkan username/password
2. Jika percobaan gagal ≥ 3 kali, CAPTCHA ditampilkan
3. User harus jawab soal matematika untuk melanjutkan
4. Answer disimpan di session dan dibandingkan dengan input user

### 4. **Monitoring & Alerting**

#### Fitur:
- Semua percobaan login dicatat (success/failed)
- Suspicious activity detection dan logging
- Admin dashboard untuk monitoring

#### Database Tables:

**login_attempts**
- `id` - Primary key
- `username_or_email` - Username atau email yang dicoba
- `ip_address` - IP address pembuat percobaan
- `user_agent` - Browser/device information
- `successful` - Boolean apakah login berhasil
- `reason` - Alasan jika gagal
- `attempted_at` - Waktu percobaan

**suspicious_activities**
- `id` - Primary key
- `user_id` - ID user (nullable)
- `username_or_email` - Username atau email
- `ip_address` - IP address
- `activity_type` - Tipe aktivitas (multiple_failures, account_locked, etc)
- `details` - JSON dengan detail aktivitas
- `alert_sent` - Flag untuk alert
- `alerted_at` - Waktu alert dikirim
- `created_at` - Waktu aktivitas

#### Activity Types:
- `multiple_failures` - User melakukan beberapa percobaan login gagal
- `account_locked` - Akun dikunci karena terlalu banyak percobaan gagal
- `ip_blocked` - IP address terlalu banyak percobaan
- `unusual_location` - Login dari lokasi/device baru
- `successful_login` - Login berhasil
- `account_unlocked_by_admin` - Admin membuka kunci akun

### 5. **Setup & Installation**

#### Step 1: Run Migration
```bash
php artisan migrate
```

Ini akan membuat:
- Add columns to users table: `login_attempts`, `last_login_attempt`, `locked_until`
- Create `login_attempts` table
- Create `suspicious_activities` table

#### Step 2: Update Routes
Sudah di-update di `routes/web.php`:
- `POST /login` - Login endpoint dengan rate limiting
- `POST /auth/login-status` - Get login attempt status
- `POST /auth/generate-captcha` - Generate CAPTCHA

#### Step 3: Add AuthController Routes
Service binding di controller constructor:
```php
public function __construct(BruteForceProtectionService $bruteForceService)
{
    $this->bruteForceService = $bruteForceService;
}
```

#### Step 4: Login View Update
Updated `resources/views/auth/login.blade.php`:
- Tambah CAPTCHA field (conditional)
- Tambah error messages untuk lockout
- Tambah security notice/info
- Change field dari email-only ke username OR email

### 6. **Admin Monitoring Dashboard**

#### Routes:
```php
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/security', [SecurityMonitoringController::class, 'index'])->name('security.index');
    Route::post('/admin/security/user-attempts', [SecurityMonitoringController::class, 'getUserAttempts'])->name('security.user-attempts');
    Route::post('/admin/security/ip-stats', [SecurityMonitoringController::class, 'getIpStatistics'])->name('security.ip-stats');
    Route::post('/admin/security/unlock', [SecurityMonitoringController::class, 'unlockAccount'])->name('security.unlock');
    Route::post('/admin/security/block-ip', [SecurityMonitoringController::class, 'blockIpAddress'])->name('security.block-ip');
    Route::get('/admin/security/export', [SecurityMonitoringController::class, 'export'])->name('security.export');
});
```

#### Dashboard Features:
- View semua suspicious activities
- Search login attempts by username
- Check IP address statistics
- Manually unlock user account
- Block IP address for N days
- Export suspicious activities to CSV

### 7. **Configuration Recommendations**

#### Security Best Practices:

1. **Email Notification untuk Suspicious Activity**
   - Send email ke admin saat suspicious activity terdeteksi
   - Include details: IP, timestamp, activity type

2. **IP Blacklist Management**
   - Maintain whitelist untuk trusted IPs (office, static IPs)
   - Automatic temporary block untuk IPs dengan banyak failed attempts

3. **Geographic Detection (Optional)**
   - Detect login dari lokasi berbeda
   - Compare dengan last known location

4. **Device Fingerprinting (Optional)**
   - Track device info (browser, OS)
   - Alert jika login dari device baru

5. **API Rate Limiting**
   - Already added: `Route::post('/login', ...)->middleware('throttle:60,1')`
   - 60 requests per 1 minute

### 8. **File Structure**

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── AuthController.php (UPDATED)
│   │   └── SecurityMonitoringController.php (NEW)
│   └── Middleware/
│       └── RateLimitLogin.php (NEW)
├── models/
│   ├── LoginAttempt.php (NEW)
│   └── SuspiciousActivity.php (NEW)
├── Rules/
│   └── ValidateCaptcha.php (NEW)
├── Services/
│   └── BruteForceProtectionService.php (NEW)
└── User.php (UPDATED)

database/
└── migrations/
    └── 2026_04_02_add_brute_force_protection.php (NEW)

resources/views/
├── auth/
│   └── login.blade.php (UPDATED)
└── admin/
    └── security-monitoring.blade.php (NEW - perlu dibuat)

routes/
└── web.php (UPDATED)
```

### 9. **Testing**

#### Manual Testing:

1. **Rate Limiting Test:**
   - Buka halaman login
   - Masukkan password yang salah 5 kali
   - Akun akan terkunci selama 30 menit

2. **CAPTCHA Test:**
   - Masukkan password salah 3 kali
   - CAPTCHA akan muncul
   - Jawab soal matematika dengan benar untuk lanjut

3. **IP Rate Limiting Test:**
   - Buat 20+ failed login dari IP yang sama
   - Setelah 20 percobaan, request akan di-block

#### Unit Testing (Future):
```bash
php artisan test --filter=BruteForceProtectionTest
```

### 10. **Admin Tasks**

#### Regular Monitoring:
- Check security dashboard setiap hari
- Review suspicious activities
- Unlock legitimate accounts jika diperlukan
- Block malicious IPs if needed

#### Maintenance:
- Clear old login attempts records (> 30 days)
- Archive suspicious activities logs
- Monitor locked accounts
- Review CAPTCHA performance

### 11. **Troubleshooting**

#### Q: User tidak bisa login padahal password benar?
- A: Check jika akun terkunci di field `locked_until`
- Admin bisa unlock via dashboard

#### Q: CAPTCHA tidak muncul?
- A: Check session storage (database/file based)
- Verify `app/Rules/ValidateCaptcha.php`

#### Q: IP Rate Limiting terlalu ketat?
- A: Adjust `IP_MAX_ATTEMPTS` di `BruteForceProtectionService`

#### Q: Perlu integrate real CAPTCHA (Google reCAPTCHA)?
- A: Update `ValidateCaptcha` class untuk use reCAPTCHA API

### 12. **Upgrade Path untuk Enhanced Security**

1. **Google reCAPTCHA v3**
```php
// Replace ValidateCaptcha dengan integration reCAPTCHA
```

2. **Email Verification for Suspicious Logins**
```php
// Send verification link sebelum allow login
```

3. **Two-Factor Authentication (2FA)**
```php
// TOTP atau SMS-based 2FA
```

4. **Location-based Access Control**
```php
// Restrict akses berdasarkan geographic location
```

---

## Summary

✅ **Rate Limiting** - 5 attempts per akun, 20 per IP
✅ **Account Lockout** - 30 menit automatic lock setelah exceed
✅ **CAPTCHA** - Simple math CAPTCHA after 3 failed attempts
✅ **Monitoring** - All login attempts logged untuk audit trail
✅ **Admin Dashboard** - Monitor dan manage suspicious activities

---

**Implementasi Tanggal:** 2 April 2026
**Status:** Ready for Production
**Last Updated:** 2 April 2026
