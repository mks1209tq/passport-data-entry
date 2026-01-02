# Production Deployment Guide

## ⚠️ Important: Employee Lookup Will NOT Work Until You Import the Excel File!

After deploying to production, employees will see "Employee not found" until you import the Excel file into the production database.

---

## Step-by-Step Deployment Process

### Step 1: Deploy Code to Production
- Push your code to GitHub
- Deploy to your production server (Heroku, DigitalOcean, AWS, etc.)

### Step 2: Run Migrations on Production
```bash
php artisan migrate --force
```
This creates the database tables.

### Step 3: Import Employee Data (CRITICAL STEP!)
This is the step that makes employee lookup work:

```bash
php artisan employees:import "data/Tanseeq Run Registration Form(Employee Master).xlsx"
```

**After this step, employees will be able to:**
- Enter their Employee ID
- See their details auto-fill
- Register successfully

---

## How to Verify It's Working

### Check 1: Verify Employees Are Imported
```bash
php artisan tinker
```
Then run:
```php
\App\Models\Employee::count();
```
This should show the number of employees (e.g., 1747).

### Check 2: Test Employee Lookup
1. Go to your production URL: `https://your-domain.com/tanseeq-run`
2. Enter an Employee ID from your Excel file
3. If details auto-fill → ✅ Working!
4. If "Employee not found" → ❌ Need to import Excel file

---

## Common Issues

### Issue: "Employee not found" for everyone
**Solution:** The Excel file hasn't been imported on production yet.
```bash
php artisan employees:import "data/Tanseeq Run Registration Form(Employee Master).xlsx"
```

### Issue: "File not found" error
**Solution:** Make sure the Excel file is in the `data/` folder on production.
- Check: `ls data/` or `dir data\` (Windows)
- The file should be: `data/Tanseeq Run Registration Form(Employee Master).xlsx`

### Issue: Import works but employees still not found
**Possible causes:**
1. Employee IDs in database have different format (spaces, case)
2. Database connection issue
3. Wrong database being used

**Check:**
```bash
php artisan tinker
\App\Models\Employee::first(); // See first employee
\App\Models\Employee::where('employee_id', 'YOUR_TEST_ID')->first(); // Test specific ID
```

---

## Quick Checklist After Deployment

- [ ] Code deployed to production
- [ ] Migrations run: `php artisan migrate --force`
- [ ] Excel file exists in `data/` folder
- [ ] Employees imported: `php artisan employees:import "data/...xlsx"`
- [ ] Tested employee lookup with a real Employee ID
- [ ] Verified employees can register successfully

---

## Notes

- **The Excel file in GitHub is just the source file** - it doesn't automatically populate the database
- **Each environment (local, production) needs its own import** - importing locally doesn't affect production
- **You can re-import anytime** - it will update existing employees and add new ones
- **Employees can still register manually** - even if lookup fails, they can enter details manually

---

## Need Help?

If employees still can't find their details:
1. Check the import command output - did it show "Imported: X employees"?
2. Verify the Excel file format matches expected columns (B=ID, C=Name, etc.)
3. Check production database connection in `.env`
4. Try importing a test employee manually to verify the process

