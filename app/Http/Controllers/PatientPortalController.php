<?php

namespace App\Http\Controllers;

use App\Services\HMISApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PatientPortalController extends Controller
{
    protected HMISApiService $hmisApi;

    public function __construct(HMISApiService $hmisApi)
    {
        $this->hmisApi = $hmisApi;
    }

    /**
     * Show the landing page
     */
    public function landing()
    {
        return view('landing');
    }

    /**
     * Show the customer home page
     */
    public function customerHome()
    {
        return view('customer_home');
    }

    /**
     * Show the patient login form
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Handle patient login
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $result = $this->hmisApi->authenticatePatient(
            $request->input('username'),
            $request->input('password')
        );

        if ($result && isset($result['token']) && isset($result['patient_id'])) {
            // Store authentication data in session
            Session::put('hmis_token', $result['token']);
            Session::put('patient_id', $result['patient_id']);
            Session::put('patient_authenticated', true);

            return redirect()->route('portal.dashboard')
                ->with('success', 'Login successful!');
        }

        return back()
            ->withErrors(['username' => 'Invalid credentials'])
            ->withInput($request->only('username'));
    }

    /**
     * Show patient dashboard
     */
    public function dashboard()
    {
        if (!Session::get('patient_authenticated')) {
            return redirect()->route('portal.login')
                ->withErrors(['error' => 'Please login to access your dashboard.']);
        }

        $patientId = Session::get('patient_id');
        $token = Session::get('hmis_token');

        // Fetch patient data
        $patient = $this->hmisApi->getPatientData($patientId, $token);

        if (!$patient) {
            Session::flush();
            return redirect()->route('portal.login')
                ->withErrors(['error' => 'Failed to fetch patient data. Please login again.']);
        }

        // Fetch appointments
        $appointments = $this->hmisApi->getPatientAppointments($patientId, $token);

        // Fetch medical records
        $medicalRecords = $this->hmisApi->getPatientMedicalRecords($patientId, $token);

        return view('patient.dashboard', [
            'patient' => $patient,
            'appointments' => $appointments,
            'medicalRecords' => $medicalRecords,
        ]);
    }

    /**
     * Logout patient
     */
    public function logout()
    {
        Session::forget(['hmis_token', 'patient_id', 'patient_authenticated']);

        return redirect()->route('portal.landing')
            ->with('success', 'You have been logged out successfully.');
    }
}
