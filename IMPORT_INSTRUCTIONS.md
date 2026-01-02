# How to Import Employees from Excel - Detailed Instructions

## Step-by-Step Guide

### Step 1: Prepare Your Excel File
Make sure your Excel file has the following structure:
- **Column A**: SI No (will be ignored)
- **Column B**: ERP II (Employee ID) - **REQUIRED**
- **Column C**: Name - **REQUIRED**
- **Column D**: Designation
- **Column E**: Department / Projects
- **Column F**: Entity

**Important**: 
- Row 1 should contain headers (will be automatically skipped)
- The file should be saved as `.xlsx` or `.xls` format
- Make sure Employee IDs are in Column B

### Step 2: Copy Your Excel File to Project Folder

**Option A: Copy file to project root**
1. Copy your Excel file
2. Paste it in: `D:\sites\tanseeq-run\`
3. Note the exact filename (e.g., `Employee Master.xlsx`)

**Option B: Use full path**
- Keep your file wherever it is
- Note the full path (e.g., `C:\Users\YourName\Desktop\Employee Master.xlsx`)

### Step 3: Open Terminal/PowerShell

**If you're in VS Code or Cursor:**
- Press `Ctrl + ~` to open terminal
- Make sure you're in the project directory: `D:\sites\tanseeq-run`

**If using Windows PowerShell:**
1. Press `Win + X` and select "Windows PowerShell"
2. Navigate to project folder:
   ```powershell
   cd D:\sites\tanseeq-run
   ```

### Step 4: Run the Import Command

**If file is in project root:**
```powershell
php artisan employees:import "Employee Master.xlsx"
```

**If file is in another location (use full path):**
```powershell
php artisan employees:import "C:\Users\YourName\Desktop\Employee Master.xlsx"
```

**If filename has spaces, use quotes:**
```powershell
php artisan employees:import "Employee Master Data.xlsx"
```

### Step 5: Check the Results

After running the command, you'll see output like:
```
Found 200 rows in the Excel file.
Starting import...

Import completed!
Imported: 195 employees
Updated: 0 employees
```

### Common Issues and Solutions

**Issue: "File not found"**
- Solution: Check the file path is correct
- Use full path if file is not in project folder
- Make sure filename includes extension (.xlsx or .xls)

**Issue: "Error reading Excel file"**
- Solution: Make sure file is not open in Excel
- Check file is not corrupted
- Try saving as .xlsx format

**Issue: "No employees imported"**
- Solution: Check that Column B has Employee IDs
- Check that Column C has Names
- Verify row 1 is headers (will be skipped)

### Example Commands

```powershell
# File in project root
php artisan employees:import employees.xlsx

# File on Desktop
php artisan employees:import "C:\Users\John\Desktop\employees.xlsx"

# File with spaces in name
php artisan employees:import "Employee Master List.xlsx"
```

### Verify Import

After importing, you can verify by:
1. Going to registration form: `http://localhost:8000/tanseeq-run`
2. Enter an Employee ID from your Excel file
3. If data auto-fills, import was successful!

