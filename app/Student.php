<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'user_id',
        'first_name',
        'middle_name',
        'last_name',
        'birthdate',
        'gender',
        'address',
        'home_number',
        'mobile_number',
        'course',
        'school',
        'year',
        'skype_id',
        'program_id_no',
        'sevis_id',
        'host_company_id',
        'position',
        'location',
        'housing_details',
        'stipend',
        'fb_email',
        'visa_interview_status',
        'visa_interview_schedule',
        'program_start_date',
        'program_end_date',
        'visa_sponsor_id',
        'date_of_departure',
        'date_of_arrival',
        'application_id',
        'program_id',
        'application_status',
        'coordinator_id'
    ];
}
