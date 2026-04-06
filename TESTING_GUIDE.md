# 🧪 TESTING GUIDE - Brute Force Protection

**Tanggal:** 2 April 2026  
**Project:** SekolahBersih  
**Features:** Rate Limiting, Account Lockout, CAPTCHA, Monitoring

---

## ⚡ QUICK START TESTING

### Step 1: Setup
```bash
cd d:\laragon_old\www\sekolahbersih
php artisan migrate
php artisan cache:clear
```

### Step 2: Test CAPTCHA (3 Failed Attempts)
1. Buka: `http://localhost/sekolahbersih/login`
2. Masukkan password salah 3x
3. **Expected:** CAPTCHA matematika muncul ✅

### Step 3: Test Lockout (5 Failed Attempts)
1. Lanjutan dari step 2
2. Masukkan password salah 2x lagi (total 5x)
3. **Expected:** Error "Akun terkunci sementara..." ✅

### Step 4: Test Admin Unlock
1. Login dengan akun admin
2. Buka: `http://localhost/sekolahbersih/admin/security/`
3. Click "Unlock" pada akun yang terkunci
4. **Expected:** Akun unlock instantly ✅

---

## 📋 FULL TESTING SCENARIOS

### **SCENARIO 1: CAPTCHA Trigger (3 Failed Attempts)**

**Setup:** Akun dengan email `test@example.com`

**Test Steps:**
```
1. Login dengan password salah
2. Repeat 3x total
3. Check hasil di database:
   
   SELECT COUNT(*) FROM login_attempts 
   WHERE username_or_email = 'test@example.com' 
   AND successful = 0;
   
   Expected: 3 records
```

**Verification:**
- ✅ Error message ditampilkan
- ✅ CAPTCHA appears setelah attempt 3
- ✅ Recorded di login_attempts table
- ✅ login_attempts counter increment

---

### **SCENARIO 2: Account Lockout (5 Failed Attempts)**

**Test Steps:**
```
1. Dari scenario 1, continue with 2 more failed attempts
2. Total failures: 5
3. Next login attempt → ERROR account locked

Expected message:
"Akun Anda terkunci sementara karena terlalu banyak 
percobaan login gagal. Silakan coba lagi dalam 30 menit."
```

**Database Verification:**
```sql
SELECT id, email, login_attempts, locked_until 
FROM users 
WHERE email = 'test@example.com';

Expected:
- login_attempts = 5
- locked_until = 2026-04-02 10:35:15 (now + 30 min)
```

---

### **SCENARIO 3: Successful Login (Reset Counters)**

**Test Steps:**
```
1. Login dengan credentials BENAR
2. Should redirect ke dashboard
```

**Database Verification:**
```sql
SELECT login_attempts, locked_until 
FROM users 
WHERE email = 'test@example.com';

Expected:
- login_attempts = 0
- locked_until = NULL
```

---

### **SCENARIO 4: Admin Unlock Account**

**Test Steps:**
```
1. Account masih dalam state locked (dari scenario 2)
2. Login dengan admin account (role = 1)
3. Go to: /admin/security/
4. Find locked account
5. Click "Unlock" button
6. Should show success message
```

**Verification:**
```sql
SELECT login_attempts, locked_until 
FROM users 
WHERE email = 'test@example.com';

Expected:
- login_attempts = 0
- locked_until = NULL
```

---

### **SCENARIO 5: IP Rate Limiting**

**Test Steps (via cURL):**
```bash
# Run 25 login attempts quickly from same IP
for i in {1..25}; do
  curl -X POST http://localhost/sekolahbersih/login \
    -d "username=test@test.com&password=wrong123"
  sleep 0.5
done
```

**Expected Result:**
- Attempt 1-20: ✅ HTTP 200 (OK)
- Attempt 21+: ❌ HTTP 429 (Rate Limited)

---

### **SCENARIO 6: CAPTCHA Validation**

**Test Steps:**
```
1. Trigger CAPTCHA (fail 3x)
2. CAPTCHA shows: "7 + 5 = ?"
3. Answer CORRECTLY (12): Continue to login
4. Answer WRONGLY (99): Error "CAPTCHA tidak valid"
```

**Expected:**
- ✅ Correct answer → allowed to continue
- ❌ Wrong answer → error shown
- ❌ No answer/timeout → error shown

---

## 📊 DATABASE VERIFICATION QUERIES

### Check All Login Attempts
```sql
SELECT * FROM login_attempts 
ORDER BY attempted_at DESC 
LIMIT 20;
```

### Check Suspicious Activities
```sql
SELECT * FROM suspicious_activities 
ORDER BY created_at DESC 
LIMIT 20;
```

### Check Locked Accounts
```sql
SELECT id, username, email, login_attempts, locked_until 
FROM users 
WHERE locked_until IS NOT NULL 
AND locked_until > NOW();
```

### Check Audit Trail for Specific User
```sql
SELECT attempted_at, ip_address, successful, reason 
FROM login_attempts 
WHERE username_or_email = 'test@example.com' 
ORDER BY attempted_at DESC;
```

---

## 🎯 Admin Dashboard Testing

### URL: `/admin/security/`

**Features to Test:**
- ✅ Dashboard loads successfully
- ✅ Statistics show correct numbers
- ✅ Recent activities list populated
- ✅ Locked accounts list shows locked users
- ✅ Failed attempts by IP shows correct data
- ✅ Unlock button works (AJAX request)
- ✅ Block IP button works (AJAX request)
- ✅ Export CSV button works (file downloads)
- ✅ Auto-refresh every 30 seconds works

---

## 💻 Command Line Testing

### Reset All Data for Fresh Testing
```bash
php artisan tinker

# Clear all records
>>> \App\models\LoginAttempt::truncate();
>>> \App\models\SuspiciousActivity::truncate();
>>> \App\User::query()->update(['login_attempts' => 0, 'locked_until' => null]);
>>> exit
```

### Cleanup Old Logs
```bash
php artisan security:cleanup --days=30
# Deletes records older than 30 days
```

### Send Alerts
```bash
php artisan security:send-alerts
# Sends security alerts to admins
```

---

## 🔧 Configuration for Testing

**File:** `app/Services/BruteForceProtectionService.php`

**For faster testing, change these constants:**
```php
const MAX_ATTEMPTS = 3;         // Instead of 5 (lock faster)
const LOCKOUT_DURATION = 1;     // Instead of 30 (unlock faster)
const ATTEMPT_WINDOW = 5;       // Instead of 15 (shorter window)
const ALERT_THRESHOLD = 2;      // Instead of 3 (CAPTCHA faster)
```

**Remember to revert to defaults before production!**

---

## ⚠️ Common Testing Issues & Solutions

### Issue: CAPTCHA not appearing
**Solution:**
```bash
php artisan cache:clear
# Check .env: SESSION_DRIVER should not be 'null'
# Set to: SESSION_DRIVER=file or database
```

### Issue: Account not locking
**Solution:**
- Check database: `SELECT * FROM users WHERE email = '...';`
- Verify `locked_until` column exists
- Clear cache and retry
- Check for typos in email/username

### Issue: Can't access admin dashboard
**Solution:**
- Verify user role = 1 (admin role)
- Check if user is logged in
- Verify route is registered: `php artisan route:list | grep security`

### Issue: Unlock button not working
**Solution:**
- Check browser console for JS errors
- Verify CSRF token in form
- Check Laravel logs: `tail storage/logs/laravel.log`
- Try manual unlock via tinker

---

## 📈 Testing Results Template

```
TEST RESULTS - Brute Force Protection
=====================================

Date: [TODAY]
Tester: [YOUR NAME]
Environment: [LOCAL/STAGING]

RESULTS:
[✅/❌] Scenario 1: CAPTCHA trigger at 3 attempts
[✅/❌] Scenario 2: Account lock at 5 attempts
[✅/❌] Scenario 3: Successful login resets counters
[✅/❌] Scenario 4: Admin unlock works
[✅/❌] Scenario 5: IP rate limiting at 20 attempts
[✅/❌] Scenario 6: CAPTCHA validation works
[✅/❌] Dashboard displays correctly
[✅/❌] Check logs recorded in database
[✅/❌] Export CSV works

ISSUES FOUND:
- [List issues]

PERFORMANCE:
- Page load time: [X]ms
- Dashboard load: [X]ms
- CSV export: [X]s

NOTES:
- [Observations]
```

---

## 🚀 Ready for Production Checklist

Before deploying to production:

- [ ] All scenarios tested successfully
- [ ] Database migration runs without errors
- [ ] Admin dashboard accessible
- [ ] All buttons/forms working
- [ ] Session working correctly
- [ ] Logs recording properly
- [ ] Performance acceptable
- [ ] Security review passed
- [ ] Reset configurations to production settings
- [ ] Database backup taken

---

## 📞 Quick Reference URLs

| URL | Purpose |
|-----|---------|
| `http://localhost/sekolahbersih/login` | Login page |
| `http://localhost/sekolahbersih/admin/security/` | Admin dashboard |
| `http://localhost/sekolahbersih/admin/security/export` | Export CSV |

---

## 🧨 Stress Testing (Optional)

### High Load Test
```bash
# Install Apache Bench if not installed
ab -n 1000 -c 10 http://localhost/sekolahbersih/

# Or using wrk
wrk -t4 -c100 -d30s http://localhost/sekolahbersih/login
```

### Database Load Check
```bash
# Monitor database size
SELECT table_name, 
  ROUND((data_length + index_length) / 1024 / 1024, 2) AS size_mb 
FROM information_schema.TABLES 
WHERE table_schema = 'sekolah_bersih' 
AND table_name IN ('login_attempts', 'suspicious_activities')
ORDER BY size_mb DESC;
```

---

**Last Updated:** 2 April 2026  
**Status:** Ready for Testing ✅
