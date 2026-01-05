# Quick Admin Setup Guide

## 🚀 Quick Fix: Enable Admin Creation

If you can't create new admin accounts, follow these steps:

### Step 1: Set Super Admin Emails in .env

Open your `.env` file and add this line (replace with your actual emails):

```env
SUPER_ADMIN_EMAILS=your-email@example.com,another-email@example.com,third-email@example.com
```

**Example:**
```env
SUPER_ADMIN_EMAILS=web@tanseeqinvestment.com,shadab.akhtar@tanseeqinvestment.com,admin@tanseeqinvestment.com
```

**Important:**
- Use comma-separated emails (no spaces around commas)
- These are the emails that can create other admin accounts
- Maximum 3 super admins as per your requirement

### Step 2: Set Admin Password in .env

Make sure you have this line in `.env`:

```env
ADMIN_PASSWORD=your_secure_password_here
```

### Step 3: Create Super Admin Accounts

Run this command to create the super admin accounts:

```bash
php artisan admin:create-super-admins
```

This will:
- Read emails from `SUPER_ADMIN_EMAILS` in `.env`
- Create user accounts for each email
- Set password from `ADMIN_PASSWORD` in `.env`

### Step 4: Login as Super Admin

1. Go to: `/admin/login`
2. Enter one of the super admin emails (from Step 1)
3. Enter the password (from `ADMIN_PASSWORD` in `.env`)
4. Click "Login"

### Step 5: Create New Admin Accounts

After logging in as a super admin:

1. You'll see the admin list page
2. Look for the **"Create Admin Account"** button (gray button)
3. Click it to open the registration form
4. Fill in:
   - Full Name
   - Email Address
   - Password (min 8 characters)
   - Confirm Password
5. Click "Create Account"

### ✅ Success!

The new admin can now:
- Login with their email and password
- View registrations list
- Edit registrations
- Export data
- **Cannot** create more admin accounts (only super admins can)

---

## 🔍 Troubleshooting

### "Create Admin Account" button not showing?

**Check:**
1. You're logged in with an email (not password-only)
2. Your email is in `SUPER_ADMIN_EMAILS` in `.env`
3. Clear cache: `php artisan config:clear`
4. Logout and login again

### "Access denied" when trying to create admin?

**Check:**
1. Your email exactly matches one in `SUPER_ADMIN_EMAILS` (case-sensitive)
2. No extra spaces in `.env` file
3. You ran `php artisan admin:create-super-admins` command
4. Clear cache: `php artisan config:clear`

### Can't login?

**Check:**
1. Email is correct (case-sensitive)
2. Password matches `ADMIN_PASSWORD` in `.env`
3. Super admin account exists (run `php artisan admin:create-super-admins`)

### Still having issues?

1. Check if super admin accounts exist:
   ```bash
   php artisan tinker
   ```
   Then:
   ```php
   \App\Models\User::all()->pluck('email');
   ```

2. Verify `.env` settings:
   ```bash
   php artisan config:clear
   php artisan cache:clear
   ```

3. Recreate super admins:
   ```bash
   php artisan admin:create-super-admins
   ```

---

## 📝 Quick Reference

**Super Admin Emails:** Set in `SUPER_ADMIN_EMAILS` in `.env`  
**Password:** Set in `ADMIN_PASSWORD` in `.env`  
**Create Command:** `php artisan admin:create-super-admins`  
**Login URL:** `/admin/login`  
**Create Admin URL:** `/admin/register` (only accessible by super admins)

