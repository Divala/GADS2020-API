<?php

namespace App\Http\Controllers;

use App\FirstVisit;
use App\Models\Patient\Patient;
use App\SecondVisit;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StatisticsController extends ApiController
{
    public function getTodayRegisteredPatients()
    {
        $limbe = Patient::getLimbePatients();
        $ndilande = Patient::getNdilandePatients();
        $total = $limbe + $ndilande;

        return $this->generalSuccessResponse([
            "limbe" => $limbe,
            "ndilande" => $ndilande,
            "total" => $total
        ]);
    }

    public function getTodayHospitalizedPatients()
    {
        $day8 = FirstVisit::whereNotNull("hospitalization")->whereDate('created_at', Carbon::today())->count();
        $day29 = SecondVisit::whereNotNull("hospitalization")->whereDate('created_at', Carbon::today())->count();
        $total = $day8 + $day29;
        return $this->generalSuccessResponse([
            "first_visit" => $day8,
            "second_visit" => $day29,
            "total" => $total
        ]);
    }

    public function getTodayTb_by_SputumPatients()
    {
        $day8 = FirstVisit::whereNotNull("tb_by_sputum")->whereDate('created_at', Carbon::today())->count();
        $day29 = SecondVisit::whereNotNull("tb_by_x_ray")->whereDate('created_at', Carbon::today())->count();
        $total = $day8 + $day29;
        return $this->generalSuccessResponse([
            "first_visit" => $day8,
            "second_visit" => $day29,
            "total" => $total
        ]);
    }

    public function getTodayTb_by_X_rayPatients()
    {
        $day8 = FirstVisit::whereNotNull("tb_by_x_ray")->whereDate('created_at', Carbon::today())->count();
        $day29 = SecondVisit::whereNotNull("tb_by_x_ray")->whereDate('created_at', Carbon::today())->count();
        $total = $day8 + $day29;
        return $this->generalSuccessResponse([
            "first_visit" => $day8,
            "second_visit" => $day29,
            "total" => $total
        ]);
    }

    public function getTodayDeathPatients()
    {
        $day8 = FirstVisit::whereNotNull("death")->whereDate('created_at', Carbon::today())->count();
        $day29 = SecondVisit::whereNotNull("death")->whereDate('created_at', Carbon::today())->count();
        $total = $day8 + $day29;
        return $this->generalSuccessResponse([
            "first_visit" => $day8,
            "second_visit" => $day29,
            "total" => $total
        ]);
    }

    public function getTodayLossFollowUpPatients()
    {
        $day8 = FirstVisit::whereNotNull("loss_to_follow_up")->whereDate('created_at', Carbon::today())->count();
        $day29 = SecondVisit::whereNotNull("loss_to_follow_up")->whereDate('created_at', Carbon::today())->count();
        $total = $day8 + $day29;
        return $this->generalSuccessResponse([
            "first_visit" => $day8,
            "second_visit" => $day29,
            "total" => $total
        ]);
    }

}
