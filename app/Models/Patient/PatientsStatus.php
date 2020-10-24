<?php
/**
 * Created by PhpStorm.
 * User: mathewsdivala
 * Date: 2019-03-14
 * Time: 08:37
 */

namespace App\Models\Patient;


class PatientsStatus
{
    const NEW_PATIENT = 0, FIRST_VISIT = 1, SECOND_VISIT = 2, COMPLETE = 3, MISSED_FIRST_VISIT = 4, MISSED_SECOND_VISIT = 5;

}