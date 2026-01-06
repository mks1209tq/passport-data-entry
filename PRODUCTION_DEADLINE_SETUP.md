# Production Deadline Setup - Quick Guide

## ✅ Default Setup (Recommended)

The code is already configured to close registration on **January 8th, 2026 at 12:00 AM (midnight) Dubai time**.

### Steps:

1. **SSH into your production server**

2. **Navigate to project directory:**
   ```bash
   cd /path/to/tanseeq-run
   ```

3. **Remove test deadline from `.env` file:**
   ```bash
   # Edit .env file and remove or comment out this line:
   # REGISTRATION_DEADLINE="2026-01-06 12:13:29"
   ```

4. **Optional: Add timezone (if not already set):**
   ```bash
   # Add to .env file:
   APP_TIMEZONE="Asia/Dubai"
   ```
   (This is optional - code defaults to Dubai timezone)

5. **Clear all caches:**
   ```bash
   php artisan config:clear
   php artisan route:clear
   php artisan cache:clear
   php artisan view:clear
   ```

6. **Verify it's working:**
   ```bash
   # Visit this URL in your browser:
   https://your-domain.com/api/check-deadline
   ```

   **Expected output:**
   ```json
   {
     "current_time": "2026-01-06 12:14:00",
     "current_timezone": "Asia/Dubai",
     "deadline_from_env": "NOT SET (using default)",
     "deadline_time": "2026-01-08 00:00:00",
     "deadline_timezone": "Asia/Dubai",
     "is_closed": false,
     "status": "OPEN"
   }
   ```

## 🎯 What This Means:

- **Today (Jan 6th)**: Registration is **OPEN** ✅
- **Tomorrow (Jan 7th)**: Registration is **OPEN** ✅
- **Jan 8th at 12:00 AM (midnight)**: Registration **CLOSES** ❌

After midnight on January 8th, users will see the "Registration Closed" page.

## 🔍 Testing on Production:

To test that it will close correctly, you can temporarily set a test deadline:

```env
REGISTRATION_DEADLINE="2026-01-06 12:20:00"
```

Then:
```bash
php artisan config:clear
```

Wait 1 minute, then visit the registration page - it should show "Registration Closed".

**Remember to remove the test deadline after testing!**

## 📝 Summary:

- **Default deadline**: January 8th, 2026 at 12:00 AM Dubai time
- **Timezone**: Asia/Dubai (UTC+4)
- **No `.env` configuration needed** - just remove any test deadlines
- **Automatic**: The deadline check happens automatically, no cron jobs needed


