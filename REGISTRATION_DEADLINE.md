# Registration Deadline Configuration

## Overview
The registration form will automatically close after the specified deadline. Users will see a "Registration Closed" message instead of the registration form.

**All times are in Dubai timezone (Asia/Dubai, UTC+4).**

## Default Behavior
By default, registration closes on **January 8th, 2026 at 12:00 AM (midnight) Dubai time**.

This means:
- Registration is **OPEN** all day on January 6th and 7th
- Registration **CLOSES** at midnight (12:00 AM) on January 8th, 2026

## Custom Deadline (Optional)
To set a custom deadline, add this to your `.env` file:

```env
REGISTRATION_DEADLINE="2026-01-11 23:59:59"
```

**Important:** 
- Use **quotes** around the date/time value
- Times are interpreted in **Dubai timezone** (Asia/Dubai)
- Format: `YYYY-MM-DD HH:MM:SS` (24-hour format)

**Examples:**
- `REGISTRATION_DEADLINE="2026-01-11 23:59:59"` - Closes on January 11th at 11:59 PM Dubai time
- `REGISTRATION_DEADLINE="2026-01-12 00:00:00"` - Closes on January 12th at midnight Dubai time
- `REGISTRATION_DEADLINE="2026-01-10 18:00:00"` - Closes on January 10th at 6:00 PM Dubai time

## How It Works
1. When a user visits `/tanseeq-run`, the system checks if the current time is past the deadline
2. If **before deadline**: Shows the registration form
3. If **after deadline**: Shows the "Registration Closed" page
4. Form submissions are also blocked after the deadline

## Testing
To test the closed state locally, you can temporarily set a past date:
```env
REGISTRATION_DEADLINE=2026-01-01 00:00:00
```

Then visit: `http://tanseeq-run.test/tanseeq-run`

## Production Deployment

### For Production (Default Deadline - Jan 8th, 2026 at 12 AM Dubai time):

1. **Remove any test deadline** from production `.env` file:
   - Remove or comment out: `REGISTRATION_DEADLINE="2026-01-06 12:13:29"`
   - Or simply delete the line entirely

2. **Optional: Set timezone** (if not already set):
   ```env
   APP_TIMEZONE="Asia/Dubai"
   ```
   (This is optional - the code defaults to Dubai timezone)

3. **Clear config cache** on production server:
   ```bash
   php artisan config:clear
   php artisan route:clear
   php artisan cache:clear
   ```

4. **Verify the deadline**:
   - Visit: `https://your-domain.com/api/check-deadline`
   - Should show: `deadline_time: "2026-01-08 00:00:00"` and `deadline_timezone: "Asia/Dubai"`

### Custom Deadline for Production:

If you need a different deadline, add to production `.env`:
```env
REGISTRATION_DEADLINE="2026-01-08 00:00:00"
```

Then run: `php artisan config:clear`

**Note:** The deadline is checked in real-time, so no server restart is needed after clearing cache.

