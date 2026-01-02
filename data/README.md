# Data Folder

This folder contains Excel files used for importing employee data.

## Employee Master File

Place your employee master Excel file here. The file should have:
- **Column B**: Employee ID (ERP II)
- **Column C**: Name
- **Column D**: Designation
- **Column E**: Department/Projects
- **Column F**: Entity

## Import Command

After placing the file here, run:

```bash
php artisan employees:import "data/YourFileName.xlsx"
```

## Note

Files in this folder are tracked in Git, so they will be available on production after deployment.

