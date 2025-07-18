<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('leave_requests', function (Blueprint $table) {
            $table->id();
            $table->string('leaveRequestId', 100)->nullable();
            $table->string('formId', 100)->nullable();
            $table->dateTime('submissionDate')->nullable();
            $table->string('employeeId', 100)->nullable();
            $table->enum('leaveType', ["Annual","Medical","Other"])->nullable();
            $table->boolean('isEmergency')->nullable();
            $table->dateTime('lastRejoinDate')->nullable();
            $table->string('residence', 100)->nullable();
            $table->dateTime('leaveStartDate')->nullable();
            $table->dateTime('leaveEndDate')->nullable();
            $table->string('duration')->nullable();
            $table->string('travelDestination', 100)->nullable();
            $table->text('reason', 500)->nullable();
            $table->string('destinationAddress', 100)->nullable();
            $table->string('destinationPhone', 100)->nullable();
            $table->string('contactNumberUAE', 100)->nullable();
            $table->string('employeeEmail', 100)->nullable();

            // Approval system fields
            $table->boolean('approvedByEngineer')->nullable()->nullable();
            $table->boolean('approvedByProjectManager')->nullable()->nullable();
            $table->boolean('approvedBySrPM')->nullable()->nullable();
            $table->boolean('approvedByHOD')->nullable()->nullable();

            // Leave eligibility fields
            $table->string('eligibleDays')->nullable();
            $table->dateTime('passportEndDate')->nullable();
            $table->dateTime('visaEndDate')->nullable();
            $table->dateTime('workPermitEndDate')->nullable();
            $table->boolean('ticketEligibility')->nullable();
            $table->boolean('leaveSalaryEligibility')->nullable();
            $table->string('eligibiltyCheckedBy', 100)->nullable();
            $table->boolean('approvedByHRManager')->nullable();
            $table->boolean('approvedByCEO')->nullable();
            $table->string('status', 100)->nullable();
            
            // Assignment system fields
            $table->unsignedBigInteger('user_id')->nullable();
            $table->boolean('is_data_entered')->default(false);
            // $table->integer('verify_count')->default(0);
            $table->unsignedBigInteger('verifier1')->nullable();
            $table->unsignedBigInteger('verifier2')->nullable();
            $table->unsignedBigInteger('verifier1_id')->nullable();
            $table->unsignedBigInteger('verifier2_id')->nullable();
            // $table->boolean('re_entry')->nullable();
            $table->boolean('is_data_correct')->default(false);
            $table->boolean('is_issue')->default(false);
            $table->boolean('is_leave')->default(false);
            $table->boolean('is_visa')->default(false);
            $table->boolean('is_photo')->default(false);
            $table->boolean('is_no_file_uploaded')->default(false);
            
            $table->timestamps();
            $table->softDeletes();
            
            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('verifier1')->references('id')->on('users')->onDelete('set null');
            $table->foreign('verifier2')->references('id')->on('users')->onDelete('set null');
            $table->foreign('verifier1_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('verifier2_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_requests');
    }
};
