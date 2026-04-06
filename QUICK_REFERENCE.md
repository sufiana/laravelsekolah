# 🚀 Quick Reference: Brute-Force Protection

**TL;DR (Too Long; Didn't Read)** version untuk fast activation

---

## ⚡ Quick Start (3 Steps)

```bash
# Step 1: Run migration
php artisan migrate

# Step 2: Clear cache
php artisan cache:clear

# Step 3: Test login
# Go to http://localhost/sekolahbersih/login
# Try wrong password 3x → CAPTCHA appears
# Try 5x → Account locked
```

**Done!** ✅

---

## 🔗 Important URLs

| Purpose | URL |
|---------|-----|
| Login | `http://localhost/sekolahbersih/login` |
| Admin Dashboard | `http://localhost/sekolahbersih/admin/security/` |
| Export | `http://localhost/sekolahbersih/admin/security/export` |

---

## 📁 Key Files to Know

| File | Purpose |
|------|---------|
| `app/Services/BruteForceProtectionService.php` | Core logic (constants here) |
| `app/Http/Controllers/AuthController.php` | Login handler |
| `app/Http/Controllers/SecurityMonitoringController.php` | Admin dashboard |
| `database/migrations/*.php` | Database schema |
| Various `.md` files | Detailed documentation |

---

## ⚙️ Configuration

**Edit:** `app/Services/BruteForceProtectionService.php`

```php
const MAX_ATTEMPTS = 5;        // Change if too strict/lenient
const LOCKOUT_DURATION = 30;   // Unlock time (minutes)
const ATTEMPT_WINDOW = 15;     // Time window (minutes)
const IP_MAX_ATTEMPTS = 20;    // Per-IP limit
const ALERT_THRESHOLD = 3;     // CAPTCHA threshold
```

---

## 💻 Common Commands

```bash
# View login attempts
php artisan tinker
>>> \App\models\LoginAttempt::latest()->limit(10)->get();

# View locked accounts
php artisan tinker
>>> \App\User::where('locked_until', '>', now())->get();

# Unlock a user (manual)
php artisan tinker
>>> $user = \App\User::find(1);
>>> $user->update(['login_attempts' => 0, 'locked_until' => null]);

# Cleanup old logs
php artisan security:cleanup --days=30

# Send alerts
php artisan security:send-alerts
```

---

## 🐛 Troubleshooting

### Issue: CAPTCHA not appearing
**Solution:** Check session driver in `.env` (not 'null')

### Issue: Can't unlock account
**Solution:** Via SQL:
```sql
UPDATE users SET locked_until = NULL, login_attempts = 0 
WHERE id = 1;
```

### Issue: Too many logs, slow queries
**Solution:** Cleanup:
```bash
php artisan security:cleanup --days=7
```

### Issue: Forgot admin password
**Solution:**
```bash
php artisan tinker
>>> \App\User::find(1)->update(['password_hash' => Hash::make('newpass123')]);
```

---

## 📊 Monitoring

### Daily Checks
```
1. Open /admin/security/
2. Check for suspicious activities
3. Look at locked accounts
4. Review failed attempts
```

### Weekly Checks
```sql
-- Check tables size
SELECT 
  table_name, 
  ROUND(((data_length + index_length) / 1024 / 1024), 2) as size 
FROM information_schema.TABLES 
WHERE table_name IN ('login_attempts', 'suspicious_activities')
ORDER BY size DESC;

-- Check most suspicious IPs
SELECT ip_address, COUNT(*) as attempts 
FROM login_attempts 
WHERE successful = FALSE 
AND attempted_at > DATE_SUB(NOW(), INTERVAL 7 DAY)
GROUP BY ip_address 
ORDER BY attempts DESC 
LIMIT 10;
```

---

## 🔄 Maintenance Schedule

| Task | Frequency | Command |
|------|-----------|---------|
| Cleanup logs | Monthly | `php artisan security:cleanup --days=30` |
| Update analyzer | Weekly | Check dashboard |
| Alert check | Daily | Monitor `/admin/security/` |
| Database backup | Daily | `mysqldump ...` |

---

## 📋 Checklist

- [ ] Migration berhasil: `php artisan migrate`
- [ ] Website bisa dibuka: `/login`
- [ ] CAPTCHA test: Coba 3x salah password
- [ ] Lockout test: Coba 5x salah password
- [ ] Admin test: Buka `/admin/security/`
- [ ] Unlock test: Admin unlock akun
- [ ] CSV export: Test download

---

## 🎯 Features at a Glance

| Feature | Threshold | Duration | Location |
|---------|-----------|----------|----------|
| CAPTCHA | 3 failures | 5 min | login.blade.php |
| Lockout | 5 failures | 30 min | users table |
| IP Block | 20 attempts | 15 min | login_attempts |
| Alert | 3 failures | Dashboard | security-monitoring |

---

## 🔐 Default Security Levels

### Preset Configurations

**Light Protection** (untuk testing/dev)
```php
const MAX_ATTEMPTS = 10;
const LOCKOUT_DURATION = 5;
const ATTEMPT_WINDOW = 30;
const IP_MAX_ATTEMPTS = 50;
```

**Standard Protection** (current)
```php
const MAX_ATTEMPTS = 5;
const LOCKOUT_DURATION = 30;
const ATTEMPT_WINDOW = 15;
const IP_MAX_ATTEMPTS = 20;
```

**Strict Protection** (high-security)
```php
const MAX_ATTEMPTS = 3;
const LOCKOUT_DURATION = 60;
const ATTEMPT_WINDOW = 10;
const IP_MAX_ATTEMPTS = 10;
```

---

## 📞 Quick Support

**Error:** "Akun terkunci"  
→ Admin go to `/admin/security/` and click "Unlock"

**Error:** "CAPTCHA tidak valid"  
→ Clear cache: `php artisan cache:clear`

**Error:** "Too many requests"  
→ Wait 1 minute or ask admin to unlock/block reset

**Database full?**  
→ Run: `php artisan security:cleanup --days=7`

---

## 📚 Resources

- **Full Setup:** `SETUP_BRUTE_FORCE_PROTECTION.md`
- **Technical Docs:** `BRUTE_FORCE_PROTECTION_IMPLEMENTATION.md`
- **Implementation:** `IMPLEMENTATION_SUMMARY.md`

---

## ✅ Status

✅ Implemented: Rate Limiting  
✅ Implemented: Account Lockout  
✅ Implemented: CAPTCHA  
✅ Implemented: Monitoring  

**Ready for Production!** 🚀

---

*For detailed info, see the markdown documentation files.*  
*Last updated: April 2, 2026*
