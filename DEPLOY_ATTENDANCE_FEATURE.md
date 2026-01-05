# Deploy Attendance Feature to Production

## 🚨 Issue: 404 Error on Production

The attendance page is showing 404 on `data.tanseeq1209.com/tanseeq-run/attendance` because the latest code hasn't been deployed yet.

---

## Step-by-Step Deployment

### Step 1: Push Code to GitHub

Make sure all your changes are committed and pushed:

```bash
git add .
git commit -m "Add attendance feature"
git push origin main
```

### Step 2: Connect to Production Server

**SSH into your production server:**

```bash
ssh username@data.tanseeq1209.com
```

**Or use cPanel Terminal:**
- Log into cPanel
- Open "Terminal" or "SSH Access"

### Step 3: Navigate to Project Directory

```bash
# Find your project (common locations):
cd /var/www/html/tanseeq-run
# OR
cd /var/www/tanseeq-run
# OR
cd /home/username/public_html/tanseeq-run
# OR
cd /home/username/tanseeq-run

# Verify you're in the right place:
ls -la
# Should see: artisan, composer.json, app/, routes/, etc.
```

### Step 4: Pull Latest Code from GitHub

```bash
git pull origin main
# OR if you use a different branch:
git pull origin master
```

### Step 5: Run Migrations (if needed)

If you added any new migrations:

```bash
php artisan migrate --force
```

### Step 6: Clear All Caches

**This is important!** Clear all Laravel caches:

```bash
php artisan route:clear
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

### Step 7: Optimize for Production (Optional but Recommended)

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Step 8: Verify Routes Are Registered

Check if the attendance route exists:

```bash
php artisan route:list --name=attendance
```

**Should show:**
```
GET|HEAD  tanseeq-run/attendance ................ attendance.show
GET|HEAD  tanseeq-run/attendance/export .......... attendance.export
POST      api/search-employee .................... attendance.search
POST      api/mark-attendance ................... attendance.mark
```

### Step 9: Test the Route

1. **Make sure you're logged in as admin:**
   - Go to: `https://data.tanseeq1209.com/admin/login`
   - Login with your admin credentials

2. **Access the attendance page:**
   - Go to: `https://data.tanseeq1209.com/tanseeq-run/attendance`
   - Should now work! ✅

---

## Quick Fix Commands (All in One)

If you're already on the production server, run these commands:

```bash
# Navigate to project
cd /path/to/tanseeq-run

# Pull latest code
git pull origin main

# Clear caches
php artisan route:clear
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# Rebuild caches (optional)
php artisan config:cache
php artisan route:cache
```

---

## Troubleshooting

### Still Getting 404?

1. **Check if route exists:**
   ```bash
   php artisan route:list | grep attendance
   ```

2. **Verify file exists:**
   ```bash
   ls -la resources/views/run/attendance.blade.php
   ```

3. **Check controller method exists:**
   ```bash
   grep -n "showAttendance" app/Http/Controllers/RunRegistrationController.php
   ```

4. **Check web server configuration:**
   - Make sure your web server (Apache/Nginx) is pointing to the `public` folder
   - Check `.htaccess` file exists in `public` folder

### Route Shows But Still 404?

1. **Check middleware:**
   - Make sure you're logged in as admin
   - Try accessing: `https://data.tanseeq1209.com/admin/login` first

2. **Check file permissions:**
   ```bash
   chmod -R 755 storage bootstrap/cache
   ```

3. **Restart web server (if you have access):**
   ```bash
   sudo systemctl restart apache2
   # OR
   sudo systemctl restart nginx
   ```

---

## Files That Need to Be on Production

Make sure these files exist on production:

- ✅ `routes/web.php` (with attendance routes)
- ✅ `app/Http/Controllers/RunRegistrationController.php` (with `showAttendance()` method)
- ✅ `resources/views/run/attendance.blade.php` (the attendance page)
- ✅ `app/Http/Middleware/AdminAuth.php` (admin middleware)
- ✅ `bootstrap/app.php` (with admin middleware alias)

---

## Need Help?

If you're still having issues:

1. Check Laravel logs: `storage/logs/laravel.log`
2. Check web server error logs
3. Verify you're accessing the correct URL
4. Make sure you're logged in as admin

