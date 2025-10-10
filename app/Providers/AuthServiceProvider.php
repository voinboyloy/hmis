<?php

namespace App\Providers;

use App\Models\Patient;
use App\Models\Encounter;
use App\Models\Appointment;
use App\Policies\PatientPolicy;
use App\Policies\EncounterPolicy;
use App\Policies\AppointmentPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Patient::class => PatientPolicy::class,
        Appointment::class => AppointmentPolicy::class,
        Encounter::class => EncounterPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        //
    }
}
