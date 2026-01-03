# Admin Login Guide

## 🔐 How to Login

### Step 1: Go to Admin Login Page
Visit: `/admin/login`

### Step 2: Enter Your Credentials
- **Email:** Enter your super admin email address
  - `web@tanseeqinvestment.com` OR
  - `shadab.akhtar@tanseeqinvestment.com`
- **Password:** Enter the password from `ADMIN_PASSWORD` in your `.env` file

### Step 3: Click Login
After successful login, you'll be redirected to the registrations list page.

---

## 👥 Creating New Admin Accounts

### After Logging In:

1. **You'll see the admin list page** with all registrations
2. **Look for "Create Admin Account" button** (only visible to super admins)
3. **Click the button** to create a new admin account
4. **Fill in the form:**
   - Full Name
   - Email Address
   - Password (minimum 8 characters)
   - Confirm Password
5. **Click "Create Account"**

### New Admin Access:
- The new admin can login with their email and password
- They can view registrations, edit, and export data
- They **cannot** create more admin accounts (only super admins can)

---

## ❌ Troubleshooting

### "Invalid email or password" Error

**Check:**
1. Email is correct (case-sensitive)
2. Password matches `ADMIN_PASSWORD` in `.env` file
3. You're using one of the super admin emails:
   - `web@tanseeqinvestment.com`
   - `shadab.akhtar@tanseeqinvestment.com`

### Can't See "Create Admin Account" Button

**Check:**
1. You're logged in with a super admin email
2. Your email is in `SUPER_ADMIN_EMAILS` in `.env`
3. Clear cache: `php artisan config:clear`
4. Logout and login again

### Need to Reset Password

Run this command to recreate super admin accounts:
```bash
php artisan admin:create-super-admins
```

This will create/update super admin accounts with the password from `ADMIN_PASSWORD` in `.env`.

---

## 📝 Quick Reference

**Super Admin Emails:**
- `web@tanseeqinvestment.com`
- `shadab.akhtar@tanseeqinvestment.com`

**Password:** Use the value from `ADMIN_PASSWORD` in your `.env` file

**Login URL:** `/admin/login`

**Admin List:** `/tanseeq-run/list` (after login)

