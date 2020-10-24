<?php

namespace App\Http\Controllers;

use App\FirstVisit;
use App\Models\Patient\Patient;
use App\SecondVisit;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PeriodicStatistcsController extends Controller
{
    public function getPeriodicRegisteredPatients()
    {
        $start_date = \request("start_date");
        $end_date = \request("end_date");

        $limbe = Patient::getLimbePeriodicPatients($start_date, $end_date);
        $ndilande = Patient::getNdilandePeriodicPatients($start_date, $end_date);
        $total = $limbe + $ndilande;

        return $this->generalSuccessResponse([
            "limbe" => $limbe,
            "ndilande" => $ndilande,
            "total" => $total
        ]);
    }

    public function getPeriodicHospitalizedPatients()
    {
        $start_date = \request("start_date");
        $end_date = \request("end_date");

        $day8 = FirstVisit::whereNotNull("hospitalization")->whereBetween('created_at', [Carbon::parse($start_date)->toDateString(), Carbon::parse($end_date)->toDateString()])->count();
        $day29 = SecondVisit::whereNotNull("hospitalization")->whereBetween('created_at', [Carbon::parse($start_date)->toDateString(), Carbon::parse($end_date)->toDateString()])->count();
        $total = $day8 + $day29;
        return $this->generalSuccessResponse([
            "first_visit" => $day8,
            "second_visit" => $day29,
            "total" => $total
        ]);
    }

    public function getPeriodicTb_by_SputumPatients()
    {
        $start_date = \request("start_date");
        $end_date = \request("end_date");

        $day8 = FirstVisit::whereNotNull("tb_by_sputum")->whereBetween('created_at', [Carbon::parse($start_date)->toDateString(), Carbon::parse($end_date)->toDateString()])->count();
        $day29 = SecondVisit::whereNotNull("tb_by_x_ray")->whereBetween('created_at', [Carbon::parse($start_date)->toDateString(), Carbon::parse($end_date)->toDateString()])->count();
        $total = $day8 + $day29;
        return $this->generalSuccessResponse([
            "first_visit" => $day8,
            "second_visit" => $day29,
            "total" => $total
        ]);
    }

    public function getPeriodicTb_by_X_rayPatients()
    {
        $start_date = \request("start_date");
        $end_date = \request("end_date");

        $day8 = FirstVisit::whereNotNull("tb_by_x_ray")->whereBetween('created_at', [Carbon::parse($start_date)->toDateString(), Carbon::parse($end_date)->toDateString()])->count();
        $day29 = SecondVisit::whereNotNull("tb_by_x_ray")->whereBetween('created_at', [Carbon::parse($start_date)->toDateString(), Carbon::parse($end_date)->toDateString()])->count();
        $total = $day8 + $day29;
        return $this->generalSuccessResponse([
            "first_visit" => $day8,
            "second_visit" => $day29,
            "total" => $total
        ]);
    }

    public function getPeriodicDeathPatients()
    {
        $start_date = \request("start_date");
        $end_date = \request("end_date");

        $day8 = FirstVisit::whereNotNull("death")->whereBetween('created_at', [Carbon::parse($start_date)->toDateString(), Carbon::parse($end_date)->toDateString()])->count();
        $day29 = SecondVisit::whereNotNull("death")->whereBetween('created_at', [Carbon::parse($start_date)->toDateString(), Carbon::parse($end_date)->toDateString()])->count();
        $total = $day8 + $day29;

        return $this->generalSuccessResponse([
            "first_visit" => $day8,
            "second_visit" => $day29,
            "total" => $total
        ]);
    }

    public function getPeriodicLossFollowUpPatients()
    {
        $start_date = \request("start_date");
        $end_date = \request("end_date");

        $day8 = FirstVisit::whereNotNull("loss_to_follow_up")->whereBetween('created_at', [Carbon::parse($start_date)->toDateString(), Carbon::parse($end_date)->toDateString()])->count();
        $day29 = SecondVisit::whereNotNull("loss_to_follow_up")->whereBetween('created_at', [Carbon::parse($start_date)->toDateString(), Carbon::parse($end_date)->toDateString()])->count();
        $total = $day8 + $day29;
        return $this->generalSuccessResponse([
            "first_visit" => $day8,
            "second_visit" => $day29,
            "total" => $total
        ]);
    }

}
