<?php

namespace App\Http\Controllers;

use App\BasicRequirement;
use App\Http\Resources\SuperAdminResource;
use App\Log;
use App\Notifications\StudentUploadedFile;
use App\PaymentRequirement;
use App\ProgramPayment;
use App\ProgramRequirement;
use App\SponsorRequirement;
use App\Student;
use App\User;
use App\VisaRequirement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function validatePersonalDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name'        =>  'required',
            'last_name'         =>  'required',
            'birthdate'         =>  'required',
            'gender'            =>  'required',
            'mobile_number'     =>  'required',
            'address'           =>  'required',
            'school'            =>  'required',
            'year'              =>  'required',
            'course'            =>  'required',
            'program_id'        =>  'required',
            'fb_email'          =>  'required',
            'skype_id'          =>  'required'
        ])->validate();
    }

    public function storePersonalDetails(Request $request)
    {
        User::find(Auth::user()->id)->update([
            'isFilled'  =>  true
        ]);

        Student::create([
            'user_id'                   =>  Auth::user()->id,
            'first_name'                =>  $request->input('first_name'),
            'middle_name'               =>  $request->input('middle_name'),
            'last_name'                 =>  $request->input('last_name'),
            'birthdate'                 =>  $request->input('birthdate'),
            'gender'                    =>  $request->input('gender'),
            'home_number'               =>  $request->input('home_number'),
            'mobile_number'             =>  $request->input('mobile_number'),
            'address'                   =>  $request->input('address'),
            'school'                    =>  $request->input('school'),
            'year'                      =>  $request->input('year'),
            'course'                    =>  $request->input('course'),
            'program_id'                =>  $request->input('program_id'),
            'fb_email'                  =>  $request->input('fb_email'),
            'skype_id'                  =>  $request->input('skype_id'),
            'program_id_no'             =>  '',
            'sevis_id'                  =>  '',
            'host_company_id'           =>  '',
            'position'                  =>  '',
            'location'                  =>  '',
            'housing_details'           =>  '',
            'stipend'                   =>  '',
            'visa_interview_status'     =>  'Pending',
            'visa_interview_schedule'   =>  '',
            'program_start_date'        =>  '',
            'program_end_date'          =>  '',
            'visa_sponsor_id'           =>  '',
            'date_of_departure'         =>  '',
            'date_of_arrival'           =>  '',
            'application_id'            =>  '',
            'application_status'        =>  'New Applicant',
            'coordinator_id'            =>  ''
        ]);

        return response()->json(['message' => 'Personal Details Updated']);
    }

    public function showStudent()
    {
        $students = User::join('students', 'users.id', '=', 'students.user_id')
                        ->leftjoin('programs', 'students.program_id', '=', 'programs.id')
                        ->leftjoin('schools', 'students.school', '=', 'schools.id')
                        ->leftjoin('host_companies', 'students.host_company_id', '=', 'host_companies.id')
                        ->leftjoin('sponsors', 'students.visa_sponsor_id', '=', 'sponsors.id')
                        ->select(['users.name', 'users.email', 'users.verified', 'students.*', 'programs.display_name as program', 'schools.display_name as college', 'host_companies.name as company', 'sponsors.name as sponsor'])
                        ->whereRoleIs('student')
                        ->orderBy('created_at', 'desc')
                        ->paginate(10);

        return SuperAdminResource::collection($students);
    }

    public function viewStudent($id)
    {
        $student = User::join('students', 'users.id', '=', 'students.user_id')
                       ->leftjoin('programs', 'students.program_id', '=', 'programs.id')
                       ->leftjoin('sponsors', 'students.visa_sponsor_id', '=', 'sponsors.id')
                       ->leftjoin('schools', 'students.school', '=', 'schools.id')
                       ->leftjoin('host_companies', 'students.host_company_id', '=', 'host_companies.id')
                       ->leftjoin('coordinators', 'students.coordinator_id', '=', 'coordinators.user_id')
                       ->select(['users.profile_picture','students.*', 'coordinators.firstName as coor_first', 'coordinators.lastName as coor_last', 'programs.name as program', 'sponsors.name as sponsor', 'schools.name as school', 'host_companies.name as company'])
                       ->where('students.user_id', $id)
                       ->first();

        return new SuperAdminResource($student);
    }

    public function loadBasicRequirements($programId)
    {
        /*$basic = ProgramRequirement::leftjoin('basic_requirements', 'program_requirements.id', '=', 'basic_requirements.requirement_id')
                            ->select(['basic_requirements.id as bReqId', 'program_requirements.id as pReqId', 'program_requirements.name', 'program_requirements.path', 'basic_requirements.status'])
                            ->where('program_requirements.program_id', $programId)
                            ->orderBy('name', 'asc')
                            ->get(); */

        $program = \App\ProgramRequirement::leftjoin('basic_requirements', function($join) {
            $join->on('basic_requirements.requirement_id', 'program_requirements.id')
                 ->where('basic_requirements.user_id', Auth::user()->id);
                    })->select(['basic_requirements.id as bReqId', 'program_requirements.id as pReqId', 'program_requirements.name', 'program_requirements.path', 'basic_requirements.status'])
                 ->where('program_requirements.program_id', $programId)
                 ->orderBy('name', 'asc')
                 ->paginate(4);

        return SuperAdminResource::collection($program);
    }

    public function uploadBasicRequirement(Request $request, $id)
    {
        $when = now()->addSeconds(10);

        if (!BasicRequirement::where('requirement_id', $id)->first()) {
            if ($request->hasFile('file')) {
                $extension = $request->file('file')->getClientOriginalExtension();
                $path = $request->file('file')
                                ->storeAs('public/basic', $request->user()->name . '-' . date('Ymd') . uniqid() . '.' .$extension);

                BasicRequirement::create([
                    'user_id'           =>  $request->user()->id,
                    'requirement_id'    =>  $id,
                    'status'            =>  true,
                    'path'              =>  $path
                ]);

                $student = Student::where('user_id', $request->user()->id)->first();
                $requirement = ProgramRequirement::find($id);

                Log::create([
                    'user_id'   => $request->user()->id,
                    'activity'  => 'Uploaded a ' . $requirement->name
                ]);

                $data = [
                    'student'       => $student->first_name . ' ' . $student->middle_name . ' ' . $student->last_name,
                    'requirement'   => $requirement->name
                ];

                Notification::route('mail', 'system@ziptravel.com.ph')->notify((new StudentUploadedFile($data))->delay($when));

                return response()->json(['message' => 'File Uploaded!'], 200);
            } else {
                return response()->json(['message' => 'File Not Uploaded'], 422);
            }
        }

        return response()->json(['message'  =>  'File Already Uploaded']);
    }

    public function removeBasicRequirement($id)
    {
        Storage::delete(BasicRequirement::find($id)->first()->path);

        BasicRequirement::find($id)->delete();

        return response()->json(['message' => 'File Removed!']);
    }

    public function loadPaymentRequirements($programId)
    {
        $payment = ProgramPayment::leftjoin('payment_requirements', function($join) {
            $join->on('program_payments.id', '=', 'payment_requirements.requirement_id')
                 ->where('payment_requirements.user_id', Auth::user()->id);
                })
                 ->select(['payment_requirements.id as bReqId', 'program_payments.id as pReqId', 'program_payments.name', 'payment_requirements.status'])
                 ->where('program_id', $programId)
                 ->orderBy('name', 'asc')
                 ->paginate(4);

        return SuperAdminResource::collection($payment);
    }

    public function uploadPaymentRequirement(Request $request, $id)
    {
        $when = now()->addSeconds(10);

        if (!PaymentRequirement::where('requirement_id', $id)->first()) {
            if ($request->hasFile('file')) {
                $extension = $request->file('file')->getClientOriginalExtension();
                $path = $request->file('file')
                                ->storeAs('public/payment', $request->user()->name . '-' . date('Ymd') .uniqid() . '.' .$extension);

                PaymentRequirement::create([
                    'user_id'           =>  $request->user()->id,
                    'requirement_id'    =>  $id,
                    'status'            =>  true,
                    'path'              =>  $path
                ]);

                $student = Student::where('user_id', $request->user()->id)->first();
                $requirement = ProgramPayment::find($id);

                Log::create([
                    'user_id'   => $request->user()->id,
                    'activity'  =>  'Uploaded a ' . $requirement->name
                ]);

                $data = [
                    'student'       => $student->first_name . ' ' . $student->middle_name . ' ' . $student->last_name,
                    'requirement'   => $requirement->name
                ];

                Notification::route('mail', 'system@ziptravel.com.ph')->notify((new StudentUploadedFile($data))->delay($when));

                return response()->json(['message'  =>  'File Uploaded'], 200);
            } else {
                return response()->json(['message'  =>  'File Not Uploaded'], 422);
            }
        }

        return response()->json(['message'  =>  'File Already Uploaded']);
    }

    public function removePaymentRequirement($id)
    {
        Storage::delete(PaymentRequirement::find($id)->first()->path);

        PaymentRequirement::find($id)->delete();

        return response()->json(['message'  =>  'File Removed']);
    }

    public function loadVisaRequirements($sponsorId)
    {
        $visa = SponsorRequirement::leftjoin('visa_requirements', function($join) {
                            $join->on('sponsor_requirements.id', '=', 'visa_requirements.requirement_id')
                                 ->where('visa_requirements.user_id', Auth::user()->id);
                            })
                            ->select(['visa_requirements.id as bReqId', 'sponsor_requirements.id as pReqId', 'sponsor_requirements.name', 'visa_requirements.status', 'sponsor_requirements.path'])
                            ->where('sponsor_requirements.sponsor_id', $sponsorId)
                            ->orderBy('name', 'asc')
                            ->paginate(4);

        return SuperAdminResource::collection($visa);
    }

    public function uploadVisaRequirement(Request $request, $id)
    {
        $when = now()->addSeconds(10);

        if (!VisaRequirement::where('requirement_id', $id)->first()) {
            if ($request->hasFile('file')) {
                $extension = $request->file('file')->getClientOriginalExtension();
                $path = $request->file('file')
                                ->storeAs('public/visa', $request->user()->name . '-' . date('Ymd') . uniqid() . '.' . $extension);

                VisaRequirement::create([
                    'user_id'           =>  $request->user()->id,
                    'requirement_id'    =>  $id,
                    'status'            =>  true,
                    'path'              =>  $path
                ]);

                $student = Student::where('user_id', $request->user()->id)->first();
                $requirement = SponsorRequirement::find($id);

                Log::create([
                    'user_id'   =>  $request->user()->id,
                    'activity'  =>  'Uploaded a ' . $requirement->name
                ]);

                $data = [
                    'student'       => $student->first_name . ' ' . $student->middle_name . ' ' . $student->last_name,
                    'requirement'   => $requirement->name
                ];

                Notification::route('mail', 'system@ziptravel.com.ph')->notify((new StudentUploadedFile($data))->delay($when));

                return response()->json(['message'  =>  'File Uploaded'], 200);
            } else {
                return response()->json(['message'  =>  'File Not Uploaded'], 422);
            }
        }

        return response()->json(['message'  =>  'File Already Uploaded']);
    }

    public function removeVisaRequirement($id)
    {
        Storage::delete(VisaRequirement::find($id)->first()->path);
        VisaRequirement::find($id)->delete();

        return response()->json(['message'  => 'File Removed']);
    }

    public function uploadProfilePicture(Request $request)
    {
        if ($request->hasFile('file')) {

            $path = $request->file('file')
                            ->store('avatar', 'public');

            Storage::disk('public')->delete($request->user()->profile_picture);

            User::find($request->user()->id)->update([
                'profile_picture'   =>  $path
            ]);

            return response()->json($request->user()->profile_picture);
        }
    }
}
