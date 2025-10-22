<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class HMISApiService
{
    protected string $baseUrl;
    protected ?string $token;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('services.hmis.api_url', env('HMIS_API_URL', '')), '/');
        $this->token = config('services.hmis.api_token', env('HMIS_API_TOKEN', null));
    }

    /**
     * Authenticate a patient and get a token
     *
     * @param string $username
     * @param string $password
     * @return array|null
     */
    public function authenticatePatient(string $username, string $password): ?array
    {
        try {
            $response = Http::timeout(30)
                ->post("{$this->baseUrl}/auth/login", [
                    'username' => $username,
                    'password' => $password,
                ]);

            if ($response->successful()) {
                return $response->json();
            }

            Log::warning('Patient authentication failed', [
                'username' => $username,
                'status' => $response->status(),
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('Error authenticating patient', [
                'username' => $username,
                'error' => $e->getMessage(),
            ]);

            return null;
        }
    }

    /**
     * Get patient data by patient ID
     *
     * @param string $patientId
     * @param string|null $token
     * @return array|null
     */
    public function getPatientData(string $patientId, ?string $token = null): ?array
    {
        try {
            $token = $token ?? $this->token;

            $request = Http::timeout(30);

            if ($token) {
                $request = $request->withToken($token);
            }

            $response = $request->get("{$this->baseUrl}/patients/{$patientId}");

            if ($response->successful()) {
                return $response->json();
            }

            Log::warning('Failed to get patient data', [
                'patient_id' => $patientId,
                'status' => $response->status(),
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('Error getting patient data', [
                'patient_id' => $patientId,
                'error' => $e->getMessage(),
            ]);

            return null;
        }
    }

    /**
     * Get patient appointments
     *
     * @param string $patientId
     * @param string|null $token
     * @return array
     */
    public function getPatientAppointments(string $patientId, ?string $token = null): array
    {
        try {
            $token = $token ?? $this->token;

            $request = Http::timeout(30);

            if ($token) {
                $request = $request->withToken($token);
            }

            $response = $request->get("{$this->baseUrl}/patients/{$patientId}/appointments");

            if ($response->successful()) {
                return $response->json() ?? [];
            }

            Log::warning('Failed to get patient appointments', [
                'patient_id' => $patientId,
                'status' => $response->status(),
            ]);

            return [];
        } catch (\Exception $e) {
            Log::error('Error getting patient appointments', [
                'patient_id' => $patientId,
                'error' => $e->getMessage(),
            ]);

            return [];
        }
    }

    /**
     * Get patient medical records
     *
     * @param string $patientId
     * @param string|null $token
     * @return array
     */
    public function getPatientMedicalRecords(string $patientId, ?string $token = null): array
    {
        try {
            $token = $token ?? $this->token;

            $request = Http::timeout(30);

            if ($token) {
                $request = $request->withToken($token);
            }

            $response = $request->get("{$this->baseUrl}/patients/{$patientId}/medical-records");

            if ($response->successful()) {
                return $response->json() ?? [];
            }

            Log::warning('Failed to get patient medical records', [
                'patient_id' => $patientId,
                'status' => $response->status(),
            ]);

            return [];
        } catch (\Exception $e) {
            Log::error('Error getting patient medical records', [
                'patient_id' => $patientId,
                'error' => $e->getMessage(),
            ]);

            return [];
        }
    }
}
