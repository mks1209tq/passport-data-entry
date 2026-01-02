<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Employee;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportEmployeesFromExcel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'employees:import {file : Path to the Excel file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import employees from Excel file. Excel format: Column B=Employee ID, C=Name, D=Designation, E=Department/Projects, F=Entity';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filePath = $this->argument('file');
        
        if (!file_exists($filePath)) {
            $this->error("File not found: {$filePath}");
            return 1;
        }

        try {
            $spreadsheet = IOFactory::load($filePath);
            $worksheet = $spreadsheet->getActiveSheet();
            $highestRow = $worksheet->getHighestRow();
            
            $this->info("Found {$highestRow} rows in the Excel file.");
            $this->info("Starting import...");
            
            $imported = 0;
            $skipped = 0;
            $errors = 0;
            $totalRows = $highestRow - 1; // Exclude header row
            
            // Start from row 2 (assuming row 1 is header)
            for ($row = 2; $row <= $highestRow; $row++) {
                // Show progress every 100 rows
                $currentRow = $row - 1;
                if ($currentRow % 100 == 0) {
                    $progress = round(($currentRow / $totalRows) * 100);
                    $this->info("Processing... {$progress}% ({$currentRow}/{$totalRows} rows)");
                }
                // Column B = Employee ID
                $employeeId = trim($worksheet->getCell('B' . $row)->getValue());
                
                // Skip if employee ID is empty
                if (empty($employeeId)) {
                    continue;
                }
                
                // Column C = Name
                $name = trim($worksheet->getCell('C' . $row)->getValue());
                
                // Column D = Designation
                $designation = trim($worksheet->getCell('D' . $row)->getValue());
                
                // Column E = Department/Projects
                $departmentProjects = trim($worksheet->getCell('E' . $row)->getValue());
                
                // Column F = Entity
                $entity = trim($worksheet->getCell('F' . $row)->getValue());
                
                // Skip if name is empty
                if (empty($name)) {
                    $skipped++;
                    continue;
                }
                
                try {
                    // Check if employee already exists
                    $existing = Employee::where('employee_id', $employeeId)->first();
                    
                    if ($existing) {
                        // Update existing record
                        $existing->update([
                            'name' => $name,
                            'designation' => $designation,
                            'department_projects' => $departmentProjects,
                            'entity' => $entity,
                        ]);
                        $skipped++;
                    } else {
                        // Create new record
                        Employee::create([
                            'employee_id' => $employeeId,
                            'name' => $name,
                            'designation' => $designation,
                            'department_projects' => $departmentProjects,
                            'entity' => $entity,
                        ]);
                        $imported++;
                    }
                } catch (\Exception $e) {
                    $this->warn("Error importing row {$row}: " . $e->getMessage());
                    $errors++;
                }
            }
            
            $this->info("\nImport completed!");
            $this->info("Imported: {$imported} employees");
            $this->info("Updated: {$skipped} employees");
            if ($errors > 0) {
                $this->warn("Errors: {$errors} rows");
            }
            
            return 0;
        } catch (\Exception $e) {
            $this->error("Error reading Excel file: " . $e->getMessage());
            return 1;
        }
    }
}
