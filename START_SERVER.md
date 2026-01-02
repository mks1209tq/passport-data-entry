# How to Start the Server

## Quick Start

### Method 1: Double-click the batch file (Easiest)
1. Find the file `start-server.bat` in your project folder
2. Double-click it
3. A black window will open showing the server is running
4. **Keep this window open** - don't close it!
5. Open your browser and go to: `http://localhost:8000/tanseeq-run`

### Method 2: Using PowerShell/Terminal
1. Open PowerShell or Terminal in the project folder
2. Run this command:
   ```powershell
   php artisan serve
   ```
3. You should see:
   ```
   INFO  Server running on [http://127.0.0.1:8000]
   ```
4. **Keep this window open** - don't close it!
5. Open your browser and go to: `http://localhost:8000/tanseeq-run`

## Important Notes

⚠️ **The server must be running for the website to work!**

- The server window/terminal must stay open
- If you close it, the website will stop working
- You can minimize the window, but don't close it

## Links

Once the server is running:

- **Registration Form (for employees):** http://localhost:8000/tanseeq-run
- **Admin Dashboard (view all registrations):** http://localhost:8000/tanseeq-run/list

## Troubleshooting

### Error: "Port 8000 is already in use"
- Another application is using port 8000
- Use a different port:
  ```powershell
  php artisan serve --port=8001
  ```
- Then use: `http://localhost:8001/tanseeq-run`

### Error: "php is not recognized"
- PHP is not in your system PATH
- Make sure XAMPP/WAMP/Laravel is properly installed
- Or use the full path to PHP

### Still can't connect?
1. Make sure the server window shows "Server running on..."
2. Try `http://127.0.0.1:8000/tanseeq-run` instead of `localhost`
3. Check Windows Firewall isn't blocking it

