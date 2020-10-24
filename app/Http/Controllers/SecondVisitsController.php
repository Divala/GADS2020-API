<?php

namespace App\Http\Controllers;

use App\Models\Patient\Patient;
use App\SecondVisit;
use Illuminate\Http\Request;

class SecondVisitsController extends ApiController
{
    public function postSecondVisit()
    {
        $patientName = \request('patient_name');

        if (Patient::searchByPatientName($patientName) == null) {

            return $this->unprocessedEntityResponse("The patient is not available");
        }

        return $this->generalSuccessResponse(SecondVisit::addSecondVisit($patientName, request('tb_by_sputum'),
            request('tb_by_x-ray'), request('hospitalisation'), request('death'),
            request('loss_to_follow_up'), \request('non'), auth()->id())->toArray());

    }
}
