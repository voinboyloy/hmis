<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\HMISApiService;
use Illuminate\Support\Facades\Session;

class PatientPortalController extends Controller
{
    protected $api;

    public function __construct(HMISApiService $api)
    {
        $this->api = $api;
    }

    public function landing()
    {
        return view('landing');
    }

    public function home()
    {
        $patientName = Session::get('patient_name');
        // optional: fetch quick data if logged in
        $appointments = Session::get('appointments', []);
        $records = Session::get('records', []);
        $latestVisit = Session::get('latest_visit', null);

        return view('customer_home', compact('appointments','records','latestVisit'))->with('patient_name', $patientName);
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function postLogin(Request $request)
    {
        $data = $request->validate([
            'identifier' => 'required|string',
            'password' => 'required|string',
        ]);

        // Call HMIS API to authenticate
        $res = $this->api->loginPatient([
            'identifier' => $data['identifier'],
            'password' => $data['password'],
        ]);

        if (!$res || empty($res['token'])) {
            return back()->with('flash_message', 'Login failed: check credentials')->withInput();
        }

        // store token & patient id in session (server-side)
        Session::put('hmis_token', $res['token']);
        Session::put('patient_id', $res['patient_id'] ?? ($res['user']['patient_id'] ?? null));
        Session::put('patient_name', $res['user']['first_name'] ?? null);

        // fetch some quick data
        $patientId = Session::get('patient_id');
        if ($patientId) {
            $patient = $this->api->getPatient($patientId);
            $encounters = $this->api->getEncounters($patientId);
            $appointments = $this->api->getAppointments($patientId);

            Session::put('appointments', $appointments);
            Session::put('records', $encounters);
            Session::put('latest_visit', $encounters[0] ?? null);
        }

        return redirect()->route('portal.dashboard');
    }

    public function dashboard()
    {
        $patientId = Session::get('patient_id');
        if (!$patientId) {
            return redirect()->route('portal.login')->with('flash_message', 'Please login first');
        }

        $patient = $this->api->getPatient($patientId);
        $encounters = $this->api->getEncounters($patientId);

        return view('patient.dashboard', [
            'patient' => $patient,
            'encounters' => $encounters,
        ]);
    }

    public function logout()
    {
        Session::forget(['hmis_token','patient_id','patient_name','appointments','records','latest_visit']);
        return redirect()->route('portal.login')->with('flash_message', 'Logged out');
    }
}
