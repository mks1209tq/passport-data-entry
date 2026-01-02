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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id')->unique()->comment('ERP II from Excel Column B');
            $table->string('name')->comment('Name from Excel Column C');
            $table->string('designation')->comment('Designation from Excel Column D');
            $table->text('department_projects')->nullable()->comment('Department/Projects from Excel Column E');
            $table->string('entity')->comment('Entity from Excel Column F');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
