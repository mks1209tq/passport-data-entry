# Tanseeq Run Registration - Links and Information

## 🔗 Shareable Links

### For Employees to Register:
```
http://tanseeq-run.test/
```
or
```
http://tanseeq-run.test/tanseeq-run
```

### Admin Dashboard (View All Registrations):
```
http://tanseeq-run.test/tanseeq-run/list
```

### Export Registrations to CSV:
```
http://tanseeq-run.test/tanseeq-run/export
```

---

## 📋 How It Works

### For Employees:
1. Go to: `http://tanseeq-run.test/`
2. Enter their **Employee ID** (from the Excel file)
3. The form will **automatically fill**:
   - Name
   - Designation
   - Department/Projects
   - Entity
4. They need to **manually enter**:
   - Date of Birth
   - Contact Number
5. They need to **select**:
   - UN Category: 2.5KM, 5KM, or 10KM
   - T-Shirt Size: S, M, L, XL, XXL, or XXXL
6. Click **Register**
7. They will see a **success message** with their unique **Registration ID**

### For Admin (You):
1. Go to: `http://tanseeq-run.test/tanseeq-run/list`
2. View all registrations in a table
3. See all details:
   - Registration ID
   - Employee ID
   - Name
   - Designation
   - Department/Projects
   - Entity
   - Date of Birth
   - Contact Number
   - UN Category
   - T-Shirt Size
   - Registration Date/Time
4. Click **"Export to CSV"** to download all registrations

---

## ✅ Features

- ✅ **Auto-fill employee data** when Employee ID is entered
- ✅ **One registration per Employee ID** (prevents duplicates)
- ✅ **Unique Registration ID** generated for each registration (format: TR-XXXXXXXX)
- ✅ **Success message** displayed after registration
- ✅ **Admin dashboard** to view all registrations
- ✅ **CSV export** functionality
- ✅ **Mobile-friendly** registration form

---

## 🔒 Security Notes

- Each employee can only register **once** (based on Employee ID)
- If someone tries to register again, they'll see their existing Registration ID
- All data is stored securely in the database

---

## 📱 Sharing the Link

### Option 1: Same Network (LAN)
If employees are on the same Wi-Fi/network:
1. Find your computer's IP address:
   - Open PowerShell
   - Run: `ipconfig`
   - Look for "IPv4 Address" (e.g., `192.168.1.100`)
2. Share this link:
   ```
   http://YOUR_IP/tanseeq-run
   ```
   Example: `http://192.168.1.100/tanseeq-run`

### Option 2: Internet Access
For employees to access from anywhere:
- Deploy to a web server (Heroku, DigitalOcean, AWS, etc.)
- Or use a service like ngrok for temporary public access

---

## 🛠️ Troubleshooting

### Registration Not Working?
- Make sure employees are using a valid Employee ID from your Excel file
- Check that the employee data was imported successfully

### Can't See Registrations?
- Go to: `http://tanseeq-run.test/tanseeq-run/list`
- Make sure at least one registration has been completed

### Export Not Working?
- Make sure you have registrations in the database
- Try refreshing the page

---

## 📞 Support

If you encounter any issues:
1. Check that the server is running
2. Verify the database has employee data
3. Check browser console for errors
4. Make sure all migrations have been run

