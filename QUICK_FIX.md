# Quick Fix: "Employee Not Found" Issue

## The Problem
Employees are getting "Employee not found" because the database doesn't have employee data yet.

## Quick Solution (3 Steps)

### Step 1: Check Your Database Status

Open your browser and visit:
```
http://192.168.70.44/api/check-database
```

**What you'll see:**
- If it shows `"total_employees": 0` → Database is empty, need to import
- If it shows `"total_employees": 1747` → Database has employees, but lookup might have other issues

### Step 2: Import Employees

1. **Open PowerShell/Terminal** in your project folder
2. **Make sure you're in the right folder:**
   ```powershell
   cd D:\sites\tanseeq-run
   ```

3. **Check if Excel file exists:**
   ```powershell
   dir data\
   ```

4. **Import employees:**
   ```powershell
   php artisan employees:import "data/Tanseeq Run Registration Form(Employee Master).xlsx"
   ```

5. **Wait for it to complete** - You should see:
   ```
   Found 1748 rows in the Excel file.
   Starting import...
   Import completed!
   Imported: 1747 employees
   ```

### Step 3: Verify It Works

1. **Check database again:**
   - Visit: `http://192.168.70.44/api/check-database`
   - Should now show employees count > 0

2. **Test employee lookup:**
   - Go to: `http://192.168.70.44/tanseeq-run`
   - Enter an Employee ID (from your Excel file)
   - Details should auto-fill! ✅

---

## Important Notes

- ⚠️ **Server must be running** - Make sure `php artisan serve` is running
- ⚠️ **Use your actual IP** - Replace `192.168.70.44` with your actual IP if different
- ✅ **Employees can still register manually** - Even if lookup fails, they can enter details

---

## Still Not Working?

1. **Check server is running:**
   - Look for the terminal window showing "Server running on..."
   - If not running, start it: `php artisan serve --host=0.0.0.0 --port=8000`

2. **Check Excel file location:**
   ```powershell
   dir data\*.xlsx
   ```

3. **Try importing with full path:**
   ```powershell
   php artisan employees:import "D:\sites\tanseeq-run\data\Tanseeq Run Registration Form(Employee Master).xlsx"
   ```

4. **Check database directly:**
   ```powershell
   php artisan tinker
   ```
   Then type:
   ```php
   \App\Models\Employee::count();
   ```

