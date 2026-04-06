# Setup Guide: Brute-Force Protection untuk SekolahBersih

## Quick Start

Ikuti langkah-langkah berikut untuk mengaktifkan brute-force protection pada aplikasi SekolahBersih Anda.

---

## 📋 Requirements

- Laravel 7.x
- PHP 7.4+
- MySQL 5.7+
- Composer

---

## 🚀 Step-by-Step Installation

### Step 1: Run Database Migration

```bash
cd d:\laragon_old\www\sekolahbersih
php artisan migrate
```

**Ini akan membuat:**
- Tambahan 3 kolom di table `users`: `login_attempts`, `last_login_attempt`, `locked_until`
- Table baru `login_attempts` - untuk mencatat semua percobaan login
- Table baru `suspicious_activities` - untuk mencatat aktivitas mencurigakan

### Step 2: Update Configuration (Optional)

Edit file `app/Services/BruteForceProtectionService.php` jika ingin mengubah konfigurasi:

```php
const MAX_ATTEMPTS = 5;        // Maksimal percobaan sebelum lockout
const LOCKOUT_DURATION = 30;   // Durasi lockout (menit)
const ATTEMPT_WINDOW = 15;     // Window untuk count attempt (menit)
const IP_MAX_ATTEMPTS = 20;    // Maksimal attempt dari IP yang sama
const ALERT_THRESHOLD = 3;     // Mulai alert setelah N attempt
```

### Step 3: Clear Cache

```bash
php artisan config:clear
php artisan cache:clear
```

### Step 4: Test Login Flow

1. Buka halaman login: `http://localhost/sekolahbersih/login`
2. Masukkan username/password yang salah 3 kali
   - Seharusnya CAPTCHA akan muncul
3. Masukkan yang salah 5 kali
   - Seharusnya akun akan terkunci 30 menit

### Step 5: Schedule Maintenance Commands (Optional)

Edit file `app/Console/Kernel.php` dan tambahkan:

```php
protected function schedule(Schedule $schedule)
{
    // Cleanup old login attempts setiap hari tengah malam
    $schedule->command('security:cleanup --days=30')
        ->daily()
        ->at('00:00')
        ->onSuccess(function () {
            \Log::info('Security logs cleanup completed');
        });

    // Send security alerts setiap 15 menit
    $schedule->command('security:send-alerts')
        ->everyFifteenMinutes()
        ->onSuccess(function () {
            \Log::info('Security alerts sent');
        });
}
```

Kemudian jalankan scheduler:
```bash
# Di latar belakang (production)
* * * * * cd /path/to/sekolahbersih && php artisan schedule:run >> /dev/null 2>&1

# Atau manual (testing)
php artisan schedule:work
```

---

## 📊 Access Admin Dashboard

### Menampilkan Security Monitoring Dashboard

1. Pastikan user memiliki role admin (role = 1 atau 'admin')
2. Akses URL: `http://localhost/sekolahbersih/admin/security/`
3. Dashboard akan menampilkan:
   - Statistik suspicious activities
   - Daftar akun terkunci
   - Failed login attempts per IP
   - Opsi untuk unlock akun atau block IP

### Available Admin Routes

| Method | Route | Function |
|--------|-------|----------|
| GET | `/admin/security/` | View dashboard |
| POST | `/admin/security/user-attempts` | Get login attempts by username |
| POST | `/admin/security/ip-stats` | Get statistics by IP address |
| POST | `/admin/security/unlock` | Unlock account manually |
| POST | `/admin/security/block-ip` | Block IP address |
| GET | `/admin/security/export` | Export activities to CSV |

---

## 🛡️ Features Overview

### 1. Rate Limiting

**Apa itu?** Membatasi jumlah percobaan login dalam periode tertentu.

**Konfigurasi:**
- Max 5 percobaan per akun dalam 15 menit
- Max 20 percobaan per IP dalam 15 menit

**Tampilan User:**
```
Error: Terlalu banyak percobaan login dari IP Anda. Silakan coba lagi dalam beberapa menit.
```

### 2. Account Lockout

**Apa itu?** Akun akan terkunci sementara setelah terlalu banyak gagal login.

**Behavior:**
- Akun terkunci setelah 5 percobaan gagal
- Durasi: 30 menit (auto unlock)
- Admin bisa manual unlock via dashboard

**Tampilan User:**
```
Akun Anda terkunci sementara karena terlalu banyak percobaan login gagal. 
Silakan coba lagi dalam 28 menit.
```

### 3. CAPTCHA Verification

**Apa itu?** User harus jawab pertanyaan matematika untuk membuktikan dia manusia.

**Trigger:**
- Muncul setelah 3 percobaan login gagal
- Simple Math: Penjumlahan atau pengurangan
- Expires: 5 menit

**Contoh:**
```
Soal: 7 + 5 = ?
User harus input: 12
```

### 4. Monitoring & Alerting

**Apa itu?** Sistem mencatat semua login attempts dan aktivitas mencurigakan.

**Tracked Data:**
- Waktu percobaan login
- Username/Email yang dicoba
- IP Address
- Status (success/failed)
- Alasan gagal

**Admin Notifikasi:**
- Dashboard real-time dengan auto-refresh 30 detik
- CSV export untuk analysis
- Alert untuk aktivitas mencurigakan

---

## 🔍 Monitoring Commands

### View Login Attempts

```bash
# Via MySQL
SELECT * FROM login_attempts 
WHERE username_or_email = 'admin@example.com' 
AND attempted_at >= DATE_SUB(NOW(), INTERVAL 24 HOUR)
ORDER BY attempted_at DESC;
```

### View Suspicious Activities

```bash
SELECT * FROM suspicious_activities 
WHERE created_at >= DATE_SUB(NOW(), INTERVAL 24 HOUR)
ORDER BY created_at DESC;
```

### View Locked Accounts

```bash
SELECT id, username, email, login_attempts, locked_until 
FROM users 
WHERE locked_until IS NOT NULL 
AND locked_until > NOW();
```

### Cleanup Old Logs

```bash
# Di terminal
php artisan security:cleanup --days=30

# Atau manual via SQL
DELETE FROM login_attempts WHERE attempted_at < DATE_SUB(NOW(), INTERVAL 30 DAY);
DELETE FROM suspicious_activities WHERE created_at < DATE_SUB(NOW(), INTERVAL 30 DAY);
```

---

## 📝 Database Schema

### users table (additions)
```sql
ALTER TABLE users ADD COLUMN login_attempts INT DEFAULT 0;
ALTER TABLE users ADD COLUMN last_login_attempt DATETIME NULL;
ALTER TABLE users ADD COLUMN locked_until DATETIME NULL;
```

### login_attempts table (new)
```sql
CREATE TABLE login_attempts (
  id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  username_or_email VARCHAR(255) NOT NULL,
  ip_address VARCHAR(45) NOT NULL,
  user_agent LONGTEXT,
  successful BOOLEAN DEFAULT FALSE,
  reason VARCHAR(255),
  attempted_at DATETIME NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY username_or_email_idx (username_or_email),
  KEY ip_address_idx (ip_address),
  KEY attempted_at_idx (attempted_at)
);
```

### suspicious_activities table (new)
```sql
CREATE TABLE suspicious_activities (
  id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  user_id BIGINT UNSIGNED,
  username_or_email VARCHAR(255),
  ip_address VARCHAR(45) NOT NULL,
  activity_type VARCHAR(255) NOT NULL,
  details LONGTEXT,
  alert_sent BOOLEAN DEFAULT FALSE,
  alerted_at DATETIME,
  created_at DATETIME NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
  KEY user_id_idx (user_id),
  KEY ip_address_idx (ip_address),
  KEY activity_type_idx (activity_type)
);
```

---

## 📂 File Structure

Berikut adalah file-file yang ditambahkan/diupdate:

```
app/
├── Console/Commands/
│   ├── CleanupSecurityLogs.php          [NEW]
│   └── SendSecurityAlerts.php           [NEW]
├── Events/
│   └── SuspiciousLoginAttempt.php       [NEW]
├── Http/
│   ├── Controllers/
│   │   ├── AuthController.php           [UPDATED]
│   │   └── SecurityMonitoringController.php [NEW]
│   └── Middleware/
│       └── RateLimitLogin.php           [NEW]
├── models/
│   ├── LoginAttempt.php                 [NEW]
│   └── SuspiciousActivity.php           [NEW]
├── Rules/
│   └── ValidateCaptcha.php              [NEW]
├── Services/
│   └── BruteForceProtectionService.php  [NEW]
└── User.php                              [UPDATED]

database/
└── migrations/
    └── 2026_04_02_add_brute_force_protection.php [NEW]

resources/views/
├── auth/
│   └── login.blade.php                  [UPDATED]
└── admin/
    └── security-monitoring.blade.php    [NEW]

routes/
└── web.php                               [UPDATED]
```

---

## 🧪 Testing

### Manual Testing Scenarios

#### Scenario 1: CAPTCHA Appears
1. Buka login page
2. Masukkan password salah 3 kali dengan IP yang sama
3. Refresh halaman -> CAPTCHA harus muncul

#### Scenario 2: Account Lockout
1. Masukkan password salah 5 kali
2. Attempt ke-5 -> Akun terkunci 30 menit
3. Coba login lagi -> Error: "Akun Anda terkunci sementara..."

#### Scenario 3: IP Rate Limiting
1. Dari terminal/script, lakukan 20+ failed login dari IP yang sama
2. Request ke-21 -> Response: 429 Too Many Requests

#### Scenario 4: Admin Unlock
1. Admin akses `/admin/security/`
2. Lihat locked accounts
3. Click "Unlock" -> Account immediately unlocked

#### Scenario 5: Successful Login
1. Masukkan credentials yang benar
2. login_attempts dan locked_until di-reset ke 0/NULL
3. User redirect ke dashboard

### Automated Testing (Future)

```bash
php artisan test --filter=AuthenticationTest
php artisan test --filter=BruteForceProtectionTest
```

---

## 🔐 Security Best Practices

### 1. Monitoring
- ✅ Check admin dashboard setiap hari
- ✅ Review suspicious activities
- ✅ Monitor locked accounts

### 2. Maintenance
- ✅ Cleanup old logs setiap bulan
- ✅ Update failed attempt thresholds jika perlu
- ✅ Keep CAPTCHA answer secret

### 3. Hardening (Optional)
- ⭐ Implement email notification untuk suspicious activity
- ⭐ Add geographic detection untuk unusual logins
- ⭐ Implement 2FA (Two-Factor Authentication)
- ⭐ Use Google reCAPTCHA v3 untuk CAPTCHA lebih advanced
- ⭐ Implement IP whitelisting untuk trusted IPs

---

## 🞬 Troubleshooting

### Q: Migration error "Table users already exists"
A: Table users sudah exist, migration hanya add columns. Kalau error tetap, check apakah columns sudah ada:
```bash
php artisan tinker
# Di tinker:
>>> DB::table('users')->where('id', 1)->first();
# Check apakah column login_attempts, last_login_attempt, locked_until ada
```

### Q: CAPTCHA tidak muncul setelah 3 attempt
A: Check session configuration:
```bash
php artisan config:show session

# Pastikan SESSION_DRIVER bukan 'null'
# Edit .env: SESSION_DRIVER=database atau file
```

### Q: User lupa password dan account terkunci
A: Admin bisa unlock via dashboard atau manual:
```bash
php artisan tinker
# Di tinker:
>>> $user = \App\User::find(1);
>>> $user->update(['login_attempts' => 0, 'locked_until' => null]);
>>> exit
```

### Q: Terlalu banyak log, database penuh
A: Jalankan cleanup command:
```bash
php artisan security:cleanup --days=7  # Retain 7 days only
```

### Q: Pengen ganti threshold dari 5 ke 3 attempts
A: Edit `app/Services/BruteForceProtectionService.php`:
```php
const MAX_ATTEMPTS = 3;  // Changed from 5
```

---

## 📚 Additional Resources

### Documentation Files
- `BRUTE_FORCE_PROTECTION_IMPLEMENTATION.md` - Detailed technical documentation
- `SETUP_GUIDE.md` - This file

### Related Files
- `app/Services/BruteForceProtectionService.php` - Core protection logic
- `app/Http/Controllers/AuthController.php` - Login handler
- `app/Http/Controllers/SecurityMonitoringController.php` - Admin dashboard

---

## 📞 Support

Jika mengalami issue:
1. Check log file: `storage/logs/laravel.log`
2. Check MySQL error log
3. Verify database migration ran successfully
4. Check apakah service provider registered dengan baik

---

## ✅ Checklist Selesai Setup

- [ ] Database migration berhasil dijalankan
- [ ] Login page bisa diakses dan form fields benar
- [ ] CAPTCHA muncul setelah 3 failed login
- [ ] Akun terkunci setelah 5 failed login
- [ ] Admin bisa akses security dashboard
- [ ] Admin bisa unlock account dari dashboard
- [ ] Export CSV berfungsi
- [ ] Cleanup command berjalan
- [ ] Alert notification setup (optional)

---

**Last Updated:** 2 April 2026  
**Version:** 1.0  
**Status:** Production Ready ✅
