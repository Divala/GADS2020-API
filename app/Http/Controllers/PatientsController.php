<?php

namespace App\Http\Controllers;

use App\Models\Patient\Patient;
use Illuminate\Http\Request;

class PatientsController extends ApiController
{
    public function addPatient()
    {
        $patient_name = request("patient_name");
        $location = \request("location");

        if ($patient_name == null) {
            return $this->unprocessedEntityResponse("Please provide patient name");
        }

        if (Patient::searchByPatientName($patient_name) !== null) {
            return $this->conflictResponse("Patient already exist");
        }

        return $this->generalSuccessResponse(Patient::addPatient($patient_name, $location, auth()->id())->toArray());

    }

    public function firstVisit()
    {
        return $this->generalSuccessResponse(Patient::getFirstVisitPatients()->toArray());
    }

    public function secondVisit()
    {
        return $this->generalSuccessResponse(Patient::getSecondVisitPatients()->toArray());

    }

    public function updateFirstVisit()
    {

        $patient = Patient::find(\request('id'));

        if ($patient == null) {
            return $this->unprocessedEntityResponse("Patient not available");
        }

        Patient::updateFirstVisit($patient);

        return $this->generalSuccessResponse();

    }

    public function updateSecondVisit()
    {

        $patient = Patient::find(\request('id'));

        if ($patient == null) {
            return $this->unprocessedEntityResponse("Patient not available");
        }
        Patient::updateSecondVisit($patient);

        return $this->generalSuccessResponse();

    }

    public function overdueFirstVisit()
    {
        return $this->generalSuccessResponse(Patient::getOverdueFirstVisit()->toArray());
    }

    public function overdueSecondVisit()
    {
        return $this->generalSuccessResponse(Patient::getOverdueSecondVisit()->toArray());
    }

    public function updateMissedFirstVisit()
    {
        $patient = Patient::find(\request('id'));

        if ($patient == null) {
            return $this->unprocessedEntityResponse("Patient not available");
        }
        Patient::missedFirstVisit($patient);

        return $this->generalSuccessResponse();
    }

    public function updateMissedSecondVisit()
    {
        $patient = Patient::find(\request('id'));

        if ($patient == null) {
            return $this->unprocessedEntityResponse("Patient not available");
        }
        Patient::missedSecondVisit($patient);

        return $this->generalSuccessResponse();
    }

    public function searchPatient()
    {
        return $this->generalSuccessResponse(Patient::filterPatients(request('patient_name'))->toArray());
    }

    public function allPatients()
    {
        return $this->generalSuccessResponse(Patient::all()->toArray());
    }
}
