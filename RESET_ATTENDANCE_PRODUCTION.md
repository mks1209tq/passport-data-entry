# Reset Attendance on Production Server

## Quick Command

SSH into your production server and run:

```bash
cd /path/to/your/laravel/project
php artisan attendance:reset --force
```

The `--force` flag will skip the confirmation prompt and reset immediately.

## Step-by-Step Instructions

### Option 1: SSH Access

1. **Connect to your production server via SSH:**
   ```bash
   ssh user@your-production-server.com
   ```

2. **Navigate to your Laravel project directory:**
   ```bash
   cd /path/to/tanseeq-run
   # Example: cd /var/www/tanseeq-run
   # or: cd /home/username/tanseeq-run
   ```

3. **Run the reset command:**
   ```bash
   php artisan attendance:reset --force
   ```

4. **Verify the reset:**
   - Check the output - it should show "Successfully reset attendance"
   - Visit your attendance page: `https://data.tanseeq1209.com/tanseeq-run/attendance`
   - The "Present" count should now be 0

### Option 2: Using cPanel/Control Panel

If you don't have SSH access:

1. **Access your hosting control panel** (cPanel, Plesk, etc.)

2. **Open Terminal/SSH** (if available in your control panel)

3. **Run the command:**
   ```bash
   cd public_html  # or your Laravel root directory
   php artisan attendance:reset --force
   ```

### Option 3: Direct Database Query (Alternative)

If you can't run Artisan commands, you can reset directly via database:

1. **Access phpMyAdmin** or your database management tool

2. **Run this SQL query:**
   ```sql
   UPDATE run_registrations SET attendance_status = 'pending';
   ```

3. **Verify:**
   ```sql
   SELECT COUNT(*) as present_count 
   FROM run_registrations 
   WHERE attendance_status = 'present';
   ```
   This should return 0.

## Verification

After running the command, verify it worked:

1. **Check the command output:**
   ```
   ✓ Successfully reset attendance for X registration(s).
   All attendance statuses have been set to "pending".
   ```

2. **Visit the attendance page:**
   ```
   https://data.tanseeq1209.com/tanseeq-run/attendance
   ```
   The "Present" count should show **0**.

3. **Check via API (if needed):**
   You can also verify by checking the database directly or through your admin panel.

## Troubleshooting

### "Command not found" or "php artisan not working"

- Make sure you're in the Laravel project root directory
- Check PHP path: `which php` or use full path: `/usr/bin/php artisan attendance:reset --force`
- Some servers use: `php8.1 artisan` or `php8.2 artisan`

### "Permission denied"

- You may need to use `sudo` (not recommended for Laravel commands)
- Check file permissions: `chmod -R 775 storage bootstrap/cache`

### "Class not found" or "Command not registered"

- Clear cache: `php artisan config:clear`
- Make sure the latest code is deployed to production
- The `ResetAttendance.php` file should be in `app/Console/Commands/`

## What This Does

- Sets all `attendance_status` fields in `run_registrations` table to `'pending'`
- Does NOT delete any registration data
- Only resets the attendance status, so you can mark attendance fresh on event day
- Safe to run multiple times

## After Reset

Once reset, on the event day:
1. Visit the attendance page
2. Search for each employee by ID
3. Mark them as "Present"
4. The count will start from 0 and increase as you mark attendance

