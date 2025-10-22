<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;

class HMISApiService
{
    protected $base;
    protected $token;

    public function __construct()
    {
        $this->base = rtrim(config('services.hmis.url', env('HMIS_API_URL', 'http://localhost:5000/api/v1')), '/');
        $this->token = config('services.hmis.token', env('HMIS_API_TOKEN', ''));
    }

    protected function client()
    {
        $client = Http::acceptJson();
        if (!empty($this->token)) {
            $client = $client->withToken($this->token);
        }
        return $client->baseUrl($this->base);
    }

    public function loginPatient(array $credentials)
    {
        try {
            $res = $this->client()->post('/auth/login', $credentials);
            return $res->successful() ? $res->json() : null;
        } catch (RequestException $e) {
            report($e);
            return null;
        }
    }

    public function getPatient($patientId)
    {
        try {
            $res = $this->client()->get("/patients/{$patientId}");
            return $res->successful() ? $res->json() : null;
        } catch (RequestException $e) {
            report($e);
            return null;
        }
    }

    public function getEncounters($patientId)
    {
        try {
            $res = $this->client()->get("/patients/{$patientId}/encounters");
            return $res->successful() ? $res->json() : [];
        } catch (RequestException $e) {
            report($e);
            return [];
        }
    }

    public function getAppointments($patientId)
    {
        try {
            $res = $this->client()->get("/patients/{$patientId}/appointments");
            return $res->successful() ? $res->json() : [];
        } catch (RequestException $e) {
            report($e);
            return [];
        }
    }
}
