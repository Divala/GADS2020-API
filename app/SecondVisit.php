<?php

namespace App;

use App\Models\Patient\Patient;
use Illuminate\Database\Eloquent\Model;

class SecondVisit extends Model
{
    public static function addSecondVisit($patientName, $tb_by_sputum, $tb_by_x_ray, $hospitalisation, $death, $loss_to_follow_up, $non, $user_id)
    {
        return self::create([
            "patient_name" => $patientName,
            "tb_by_sputum" => $tb_by_sputum,
            "tb_by_x_ray" => $tb_by_x_ray,
            "hospitalisation" => $hospitalisation,
            "death" => $death,
            "loss_to_follow_up" => $loss_to_follow_up,
            "non" => $non,
            "recorded_by" => $user_id
        ]);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
