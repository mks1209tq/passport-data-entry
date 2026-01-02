# Complete Production Setup Guide

## 🎯 What You Need to Do

Set up **TWO things** on your production server:
1. ✅ **Import Excel file** (so employees can find their details)
2. ✅ **Set admin password** (so you can access admin area)

---

## Part 1: Import Excel File (Employee Data)

### Step 1: Connect to Production Server

**Option A: SSH**
```bash
ssh username@data.tanseeq1209.com
```

**Option B: cPanel Terminal**
- Log into cPanel
- Open "Terminal" or "SSH Access"

### Step 2: Navigate to Project

```bash
cd /var/www/html/tanseeq-run
# OR (check with your hosting provider)
cd /home/username/public_html/tanseeq-run
```

### Step 3: Verify Excel File Exists

```bash
ls -la data/
```

**Should show:**
```
Tanseeq Run Registration Form(Employee Master).xlsx
```

**If missing:**
```bash
git pull origin main
```

### Step 4: Import Employees

```bash
php artisan employees:import "data/Tanseeq Run Registration Form(Employee Master).xlsx"
```

**Expected output:**
```
Found 1748 rows in the Excel file.
Starting import...
Import completed!
Imported: 1747 employees
```

### Step 5: Verify Excel Import

Visit: `https://data.tanseeq1209.com/api/check-database`

Should show:
```json
{
  "total_employees": 1747,
  "message": "Database has 1747 employees. Employee lookup should work."
}
```

---

## Part 2: Set Admin Password

### Step 1: Access .env File on Production

**Option A: Via SSH/Terminal**
```bash
# Navigate to project (if not already there)
cd /var/www/html/tanseeq-run

# Edit .env file
nano .env
# OR
vi .env
```

**Option B: Via cPanel File Manager**
1. Log into cPanel
2. Open "File Manager"
3. Navigate to your project folder
4. Find `.env` file
5. Right-click → "Edit"

**Option C: Via FTP**
1. Connect via FTP client (FileZilla, etc.)
2. Navigate to project folder
3. Download `.env` file
4. Edit it locally
5. Upload it back

### Step 2: Add/Update Admin Password

In the `.env` file, find or add this line:

```env
ADMIN_PASSWORD=your_secure_password_here
```

**Example:**
```env
ADMIN_PASSWORD=Tanseeq2025!
```

**Important:**
- Use a **strong password** (mix of letters, numbers, symbols)
- **Don't use** the default `admin123` in production!
- Keep this password **secret** - only you should know it

### Step 3: Save and Clear Cache

**If using terminal:**
```bash
# Save file (in nano: Ctrl+X, then Y, then Enter)
# (in vi: press Esc, then type :wq and Enter)

# Clear cache
php artisan config:clear
php artisan cache:clear
```

**If using File Manager:**
- Click "Save Changes"
- Then run cache clear via terminal (see above)

### Step 4: Test Admin Login

1. Visit: `https://data.tanseeq1209.com/admin/login`
2. Enter your admin password
3. Click "Login"
4. Should redirect to registrations list ✅

---

## Complete Setup Checklist

### Excel Import ✅
- [ ] Connected to production server
- [ ] Navigated to project folder
- [ ] Verified Excel file exists in `data/` folder
- [ ] Ran import command: `php artisan employees:import "data/...xlsx"`
- [ ] Saw "Imported: X employees" message
- [ ] Verified at: `https://data.tanseeq1209.com/api/check-database`
- [ ] Tested employee lookup on form

### Admin Password ✅
- [ ] Accessed `.env` file on production
- [ ] Added/updated `ADMIN_PASSWORD=your_password`
- [ ] Saved the file
- [ ] Cleared cache: `php artisan config:clear`
- [ ] Tested login at: `https://data.tanseeq1209.com/admin/login`
- [ ] Can access admin area ✅

---

## Quick Commands Summary

**All in one go (if you're in the project folder):**

```bash
# 1. Import employees
php artisan employees:import "data/Tanseeq Run Registration Form(Employee Master).xlsx"

# 2. Edit .env file (add ADMIN_PASSWORD if not exists)
nano .env
# Add: ADMIN_PASSWORD=your_secure_password

# 3. Clear cache
php artisan config:clear
php artisan cache:clear
```

---

## Testing Everything

### Test 1: Employee Lookup
1. Go to: `https://data.tanseeq1209.com/tanseeq-run`
2. Enter Employee ID: `10000`
3. Fields should auto-fill ✅

### Test 2: Admin Login
1. Go to: `https://data.tanseeq1209.com/admin/login`
2. Enter your admin password
3. Should see registrations list ✅

### Test 3: Admin Functions
- View registrations: `https://data.tanseeq1209.com/tanseeq-run/list`
- Export CSV: `https://data.tanseeq1209.com/tanseeq-run/export`
- Edit registration: Click edit on any registration

---

## Troubleshooting

### Excel Import Issues

**Problem:** "File not found"
```bash
# Check if file exists
ls -la data/

# If missing, pull from Git
git pull origin main
```

**Problem:** "Permission denied"
```bash
chmod 644 "data/Tanseeq Run Registration Form(Employee Master).xlsx"
```

**Problem:** Import runs but employees still not found
```bash
# Check database
php artisan tinker
>>> \App\Models\Employee::count();
```

### Admin Password Issues

**Problem:** Can't find .env file
```bash
# Check if it exists
ls -la .env

# If missing, copy from .env.example
cp .env.example .env
# Then edit it
```

**Problem:** Password not working after setting
```bash
# Clear cache
php artisan config:clear
php artisan cache:clear
php artisan config:cache
```

**Problem:** "Invalid password" even with correct password
- Check `.env` file - make sure `ADMIN_PASSWORD=...` is on its own line
- No spaces around the `=` sign
- Clear cache after changing

---

## Security Reminders

⚠️ **Important Security Tips:**

1. **Use a strong admin password:**
   - At least 12 characters
   - Mix of uppercase, lowercase, numbers, symbols
   - Example: `Tanseeq2025!Secure`

2. **Don't commit .env to Git:**
   - `.env` should be in `.gitignore` (it already is)
   - Never share your `.env` file

3. **Change default password:**
   - Default is `admin123` - **MUST change in production!**

4. **Keep password secret:**
   - Only share with trusted admins
   - Don't write it in emails or chat

---

## What's Next?

After completing both setups:

✅ **Employees can:**
- Enter their Employee ID
- See details auto-fill
- Complete registration

✅ **You can:**
- Log into admin area
- View all registrations
- Export data
- Edit registrations

---

## Need Help?

If you're stuck:
1. Check error messages carefully
2. Verify file paths are correct
3. Make sure you have proper permissions
4. Contact hosting support if you can't access server
5. Check logs: `tail -f storage/logs/laravel.log`

