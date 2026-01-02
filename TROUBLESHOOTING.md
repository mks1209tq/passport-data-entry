# Troubleshooting: "Employee Not Found" Issue

## Quick Diagnostic Check

### Step 1: Check if Database Has Employees

Visit this URL using your actual server address:

**If using local IP (like `http://192.168.70.44`):**
```
http://192.168.70.44/api/check-database
```

**If using localhost:**
```
http://localhost:8000/api/check-database
```

**If you have a production domain:**
```
https://your-actual-domain.com/api/check-database
```

**Expected Response if Working:**
```json
{
  "status": "ok",
  "total_employees": 1747,
  "sample_employee_ids": ["11726", "11727", ...],
  "message": "Database has 1747 employees. Employee lookup should work."
}
```

**If Database is Empty:**
```json
{
  "status": "ok",
  "total_employees": 0,
  "message": "⚠️ WARNING: No employees found in database! You need to import the Excel file."
}
```

---

## Solution: Import Employees

If the database shows 0 employees, you need to import the Excel file:

### If Running Locally (Your Current Setup):

1. **Open PowerShell/Terminal** in your project folder (`D:\sites\tanseeq-run`)

2. **Verify the Excel file exists:**
   ```powershell
   dir data\
   # Should show: Tanseeq Run Registration Form(Employee Master).xlsx
   ```

3. **Import the employees:**
   ```powershell
   php artisan employees:import "data/Tanseeq Run Registration Form(Employee Master).xlsx"
   ```

4. **Wait for completion** - You should see:
   ```
   Found 1748 rows in the Excel file.
   Starting import...
   Import completed!
   Imported: 1747 employees
   ```

5. **Verify it worked:**
   - Visit: `http://192.168.70.44/api/check-database` (or your IP)
   - Should now show `"total_employees": 1747` (or your actual count)

6. **Test employee lookup:**
   - Go to: `http://192.168.70.44/tanseeq-run`
   - Enter an Employee ID from your Excel file
   - Details should auto-fill now! ✅

### If Running on Production Server:

1. **SSH into your production server** (or access it via your hosting control panel)

2. **Navigate to your project directory**

3. **Import the employees:**
   ```bash
   php artisan employees:import "data/Tanseeq Run Registration Form(Employee Master).xlsx"
   ```

---

## Common Issues

### Issue 1: "File not found" when importing
**Solution:** Make sure the Excel file is in the `data/` folder on production:
```bash
# Check if file exists
ls -la data/

# If missing, the file might not have been deployed
# Make sure you committed and pushed the data/ folder to GitHub
```

### Issue 2: Import completes but employees still not found
**Possible causes:**
1. **Wrong database** - Production might be using a different database
2. **Employee ID format mismatch** - IDs in database might have spaces/case differences
3. **Cache issue** - Try clearing cache

**Check:**
```bash
# Clear cache
php artisan cache:clear
php artisan config:clear

# Check database connection
php artisan tinker
>>> \App\Models\Employee::count();
>>> \App\Models\Employee::first();
```

### Issue 3: Import works locally but not on production
**Remember:** Each environment has its own database!
- Local database ≠ Production database
- You must import on **both** environments separately
- Importing locally does NOT affect production

---

## Quick Fix Checklist

- [ ] Checked `/api/check-database` - shows 0 employees?
- [ ] Verified Excel file exists in `data/` folder on production
- [ ] Ran import command on production server
- [ ] Import showed "Imported: X employees"
- [ ] Verified `/api/check-database` now shows employees
- [ ] Tested employee lookup with real Employee ID
- [ ] Cleared cache if needed: `php artisan cache:clear`

---

## Still Not Working?

1. **Check logs:**
   ```bash
   tail -f storage/logs/laravel.log
   ```

2. **Test database connection:**
   ```bash
   php artisan tinker
   >>> DB::connection()->getPdo();
   >>> \App\Models\Employee::count();
   ```

3. **Verify Excel file format:**
   - Column B = Employee ID
   - Column C = Name
   - Column D = Designation
   - Column E = Department/Projects
   - Column F = Entity

4. **Check if employees table exists:**
   ```bash
   php artisan tinker
   >>> Schema::hasTable('employees');
   >>> \DB::table('employees')->count();
   ```

---

## Important Notes

- ⚠️ **The Excel file in GitHub is NOT automatically imported** - you must run the import command
- ⚠️ **Local and production databases are separate** - import on both if needed
- ✅ **Employees can still register manually** - even if lookup fails, they can enter details
- ✅ **You can re-import anytime** - it updates existing and adds new employees

