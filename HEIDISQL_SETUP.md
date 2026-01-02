# Setting Up Database in HeidiSQL

## Step 1: Create Database in HeidiSQL

1. **Open HeidiSQL**
2. **Connect to your MySQL/MariaDB server:**
   - Click "New" to create a new session
   - Network type: MySQL (TCP/IP)
   - Hostname/IP: `127.0.0.1` or `localhost`
   - User: `root` (or your MySQL username)
   - Password: (your MySQL password)
   - Port: `3306` (default)
   - Click "Open"

3. **Create the database:**
   - Right-click in the left panel → "Create new" → "Database"
   - Database name: `tanseeq_run`
   - Collation: `utf8mb4_unicode_ci`
   - Click "OK"

## Step 2: Update Laravel Configuration

### Update .env file:

Open `.env` file in your project and update these lines:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tanseeq_run
DB_USERNAME=root
DB_PASSWORD=your_mysql_password
```

Replace `your_mysql_password` with your actual MySQL password.

## Step 3: Run Migrations

After updating .env, run these commands:

```powershell
php artisan migrate:fresh
```

This will create all tables in your MySQL database.

## Step 4: Import Employee Data

After migrations, import your employees:

```powershell
php artisan employees:import "Tanseeq Run Registration Form(Employee Master).xlsx"
```

## Step 5: Verify in HeidiSQL

1. Refresh HeidiSQL (F5)
2. Expand `tanseeq_run` database
3. You should see these tables:
   - `employees`
   - `run_registrations`
   - `migrations`
   - And other Laravel default tables

## Troubleshooting

### Error: "Access denied for user"
- Check your MySQL username and password in .env
- Make sure MySQL user has permissions to create databases

### Error: "Can't connect to MySQL server"
- Make sure MySQL/MariaDB service is running
- Check if MySQL is running on port 3306
- Try `127.0.0.1` instead of `localhost`

### Error: "Unknown database"
- Make sure you created the database `tanseeq_run` in HeidiSQL first
- Check the database name in .env matches exactly

## Quick Checklist

- [ ] MySQL/MariaDB installed and running
- [ ] HeidiSQL installed
- [ ] Database `tanseeq_run` created in HeidiSQL
- [ ] .env file updated with MySQL credentials
- [ ] Migrations run successfully
- [ ] Employee data imported

