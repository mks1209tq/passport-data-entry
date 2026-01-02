<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\RunRegistration;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportBibNumbersFromExcel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bib-numbers:import {file : Path to the Excel file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import bib numbers from Excel file. Excel format: Column with Employee ID and Column with Bib Number';

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
            $this->info("Note: Excel should have Employee ID in one column and Bib Number in another column.");
            $this->info("Please specify which columns contain Employee ID and Bib Number.");
            
            // Ask user for column letters
            $employeeIdColumn = $this->ask('Which column contains Employee ID? (e.g., A, B, C)', 'B');
            $bibNumberColumn = $this->ask('Which column contains Bib Number? (e.g., A, B, C)', 'C');
            
            $imported = 0;
            $skipped = 0;
            $errors = 0;
            $totalRows = $highestRow - 1; // Exclude header row
            
            // Start from row 2 (assuming row 1 is header)
            for ($row = 2; $row <= $highestRow; $row++) {
                // Get Employee ID
                $employeeId = trim($worksheet->getCell($employeeIdColumn . $row)->getValue());
                
                // Skip if employee ID is empty
                if (empty($employeeId)) {
                    continue;
                }
                
                // Get Bib Number
                $bibNumber = trim($worksheet->getCell($bibNumberColumn . $row)->getValue());
                
                // Skip if bib number is empty
                if (empty($bibNumber)) {
                    $skipped++;
                    continue;
                }
                
                try {
                    // Find registration by employee ID
                    $registration = RunRegistration::where('employee_id', $employeeId)->first();
                    
                    if ($registration) {
                        // Update bib number
                        $registration->update([
                            'bib_number' => $bibNumber
                        ]);
                        $imported++;
                    } else {
                        $this->warn("Registration not found for Employee ID: {$employeeId}");
                        $errors++;
                    }
                } catch (\Exception $e) {
                    $this->warn("Error importing row {$row}: " . $e->getMessage());
                    $errors++;
                }
            }
            
            $this->info("\nImport completed!");
            $this->info("Imported: {$imported} bib numbers");
            $this->info("Skipped: {$skipped} rows (empty bib number)");
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
