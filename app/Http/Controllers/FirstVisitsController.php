<?php

namespace App\Http\Controllers;

use App\FirstVisit;
use App\Models\Patient\Patient;
use Illuminate\Http\Request;

class FirstVisitsController extends ApiController
{
    public function postFirstVisit()
    {
        $patientName = \request('patient_name');

        if (Patient::searchByPatientName($patientName) == null) {

            return $this->unprocessedEntityResponse("The patient is not available");
        }

        return $this->generalSuccessResponse(FirstVisit::addFirstVisit($patientName, request('tb_by_sputum'),
            request('tb_by_x-ray'), request('hospitalisation'), request('death'),
            request('loss_to_follow_up'), \request('non'), auth()->id())->toArray());

    }
}
