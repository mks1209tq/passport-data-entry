# Quick Import Guide - Fix "Employee Not Found" Error

## The Problem
After fixing the database, all employee data was cleared. You need to re-import your Excel file.

## Quick Fix - 3 Steps

### Step 1: Find Your Excel File
Locate your Excel file. It should be something like:
- `Tanseeq Run Registration Form(Employee Master).xlsx`
- Or wherever you saved it

### Step 2: Open Terminal/PowerShell
In Cursor/VS Code: Press `Ctrl + ~` to open terminal
Or open PowerShell separately

### Step 3: Run Import Command

**If file is in Downloads folder:**
```powershell
php artisan employees:import "C:\Users\Umme Hani\Downloads\Tanseeq Run Registration Form(Employee Master).xlsx"
```

**If file is in project folder:**
```powershell
php artisan employees:import "Tanseeq Run Registration Form(Employee Master).xlsx"
```

**If file is on Desktop:**
```powershell
php artisan employees:import "C:\Users\Umme Hani\Desktop\Tanseeq Run Registration Form(Employee Master).xlsx"
```

### Step 4: Wait for Completion
You should see:
```
Found 1748 rows in the Excel file.
Starting import...
Processing... 50% (874/1747 rows)
Processing... 100% (1747/1747 rows)

Import completed!
Imported: 1747 employees
Updated: 0 employees
```

### Step 5: Test It
1. Go to: `http://tanseeq-run.test/`
2. Enter an Employee ID (e.g., `11726`)
3. Form should auto-fill now! ✅

---

## Still Not Working?

1. **Check file path is correct** - Use full path if needed
2. **Make sure file is closed** - Close Excel if file is open
3. **Check file format** - Should be .xlsx or .xls
4. **Verify columns** - Column B = Employee ID, Column C = Name

