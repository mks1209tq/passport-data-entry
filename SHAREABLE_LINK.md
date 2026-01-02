# Shareable Link for Employees

## 🌐 Network Access Setup

Since `tanseeq-run.test` only works on your computer, you need to use your IP address.

## 📋 Step 1: Start the Server for Network Access

**Option A: Double-click the file**
1. Find `start-server-network.bat` in your project folder
2. Double-click it
3. **Keep the window open!**

**Option B: Manual command**
Open PowerShell/Terminal and run:
```powershell
php artisan serve --host=0.0.0.0 --port=8000
```

## 🔗 Step 2: Share This Link with Employees

### Registration Form Link:
```
http://192.168.70.44/tanseeq-run
```

### Admin List (For You):
```
http://192.168.70.44/tanseeq-run/list
```

## ⚠️ Important Requirements

1. **Server must be running** - Keep the server window open
2. **Same network** - Employees must be on the same Wi-Fi/network as you
3. **Windows Firewall** - May need to allow port 8000 (or temporarily disable firewall for testing)

## 🔥 If Windows Firewall Blocks Access

1. Open Windows Defender Firewall
2. Click "Allow an app through firewall"
3. Add PHP or allow port 8000
4. Or temporarily disable firewall for testing

## 📱 Alternative: If IP Doesn't Work

Try the other IP address:
```
http://172.16.0.2/tanseeq-run
```

## ✅ Test It

1. Start the server using `start-server-network.bat`
2. On your phone (same Wi-Fi), try: `http://192.168.70.44/tanseeq-run`
3. If it works, share that link with employees!



