<?php

namespace App\Models\Patient;

use App\FirstVisit;
use App\SecondVisit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Patient extends Model
{
    protected $guarded = [];

    //
    public static function addPatient($patient_number, $location, $user_id)
    {
        return self::create([
            "patient_id" => $patient_number,
            "location" => $location,
            "registered_by" => $user_id
        ]);
    }

    public static function searchByPatientName($patient_number)
    {
        $patient = self::where("patient_name", $patient_number)->first();

        if ($patient !== null) return $patient;

        return null;
    }

    public static function getFirstVisitPatients()
    {
        return self::whereRaw('DATE(created_at) = DATE_SUB(CURDATE(), INTERVAL 7 DAY)')
            ->where('status', PatientsStatus::NEW_PATIENT)
            ->get();
    }

    public static function getSecondVisitPatients()
    {
        return self::whereRaw('DATE(created_at) = DATE_SUB(CURDATE(), INTERVAL 29 DAY)')
            ->where('status', PatientsStatus::FIRST_VISIT)
            ->get();
    }

    public static function filterPatients($patient_name)
    {
        $patient = self::where('patient_name', 'like', '%' . $patient_name . '%')->first();

        if ($patient !== null) return $patient;

        return null;
    }

    public static function updateFirstVisit($patient)
    {
        return $patient->update(["status" => PatientsStatus::SECOND_VISIT]);
    }

    public static function updateSecondVisit($patient)
    {
        return $patient->update(["status" => PatientsStatus::COMPLETE]);

    }

    public static function missedFirstVisit($patient)
    {
        return $patient->update(["status" => PatientsStatus::MISSED_FIRST_VISIT]);

    }

    public static function missedSecondVisit($patient)
    {
        return $patient->update(["status" => PatientsStatus::MISSED_SECOND_VISIT]);

    }

    public static function getOverdueFirstVisit()
    {
        return self::where('status', PatientsStatus::MISSED_FIRST_VISIT)->get();
    }

    public static function getOverdueSecondVisit()
    {
        return self::where('status', PatientsStatus::MISSED_SECOND_VISIT)->get();
    }

    public static function getLimbePatients()
    {
        return self::where('location', 'Limbe')->whereDate('created_at', Carbon::today())->get()->count();
    }

    public static function getNdilandePatients()
    {
        return self::where('location', 'Ndilande')->whereDate('created_at', Carbon::today())->get()->count();
    }

    public static function getLimbePeriodicPatients($start_date, $end_date)
    {
        return self::where('location', 'Limbe')->whereBetween('created_at', [Carbon::parse($start_date)->toDateString(), Carbon::parse($end_date)->toDateString()])->count();
    }

    public static function getNdilandePeriodicPatients($start_date, $end_date)
    {
        return self::where('location', 'Ndilande')->whereBetween('created_at', [Carbon::parse($start_date)->toDateString(), Carbon::parse($end_date)->toDateString()])->count();

    }


    public function firstVisit()
    {
        return $this->hasOne(FirstVisit::class, 'patient_id');
    }

    public function secondVisit()
    {
        return $this->hasOne(SecondVisit::class, 'patient_id');
    }


}
