<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\LeaveRequest;

class LeaveRequestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LeaveRequest::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        static $counter = 0;
        
        return [
            'leaveRequestId' => 'LR-' . str_pad($counter++, 0, '0', STR_PAD_LEFT),
            'formId' => $this->faker->regexify('[A-Za-z0-9]{100}'),
            'submissionDate' => $this->faker->dateTime(),
            'employeeId' => $this->faker->regexify('[A-Za-z0-9]{100}'),
            'leaveType' => $this->faker->randomElement(["Annual","Medical","Other"]),
            'isEmergency' => $this->faker->boolean(),
            'lastRejoinDate' => $this->faker->dateTime(),
            'residence' => $this->faker->regexify('[A-Za-z0-9]{100}'),
            'leaveStartDate' => $this->faker->dateTime(),
            'leaveEndDate' => $this->faker->dateTime(),
            'duration' => $this->faker->word(),
            'travelDestination' => $this->faker->regexify('[A-Za-z0-9]{100}'),
            'reason' => $this->faker->text(),
            'destinationAddress' => $this->faker->regexify('[A-Za-z0-9]{100}'),
            'destinationPhone' => $this->faker->regexify('[A-Za-z0-9]{100}'),
            'contactNumberUAE' => $this->faker->regexify('[A-Za-z0-9]{100}'),
            'employeeEmail' => $this->faker->regexify('[A-Za-z0-9]{100}'),
            'approvedByEngineer' => $this->faker->boolean(),
            'approvedByProjectManager' => $this->faker->boolean(),
            'approvedBySrPM' => $this->faker->boolean(),
            'approvedByHOD' => $this->faker->boolean(),
            'eligibleDays' => $this->faker->word(),
            'passportEndDate' => $this->faker->dateTime(),
            'visaEndDate' => $this->faker->dateTime(),
            'workPermitEndDate' => $this->faker->dateTime(),
            'ticketEligibility' => $this->faker->boolean(),
            'leaveSalaryEligibility' => $this->faker->boolean(),
            'eligibiltyCheckedBy' => $this->faker->regexify('[A-Za-z0-9]{100}'),
            'approvedByHRManager' => $this->faker->boolean(),
            'approvedByCEO' => $this->faker->boolean(),
            'status' => $this->faker->regexify('[A-Za-z0-9]{100}'),
        ];
    }
}
