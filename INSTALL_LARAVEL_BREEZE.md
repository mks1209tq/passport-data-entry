# Installing Laravel Breeze - Step by Step

## ⚠️ Important Note

You already have a **custom admin authentication system** in place. Laravel Breeze will add:
- User registration/login pages
- Password reset functionality
- Email verification
- User dashboard

**Consider:** Do you need Breeze, or is your current admin system sufficient?

---

## Step 1: Install Breeze Package

Breeze is already in your `composer.json`, but you need to install it:

```powershell
composer require laravel/breeze --dev
```

**Note:** If you get an error saying it's already installed, that's fine - move to Step 2.

---

## Step 2: Choose Your Stack

Laravel Breeze supports different frontend stacks. Choose one:

### Option A: Blade (Recommended - Simple, No Build Step)
```powershell
php artisan breeze:install blade
```

### Option B: React
```powershell
php artisan breeze:install react
```

### Option C: Vue
```powershell
php artisan breeze:install vue
```

### Option D: API (For mobile apps)
```powershell
php artisan breeze:install api
```

**For this project, I recommend Blade** (simplest, works with your existing setup).

---

## Step 3: Install Dependencies

After installation, install npm dependencies:

```powershell
npm install
```

---

## Step 4: Build Assets

```powershell
npm run build
```

**For development** (with hot reload):
```powershell
npm run dev
```

---

## Step 5: Run Migrations

Breeze will create a migration for the `users` table (you might already have this):

```powershell
php artisan migrate
```

---

## Step 6: Test Installation

1. **Start your server:**
   ```powershell
   php artisan serve
   ```

2. **Visit these URLs:**
   - **Login:** `http://localhost:8000/login`
   - **Register:** `http://localhost:8000/register`
   - **Dashboard:** `http://localhost:8000/dashboard` (after login)

---

## What Breeze Installs

### Files Created:
- `resources/views/auth/` - Login, register, password reset views
- `resources/views/components/` - Reusable UI components
- `resources/views/layouts/` - App layout with navigation
- `app/Http/Controllers/Auth/` - Authentication controllers
- `routes/auth.php` - Authentication routes
- `app/View/Components/` - Blade components

### Routes Added:
- `GET /login` - Login page
- `POST /login` - Handle login
- `GET /register` - Registration page
- `POST /register` - Handle registration
- `GET /forgot-password` - Password reset request
- `POST /forgot-password` - Send reset link
- `GET /reset-password/{token}` - Reset password form
- `POST /reset-password` - Update password
- `GET /dashboard` - User dashboard (protected)
- `POST /logout` - Logout

---

## Integration with Your Existing System

### Current Setup:
- ✅ Custom admin login at `/admin/login`
- ✅ Password-based authentication
- ✅ Admin routes protected by `admin` middleware

### With Breeze:
- ✅ User registration/login at `/login` and `/register`
- ✅ User dashboard at `/dashboard`
- ✅ Password reset functionality
- ⚠️ **Separate from your admin system**

### Option 1: Keep Both Separate (Recommended)
- **Users:** Use Breeze routes (`/login`, `/register`, `/dashboard`)
- **Admins:** Keep your existing system (`/admin/login`)

### Option 2: Integrate
- Modify Breeze to work with your admin system
- More complex, requires custom changes

---

## Customization

### Change Default Routes

Edit `routes/auth.php` to customize routes.

### Customize Views

Edit files in `resources/views/auth/`:
- `login.blade.php` - Login page
- `register.blade.php` - Registration page
- `forgot-password.blade.php` - Password reset request
- `reset-password.blade.php` - Reset password form

### Customize Layout

Edit `resources/views/layouts/app.blade.php` for the main layout.

---

## Complete Installation Commands

**All in one go:**

```powershell
# 1. Install Breeze (if not already)
composer require laravel/breeze --dev

# 2. Install Breeze with Blade stack
php artisan breeze:install blade

# 3. Install npm dependencies
npm install

# 4. Build assets
npm run build

# 5. Run migrations
php artisan migrate

# 6. Start server
php artisan serve
```

---

## Troubleshooting

### Error: "Class 'Laravel\Breeze\BreezeServiceProvider' not found"
**Solution:**
```powershell
composer dump-autoload
php artisan config:clear
```

### Error: "npm is not recognized"
**Solution:**
- Install Node.js: https://nodejs.org/
- Restart your terminal/PowerShell

### Error: "Migration already exists"
**Solution:**
- Breeze tries to create `users` table migration
- If you already have it, you can skip or delete the duplicate

### Routes Conflict
**Solution:**
- Breeze adds routes that might conflict with yours
- Check `routes/auth.php` and `routes/web.php`
- Adjust route names if needed

---

## After Installation

### Test User Registration

1. Go to: `http://localhost:8000/register`
2. Fill in the form
3. Submit
4. You should be logged in and redirected to `/dashboard`

### Test Login

1. Go to: `http://localhost:8000/login`
2. Enter credentials
3. Should redirect to `/dashboard`

### Test Logout

1. Click "Logout" in the navigation
2. Should redirect to home page

---

## Next Steps

1. **Customize the views** to match your design
2. **Add email verification** (if needed)
3. **Integrate with your admin system** (if desired)
4. **Add user roles/permissions** (you already have Spatie Permission installed)

---

## Quick Reference

**Breeze Routes:**
- `/login` - User login
- `/register` - User registration
- `/dashboard` - User dashboard (protected)
- `/forgot-password` - Password reset
- `/logout` - Logout

**Your Existing Routes:**
- `/admin/login` - Admin login
- `/tanseeq-run` - Registration form
- `/tanseeq-run/list` - Admin list (protected)

---

## Need Help?

If you encounter issues:
1. Check Laravel logs: `storage/logs/laravel.log`
2. Clear cache: `php artisan config:clear`
3. Rebuild assets: `npm run build`
4. Check Breeze documentation: https://laravel.com/docs/breeze

