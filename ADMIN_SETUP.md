# Admin Authentication Setup

## 🔐 Admin Login

The admin area is now password protected. Only admins can access:
- `/tanseeq-run/list` - View all registrations
- `/tanseeq-run/export` - Export to CSV
- `/tanseeq-run/edit/{id}` - Edit registrations

## 📝 Setup Password

### Step 1: Set Admin Password

Open your `.env` file and add this line:

```env
ADMIN_PASSWORD=your_secure_password_here
```

**Example:**
```env
ADMIN_PASSWORD=Tanseeq2025!
```

**Default password** (if not set in .env): `admin123`

⚠️ **Important:** Change the default password immediately!

### Step 2: Access Admin Area

1. Go to: `http://tanseeq-run.test/admin/login`
2. Enter your admin password
3. Click "Login"
4. You'll be redirected to the registrations list

## 🔗 Admin Links

- **Login Page:** `http://tanseeq-run.test/admin/login`
- **Registrations List:** `http://tanseeq-run.test/tanseeq-run/list` (requires login)
- **Logout:** Click "Logout" button in the admin area

## 🔒 Security

- Employees can only access the registration form: `http://tanseeq-run.test/`
- Admin pages require password authentication
- Session expires when browser is closed (or click Logout)

## 📋 Quick Reference

| Page | Access | URL |
|------|--------|-----|
| Registration Form | Public | `http://tanseeq-run.test/` |
| Admin Login | Public | `http://tanseeq-run.test/admin/login` |
| Registrations List | Admin Only | `http://tanseeq-run.test/tanseeq-run/list` |
| Export CSV | Admin Only | `http://tanseeq-run.test/tanseeq-run/export` |
| Edit Registration | Admin Only | `http://tanseeq-run.test/tanseeq-run/edit/{id}` |

