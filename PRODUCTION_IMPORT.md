# Import Employees on Production Server

## The Problem
- ✅ Local server: Working (employees found)
- ❌ Production (https://data.tanseeq1209.com): "Employee not found"

**Reason:** The production database doesn't have employee data imported yet.

---

## Solution: Import Excel File on Production

### Step 1: Access Your Production Server

You need to SSH into your production server or access it via your hosting control panel.

**Common hosting methods:**
- **cPanel/Shared Hosting:** Use File Manager and Terminal
- **VPS/Cloud Server:** SSH into the server
- **Platform like Heroku:** Use Heroku CLI

### Step 2: Navigate to Your Project Directory

```bash
cd /path/to/your/project
# Example: cd /var/www/html/tanseeq-run
# Or: cd /home/username/public_html/tanseeq-run
```

### Step 3: Verify Excel File Exists

```bash
ls -la data/
# Should show: Tanseeq Run Registration Form(Employee Master).xlsx
```

**If file doesn't exist:**
- The file should be in your GitHub repo (in `data/` folder)
- Pull the latest code: `git pull origin main` (or your branch name)
- Or upload the file manually via FTP/cPanel File Manager

### Step 4: Import Employees

```bash
php artisan employees:import "data/Tanseeq Run Registration Form(Employee Master).xlsx"
```

**Expected output:**
```
Found 1748 rows in the Excel file.
Starting import...
Processing... 50% (874/1747 rows)
Processing... 100% (1747/1747 rows)

Import completed!
Imported: 1747 employees
Updated: 0 employees
```

### Step 5: Verify It Worked

**Option A: Check via API**
Visit: `https://data.tanseeq1209.com/api/check-database`

Should show:
```json
{
  "status": "ok",
  "total_employees": 1747,
  "message": "Database has 1747 employees. Employee lookup should work."
}
```

**Option B: Test Employee Lookup**
1. Go to: `https://data.tanseeq1209.com/tanseeq-run`
2. Enter an Employee ID (e.g., `10000`)
3. Fields should auto-fill! ✅

---

## Common Issues

### Issue 1: "File not found" error
**Solution:**
```bash
# Check if file exists
ls -la data/*.xlsx

# If missing, pull from Git
git pull origin main

# Or use full path
php artisan employees:import "/full/path/to/data/Tanseeq Run Registration Form(Employee Master).xlsx"
```

### Issue 2: "Permission denied"
**Solution:**
```bash
# Make sure you have write permissions
chmod -R 755 data/
chmod 644 "data/Tanseeq Run Registration Form(Employee Master).xlsx"
```

### Issue 3: Import completes but still "not found"
**Check:**
```bash
# Verify employees are in database
php artisan tinker
>>> \App\Models\Employee::count();
>>> \App\Models\Employee::where('employee_id', '10000')->first();
```

### Issue 4: Can't access server
**Alternative methods:**
1. **Via cPanel:** Use File Manager → Terminal
2. **Via FTP:** Upload Excel file, then use hosting provider's terminal
3. **Via hosting dashboard:** Many hosts have a "Run Command" feature

---

## Quick Checklist

- [ ] Accessed production server (SSH/cPanel/Terminal)
- [ ] Navigated to project directory
- [ ] Verified Excel file exists in `data/` folder
- [ ] Ran import command: `php artisan employees:import "data/...xlsx"`
- [ ] Saw "Imported: X employees" message
- [ ] Tested at: `https://data.tanseeq1209.com/tanseeq-run`
- [ ] Employee lookup now works! ✅

---

## Important Notes

⚠️ **Local and production databases are separate!**
- Importing locally does NOT affect production
- You must import on BOTH environments separately
- Each server has its own database

✅ **You can re-import anytime**
- Running import again updates existing employees
- Adds new employees if Excel file has new rows
- Safe to run multiple times

---

## Need Help?

If you're not sure how to access your production server:
1. Check your hosting provider's documentation
2. Look for "SSH Access" or "Terminal" in your hosting dashboard
3. Contact your hosting support for help accessing the server

