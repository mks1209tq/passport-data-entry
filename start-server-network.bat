@echo off
echo ========================================
echo Starting Server for Network Access
echo ========================================
echo.
echo Your IP Addresses:
echo   192.168.70.44 (Main Network)
echo   172.16.0.2 (Secondary)
echo.
echo Share these links with employees:
echo   http://192.168.70.44/tanseeq-run
echo.
echo Admin List:
echo   http://192.168.70.44/tanseeq-run/list
echo.
echo ========================================
echo Server starting... Keep this window open!
echo Press Ctrl+C to stop the server
echo ========================================
echo.
php artisan serve --host=0.0.0.0 --port=8000



