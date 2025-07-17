<?php

namespace App\Console\Commands\passport;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\Passport;
use Carbon\Carbon;
use Aws\S3\S3Client;
use Aws\Exception\AwsException;

class TraverseIDriveAndUpdatePassports extends Command
{
    protected $signature = 'app:update-passports {path? : The path within the bucket to process}';
    protected $description = 'Process passport PDFs from iDrive E2 and update database';

    protected $s3;
    protected $disk;

    public function __construct()
    {
        parent::__construct();
        $this->disk = Storage::disk('idrive_e2');
        $this->s3 = $this->disk->getClient();
    }

    public function handle()
    {
        $this->info('Starting passport update process...');

        try {
            $this->info('Successfully connected to iDrive E2 storage.');

            $bucket = config('filesystems.disks.idrive_e2.bucket');
            $path = $this->argument('path') ?? '';

            // List objects in the bucket using listObjects
            $result = $this->s3->listObjects([
                'Bucket' => $bucket,
                'Prefix' => $path,
            ]);

            if (isset($result['Contents'])) {
                $files = array_column($result['Contents'], 'Key');
                $this->info('Found ' . count($files) . ' files in the bucket.');

                foreach ($files as $file) {
                    if ($this->isPdfFile($file)) {
                        $this->processFile($file);
                    } else {
                        $this->info("Skipping non-PDF file: $file");
                    }
                }
            } else {
                $this->warn('No files found in the specified path.');
            }

        } catch (AwsException $e) {
            $this->error('An AWS error occurred: ' . $e->getMessage());
        } catch (\Exception $e) {
            $this->error('An error occurred: ' . $e->getMessage());
            $this->error('Stack trace: ' . $e->getTraceAsString());
        }

        $this->info('Passport update process completed.');
    }

    private function isPdfFile($fileName)
    {
        return strtolower(pathinfo($fileName, PATHINFO_EXTENSION)) === 'pdf';
    }

    private function processFile($fileName)
    {
        $this->info("Processing file: $fileName");

        // Extract employee ID from filename
        $employeeId = $this->extractEmployeeId($fileName);

        // Get file metadata
        $size = $this->disk->size($fileName);
        $lastModified = $this->disk->lastModified($fileName);

        // Here you would typically extract passport and visa expiry dates from the PDF content
        // For now, we'll use placeholder dates
        $passportExpiryDate = Carbon::now()->addYears(5);
        $visaExpiryDate = Carbon::now()->addYears(2);

        // Update or create passport record
        $passport = Passport::updateOrCreate(
            ['employee_id' => $employeeId],
            [
                'file_name' => $fileName,
                'passport_expiry_date' => $passportExpiryDate,
                'visa_expiry_date' => $visaExpiryDate,
                'is_data_entered' => true,
                'is_data_correct' => false, // Set to false initially, to be verified manually
                // 'user_id' => null, // Set this if you have a user associated with the entry
            ]
        );

        $this->info("Updated passport record for employee ID: $employeeId");
        $this->info("Passport ID: {$passport->id}");
        $this->info("File Name: {$passport->file_name}");
        $this->info("Passport Expiry Date: {$passport->passport_expiry_date}");
        $this->info("Visa Expiry Date: {$passport->visa_expiry_date}");
    }

    private function extractEmployeeId($fileName)
    {
        // Extract employee ID from filename (assuming format is 'xxxxx-xx.pdf')
        $baseName = pathinfo($fileName, PATHINFO_FILENAME);
        return substr($baseName, 0, strpos($baseName, '-'));
    }
}
