# How to Install Spatie Packages

Spatie is a popular Laravel package provider. Here are common Spatie packages you might need:

## Common Spatie Packages

### 1. Laravel Permission (Roles & Permissions)
For advanced user roles and permissions:
```powershell
composer require spatie/laravel-permission
```

### 2. Laravel Backup
For backing up your application:
```powershell
composer require spatie/laravel-backup
```

### 3. Laravel Activity Log
For logging user activities:
```powershell
composer require spatie/laravel-activitylog
```

### 4. Laravel Media Library
For handling file uploads:
```powershell
composer require spatie/laravel-medialibrary
```

## Installation Steps

### Step 1: Install the Package
```powershell
composer require spatie/package-name
```

### Step 2: Publish Configuration (if needed)
```powershell
php artisan vendor:publish --provider="Spatie\PackageName\PackageNameServiceProvider"
```

### Step 3: Run Migrations (if needed)
```powershell
php artisan migrate
```

## Example: Installing Laravel Permission

If you want to install Spatie Laravel Permission for roles:

```powershell
# Install package
composer require spatie/laravel-permission

# Publish migration
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"

# Run migrations
php artisan migrate
```

## Which Package Do You Need?

Please specify which Spatie package you want to install, or what functionality you're looking for, and I can help you install it!

