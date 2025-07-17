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
            $table->boolean('approvedByEngineer')->nullable()->nullable();
            $table->boolean('approvedByProjectManager')->nullable()->nullable();
            $table->boolean('approvedBySrPM')->nullable()->nullable();
            $table->boolean('approvedByHOD')->nullable()->nullable();
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
            $table->timestamps();
            $table->softDeletes();
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
