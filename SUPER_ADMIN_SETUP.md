# Super Admin Setup Guide

## Overview

**Initial Setup:**
- Only **3 super admins** (defined in `.env`) can create other admin accounts
- These 3 are the initial admins who have full control

**How It Works:**
- When a super admin creates a user account, that user becomes an **admin**
- The new admin can access the admin area (view registrations, edit, export)
- But the new admin **cannot create more admin accounts** - only the 3 super admins can do that

---

## Step 1: Set Up Super Admin Emails

Open your `.env` file and add this line with the 3 super admin email addresses:

```env
SUPER_ADMIN_EMAILS=admin1@example.com,admin2@example.com,admin3@example.com
```

**Example:**
```env


```

**Important:**
- Use comma-separated email addresses
- No spaces around commas (or they will be trimmed)
- These emails must match the email addresses used when creating admin accounts

---

## Step 2: Create the 3 Super Admin Accounts

### Option A: Create via Database (First Time Setup)

If you don't have any admin accounts yet, you can create the first super admin directly:

1. **Run this command:**
   ```powershell
   php artisan tinker
   ```

2. **Create the super admin:**
   ```php
   $user = \App\Models\User::create([
       'name' => 'Super Admin 1',
       'email' => 'admin1@example.com',
       'password' => \Hash::make('your_secure_password'),
   ]);
   ```

3. **Repeat for the other 2 super admins**

4. **Exit tinker:**
   ```php
   exit
   ```

### Option B: Use Admin Registration (If Already Have Super Admin)

1. Login as one of the 3 super admins
2. Go to admin list page
3. Click "Create Admin Account" button (only visible to super admins)
4. Fill in the form and create the account

---

## Step 3: Verify Setup

### Check Super Admin Access

1. **Login as a super admin:**
   - Go to: `http://localhost:8000/admin/login`
   - Enter super admin email and password
   - Should see "Create Admin Account" button in admin list

2. **Login as regular admin:**
   - Create a regular admin account (not in SUPER_ADMIN_EMAILS list)
   - Login with that account
   - Should NOT see "Create Admin Account" button

### Test Creating Admin Accounts

1. **As super admin:**
   - Click "Create Admin Account"
   - Should be able to create new admin accounts ✅

2. **As regular admin:**
   - Try to access: `http://localhost:8000/admin/register`
   - Should see "Access denied" message ❌

---

## How It Works

### Super Admin Features:
- ✅ Can access admin area
- ✅ Can view registrations
- ✅ Can edit registrations
- ✅ Can export data
- ✅ **Can create new admin accounts** (only super admins)

### Regular Admin Features:
- ✅ Can access admin area
- ✅ Can view registrations
- ✅ Can edit registrations
- ✅ Can export data
- ❌ **Cannot create new admin accounts**

---

## Security Notes

⚠️ **Important Security Tips:**

1. **Keep super admin emails secret** - Don't share the `.env` file
2. **Use strong passwords** - At least 12 characters, mix of letters, numbers, symbols
3. **Limit super admin count** - Only 3 super admins as specified
4. **Regular admins are limited** - They cannot create other admins

---

## Troubleshooting

### Issue: "Access denied" even though I'm a super admin

**Check:**
1. Email in `.env` matches exactly (case-sensitive)
2. No extra spaces in `.env` file
3. Clear cache: `php artisan config:clear`
4. Logout and login again

### Issue: Can't see "Create Admin Account" button

**Check:**
1. Your email is in `SUPER_ADMIN_EMAILS` in `.env`
2. You're logged in with that email (not password-only login)
3. Clear cache: `php artisan config:clear`

### Issue: Regular admin can still create accounts

**Check:**
1. `.env` file has `SUPER_ADMIN_EMAILS` set correctly
2. Run: `php artisan config:clear`
3. Make sure the user's email is NOT in the super admin list

---

## Quick Reference

**Super Admin Emails:** Set in `.env` as `SUPER_ADMIN_EMAILS=email1,email2,email3`

**Create Admin Account:** Only visible to super admins in admin list page

**Access Control:**
- Super admins: Can create admin accounts
- Regular admins: Cannot create admin accounts
- All admins: Can access admin area and manage registrations

---

## Example .env Configuration

```env
# Admin Password (for backward compatibility)
ADMIN_PASSWORD=your_secure_password

# Super Admin Emails (comma-separated, no spaces)
SUPER_ADMIN_EMAILS=john@tanseeq.com,sarah@tanseeq.com,mike@tanseeq.com
```

---

## Need Help?

If you're having issues:
1. Check `.env` file has `SUPER_ADMIN_EMAILS` set
2. Clear config cache: `php artisan config:clear`
3. Verify email addresses match exactly (case-sensitive)
4. Make sure you're logged in with email (not password-only)

