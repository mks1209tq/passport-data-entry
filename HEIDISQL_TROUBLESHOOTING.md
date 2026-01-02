# HeidiSQL Troubleshooting: Tables Not Showing

## Common Issues and Solutions

### Issue 1: Tables Not Visible After Connection

**Symptoms:**
- Connected to database successfully
- Database `tanseeq_run` exists
- But no tables showing in left panel

**Solutions:**

#### Step 1: Select the Database
1. In HeidiSQL, look at the **top dropdown** (next to the connection name)
2. Make sure **`tanseeq_run`** is selected
3. If it shows "No database selected", click the dropdown and select `tanseeq_run`

#### Step 2: Refresh the View
1. Press **F5** to refresh
2. OR right-click on `tanseeq_run` → **"Refresh"**
3. OR click the **refresh icon** (circular arrow) in the toolbar

#### Step 3: Expand the Database
1. Click the **arrow** next to `tanseeq_run` to expand it
2. You should see a folder icon for "Tables"
3. Click the arrow next to "Tables" to see all tables

---

### Issue 2: Migrations Not Run

**Symptoms:**
- Database exists but has no tables
- Or only sees default MySQL tables

**Solution: Run Migrations**

1. **Open PowerShell/Terminal** in your project folder
2. **Check your .env file** - make sure it has:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=tanseeq_run
   DB_USERNAME=root
   DB_PASSWORD=your_password
   ```

3. **Run migrations:**
   ```powershell
   php artisan migrate
   ```

4. **Expected output:**
   ```
   Migration table created successfully.
   Migrating: 2025_12_31_120103_create_employees_table
   Migrated:  2025_12_31_120103_create_employees_table
   ...
   ```

5. **Refresh HeidiSQL (F5)**
6. Tables should now appear!

---

### Issue 3: Wrong Database Selected

**Check:**
1. In HeidiSQL, look at the **database dropdown** at the top
2. Make sure it shows: **`tanseeq_run`**
3. If it shows something else (like `information_schema` or `mysql`), click and select `tanseeq_run`

---

### Issue 4: Database Doesn't Exist

**Symptoms:**
- Can't find `tanseeq_run` in the database list

**Solution: Create the Database**

1. In HeidiSQL, **right-click** on your server connection (top level)
2. Select **"Create new"** → **"Database"**
3. Enter name: **`tanseeq_run`**
4. Collation: **`utf8mb4_unicode_ci`**
5. Click **"OK"**
6. Then run migrations (see Issue 2)

---

### Issue 5: Connection Issues

**Symptoms:**
- Can't connect to MySQL
- "Access denied" error
- "Can't connect to MySQL server"

**Solutions:**

#### Check MySQL is Running
1. Open **Services** (Windows: Win+R → `services.msc`)
2. Look for **MySQL** or **MariaDB**
3. Make sure it's **Running**
4. If not, right-click → **Start**

#### Check Connection Settings
In HeidiSQL, verify:
- **Hostname/IP:** `127.0.0.1` or `localhost`
- **User:** `root` (or your MySQL username)
- **Password:** Your MySQL password
- **Port:** `3306`

#### Test Connection
1. In HeidiSQL, click **"Test"** button
2. Should show "Connection successful"
3. If not, check your MySQL password

---

### Issue 6: Tables Exist But Can't See Data

**Symptoms:**
- Tables are visible
- But when you click on a table, no data shows

**Solutions:**

#### Check if Tables Have Data
1. Click on a table (e.g., `employees`)
2. Click the **"Data"** tab at the bottom
3. Should show rows of data

#### If No Data:
- **For `employees` table:** Run the import command:
  ```powershell
  php artisan employees:import "data/Tanseeq Run Registration Form(Employee Master).xlsx"
  ```

- **For `run_registrations` table:** This will have data after people register

---

## Step-by-Step: Complete Setup

### Step 1: Connect to MySQL
1. Open HeidiSQL
2. Click **"New"**
3. Enter connection details:
   - Network type: **MySQL (TCP/IP)**
   - Hostname/IP: **127.0.0.1**
   - User: **root**
   - Password: **your_password**
   - Port: **3306**
4. Click **"Save"** and **"Open"**

### Step 2: Create Database (if not exists)
1. Right-click on server → **"Create new"** → **"Database"**
2. Name: **`tanseeq_run`**
3. Collation: **`utf8mb4_unicode_ci`**
4. Click **"OK"**

### Step 3: Select Database
1. Click the **database dropdown** at the top
2. Select **`tanseeq_run`**

### Step 4: Run Migrations
1. Open PowerShell in project folder
2. Run: `php artisan migrate`
3. Wait for completion

### Step 5: Verify in HeidiSQL
1. Press **F5** to refresh
2. Expand **`tanseeq_run`** database
3. Expand **"Tables"** folder
4. You should see:
   - ✅ `employees`
   - ✅ `run_registrations`
   - ✅ `migrations`
   - ✅ `users`
   - ✅ `cache`
   - ✅ `jobs`
   - ✅ And other Laravel tables

### Step 6: Import Employee Data
1. In PowerShell, run:
   ```powershell
   php artisan employees:import "data/Tanseeq Run Registration Form(Employee Master).xlsx"
   ```

2. In HeidiSQL:
   - Click on **`employees`** table
   - Click **"Data"** tab
   - Should see employee records!

---

## Quick Checklist

- [ ] MySQL/MariaDB service is running
- [ ] Connected to MySQL in HeidiSQL
- [ ] Database `tanseeq_run` exists
- [ ] Database `tanseeq_run` is selected (top dropdown)
- [ ] Migrations have been run (`php artisan migrate`)
- [ ] HeidiSQL refreshed (F5)
- [ ] Tables folder expanded
- [ ] Can see tables in the list

---

## Still Not Working?

### Check Migration Status
Run this in PowerShell:
```powershell
php artisan migrate:status
```

This shows which migrations have run. All should show "Ran".

### Check Database Connection
Run this in PowerShell:
```powershell
php artisan tinker
```

Then type:
```php
DB::connection()->getPdo();
\DB::select('SHOW TABLES');
```

Should show all tables.

### Check .env File
Make sure `.env` has correct database settings:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tanseeq_run
DB_USERNAME=root
DB_PASSWORD=your_actual_password
```

---

## Common Error Messages

### "Access denied for user"
- Wrong password in `.env` or HeidiSQL
- User doesn't have permissions

### "Unknown database 'tanseeq_run'"
- Database doesn't exist
- Create it in HeidiSQL first

### "Table doesn't exist"
- Migrations haven't been run
- Run: `php artisan migrate`

### "Can't connect to MySQL server"
- MySQL service not running
- Wrong hostname/IP
- Firewall blocking connection

---

## Need More Help?

1. **Check Laravel logs:**
   ```powershell
   type storage\logs\laravel.log
   ```

2. **Test database connection:**
   ```powershell
   php artisan tinker
   >>> DB::connection()->getPdo();
   ```

3. **Verify migrations:**
   ```powershell
   php artisan migrate:status
   ```

