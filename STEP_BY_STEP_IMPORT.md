# Step-by-Step: Import Employees on Production Server

## 🎯 Goal
Import the Excel file so employees can find their details on `https://data.tanseeq1209.com`

---

## Method 1: Using SSH/Terminal (Most Common)

### Step 1: Get Your Server Access Details
You need:
- **Server IP or hostname** (e.g., `data.tanseeq1209.com` or an IP address)
- **Username** (e.g., `root`, `ubuntu`, or your hosting username)
- **Password** or **SSH key**

**Where to find these:**
- Check your hosting provider's email/account dashboard
- Look for "SSH Access" or "Server Details" section
- Contact your hosting support if you don't have them

### Step 2: Connect to Your Server

**On Windows:**
1. Open **PowerShell** or **Command Prompt**
2. Type:
   ```powershell
   ssh username@data.tanseeq1209.com
   ```
   Replace `username` with your actual username
3. Enter your password when prompted
4. You should see a command prompt like: `username@server:~$`

**On Mac/Linux:**
1. Open **Terminal**
2. Type:
   ```bash
   ssh username@data.tanseeq1209.com
   ```
3. Enter your password when prompted

**Alternative: Use PuTTY (Windows)**
1. Download PuTTY: https://www.putty.org/
2. Open PuTTY
3. Enter hostname: `data.tanseeq1209.com`
4. Click "Open"
5. Enter username and password

### Step 3: Find Your Project Location

Once connected, find where your project is located:

```bash
# Try these common locations:
cd /var/www/html/tanseeq-run
# OR
cd /var/www/tanseeq-run
# OR
cd /home/username/public_html/tanseeq-run
# OR
cd /home/username/tanseeq-run
```

**If you're not sure:**
```bash
# Search for your project
find / -name "artisan" -type f 2>/dev/null | grep tanseeq
# This will show you where Laravel projects are
```

### Step 4: Verify You're in the Right Folder

```bash
# Check current directory
pwd

# List files - you should see:
# - artisan
# - composer.json
# - app/
# - data/
ls -la
```

### Step 5: Check if Excel File Exists

```bash
ls -la data/
```

**Expected output:**
```
-rw-r--r-- 1 user user 104049 Dec 31 16:09 Tanseeq Run Registration Form(Employee Master).xlsx
```

**If file is missing:**
```bash
# Pull latest code from Git
git pull origin main
# OR
git pull origin master
```

### Step 6: Run the Import Command

```bash
php artisan employees:import "data/Tanseeq Run Registration Form(Employee Master).xlsx"
```

**Expected output:**
```
Found 1748 rows in the Excel file.
Starting import...
Processing... 6% (100/1747 rows)
Processing... 11% (200/1747 rows)
...
Processing... 97% (1700/1747 rows)

Import completed!
Imported: 0 employees
Updated: 1747 employees
```

**If you see errors:**
- **"File not found"** → Check Step 5, make sure file exists
- **"Permission denied"** → Try: `chmod 644 "data/Tanseeq Run Registration Form(Employee Master).xlsx"`
- **"Command not found"** → PHP might not be in PATH, try: `/usr/bin/php artisan employees:import ...`

### Step 7: Verify It Worked

```bash
# Check employee count
php artisan tinker
```

Then type:
```php
\App\Models\Employee::count();
```

Press `Ctrl+D` to exit tinker.

**Should show:** `1747` (or your actual count)

### Step 8: Test on Website

1. Visit: `https://data.tanseeq1209.com/api/check-database`
   - Should show: `"total_employees": 1747`

2. Test the form:
   - Go to: `https://data.tanseeq1209.com/tanseeq-run`
   - Enter Employee ID: `10000`
   - Fields should auto-fill! ✅

---

## Method 2: Using cPanel File Manager + Terminal

### Step 1: Log into cPanel
1. Go to your hosting provider's website
2. Log into cPanel
3. Look for **"Terminal"** or **"SSH Access"** or **"Command Line"**

### Step 2: Open Terminal
Click on **"Terminal"** or **"SSH Access"** in cPanel

### Step 3: Navigate to Project
```bash
cd public_html/tanseeq-run
# OR
cd domains/data.tanseeq1209.com/public_html/tanseeq-run
```

### Step 4: Follow Steps 5-8 from Method 1
(Same as above)

---

## Method 3: Using Hosting Provider's Command Runner

Some hosting providers have a "Run Command" feature:

### Step 1: Log into Hosting Dashboard
1. Go to your hosting provider's website
2. Log into your account

### Step 2: Find Command Runner
Look for:
- **"Run Command"**
- **"PHP Command Line"**
- **"Terminal"**
- **"SSH Console"**

### Step 3: Navigate to Project
```bash
cd /path/to/tanseeq-run
```

### Step 4: Run Import
```bash
php artisan employees:import "data/Tanseeq Run Registration Form(Employee Master).xlsx"
```

---

## Method 4: If You Can't Access Server Directly

### Option A: Ask Your Hosting Support
1. Contact your hosting provider's support
2. Tell them: "I need to run a Laravel artisan command to import employee data"
3. Provide them this command:
   ```bash
   php artisan employees:import "data/Tanseeq Run Registration Form(Employee Master).xlsx"
   ```
4. Tell them your project is at: `https://data.tanseeq1209.com`

### Option B: Use Database Import (Advanced)
If you can access the database directly (phpMyAdmin, etc.):
1. Export employees from your local database
2. Import them into production database
3. This is more complex - only if other methods don't work

---

## Troubleshooting

### Problem: "ssh: command not found"
**Solution:** Use PuTTY (Windows) or check if SSH is enabled in your hosting account

### Problem: "Permission denied (publickey)"
**Solution:** 
- Make sure you're using password authentication
- Or set up SSH keys
- Contact hosting support

### Problem: "Could not open input file: artisan"
**Solution:** 
- You're not in the right directory
- Run: `pwd` to check current location
- Navigate to project folder (see Step 3)

### Problem: "PHP Fatal error" or "Class not found"
**Solution:**
```bash
# Make sure dependencies are installed
composer install --no-dev --optimize-autoloader

# Clear cache
php artisan cache:clear
php artisan config:clear
```

### Problem: Import runs but employees still not found
**Solution:**
```bash
# Check database connection
php artisan tinker
>>> DB::connection()->getPdo();
>>> \App\Models\Employee::count();
```

---

## Quick Checklist

- [ ] Connected to production server (SSH/cPanel Terminal)
- [ ] Navigated to project folder (`cd /path/to/tanseeq-run`)
- [ ] Verified Excel file exists (`ls -la data/`)
- [ ] Ran import command (`php artisan employees:import ...`)
- [ ] Saw "Imported: X employees" message
- [ ] Verified at: `https://data.tanseeq1209.com/api/check-database`
- [ ] Tested form: `https://data.tanseeq1209.com/tanseeq-run`
- [ ] Employee lookup works! ✅

---

## Still Need Help?

If you're stuck:
1. **Check your hosting provider's documentation** for SSH/Terminal access
2. **Contact hosting support** - they can guide you
3. **Share the error message** you're seeing and I can help troubleshoot

---

## What Happens After Import?

✅ Employees can enter their Employee ID  
✅ Form auto-fills with their details  
✅ They can complete registration  
✅ Everything works like on your local server!

