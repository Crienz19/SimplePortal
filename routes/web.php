<?php
Route::view('/', 'welcome')->name('welcome');
Route::view('/faqs', 'faqs')->name('faqs');

Route::prefix('auth')->group(function() {
    Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::get('/register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    Route::get('/coor/register', 'Auth\RegisterController@showCoorRegistrationForm')->name('coor.register');
    Route::get('/sponsor/register', 'Auth\RegisterController@showSponsorRegistrationForm')->name('sponsor.register');

    Route::post('/login', 'Auth\LoginController@login')->name('post.login');
    Route::post('/register', 'Auth\RegisterController@register')->name('post.register');

    Route::post('/coor/register', 'Auth\RegisterController@coorRegister')->name('post.coor.register');

    Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

    Route::get('/forgot', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('forgot.password');
    Route::post('/forgot', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('post.forgot.password');

    Route::post('/reset/password', 'Auth\ResetPasswordController@reset')->name('post.password.reset');
    Route::get('/reset/password/{token?}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');

    Route::get('/google', 'Auth\LoginController@redirectToProvider')->name('google.login');
    Route::get('/google/callback', 'Auth\LoginController@handleProviderCallback');

});

Route::prefix('portal')->group(function() {
    Route::view('/', 'pages.welcome')->middleware('verify');
    Route::view('/sa/dash', 'pages.dashboard.dash-superadmin')->name('dash.superadmin');
    Route::view('/sa/ac/role', 'pages.access-control.access-role')->name('ac.role');
    Route::view('/sa/ac/permission', 'pages.access-control.access-permission')->name('ac.permission');

    Route::view('/sa/um/students', 'pages.user-management.user-students')->name('um.students');
    Route::view('/sa/um/coordinators', 'pages.user-management.user-coordinators')->name('um.coordinators');
    Route::view('/sa/um/sponsors', 'pages.user-management.user-sponsors')->name('um.sponsors');

    Route::view('/sa/s/programs', 'pages.setting.setting-programs-superadmin')->name('s.programs');
    Route::view('/sa/s/sponsors', 'pages.setting.setting-sponsors-superadmin')->name('s.sponsors');
    Route::view('/sa/s/host', 'pages.setting.setting-host-company-superadmin')->name('s.host');
    Route::view('/sa/s/school', 'pages.setting.setting-school-superadmin')->name('s.school');

    Route::view('/sa/events', 'pages.event-management.event')->name('sa.events');
    Route::view('/sa/cms', 'pages.cms.content-management')->name('sa.cms');

    Route::view('/a/dash', 'pages.dashboard.dash-admin')->name('dash.admin');
    Route::view('/c/dash', 'pages.dashboard.dash-coordinator')->name('dash.coordinator');
    Route::view('/s/dash', 'pages.dashboard.dash-student')->name('dash.student');
    Route::view('/sp/dash', 'pages.dashboard.dash-sponsor')->name('dash.sponsor');

    Route::view('/s/register-form', 'pages.requirement.register-form')->name('register.form');
    Route::view('/s/requirement/basic', 'pages.requirement.basic')->name('req.basic');
    Route::view('/s/requirement/payment', 'pages.requirement.payment')->name('req.payment');
    Route::view('/s/requirement/visa', 'pages.requirement.sponsor')->name('req.visa');

    Route::get('/c/program/{id}', 'CoordinatorController@coordinatorProgram')->name('coor.program');
});

Route::prefix('coor')->group(function() {
    Route::get('/show', 'CoordinatorController@showCoordinator')->name('coor.show');
    Route::get('/program/{id}', 'CoordinatorController@loadStudents')->name('coor.students');

    Route::get('/requirement/basic/{programId}/{userId}', 'CoordinatorController@loadBasicRequirements')->name('coor.basic.requirements');
    Route::get('/requirement/payment/{programId}/{userId}', 'CoordinatorController@loadPaymentRequirements')->name('coor.basic.requirements');
    Route::get('/requirement/visa/{sponsorId}/{userId}', 'CoordinatorController@loadVisaRequirements')->name('coor.visa.requirements');

    Route::post('{id}/application/{status}', 'CoordinatorController@SetApplicationStatus')->name('coor.application.status');
    Route::post('{id}/visa/{status}', 'CoordinatorController@SetVisaInterviewStatus')->name('coor.visa.status');
    Route::post('/update/{field}/{id}', 'CoordinatorController@UpdateField')->name('coor.field.update');
});

Route::prefix('stud')->group(function() {
    Route::get('/show', 'StudentController@showStudent')->name('stud.show');
    Route::get('/view/{id}', 'StudentController@viewStudent')->name('stud.view');

    Route::get('/requirement/basic/{programId}', 'StudentController@loadBasicRequirements')->name('stud.requirement.basic');
    Route::post('/requirement/basic/upload/{id}', 'StudentController@uploadBasicRequirement')->name('stud.requirement.basic.upload');
    Route::post('/requirement/basic/remove/{id}', 'StudentController@removeBasicRequirement')->name('stud.requirement.basic.remove');

    Route::get('/requirement/payment/{programId}', 'StudentController@loadPaymentRequirements')->name('stud.requirement.payment');
    Route::post('/requirement/payment/upload/{id}', 'StudentController@uploadPaymentRequirement')->name('stud.requirement.payment.upload');
    Route::post('/requirement/payment/remove/{id}', 'StudentController@removePaymentRequirement')->name('stud.requirement.payment.remove');

    Route::get('/requirement/visa/{sponsorId}', 'StudentController@loadVisaRequirements')->name('stud.requirement.visa');
    Route::post('/requirement/visa/upload/{id}', 'StudentController@uploadVisaRequirement')->name('stud.requirement.visa.upload');
    Route::post('/requirement/visa/remove/{id}', 'StudentController@removeVisaRequirement')->name('stud.requirement.visa.remove');

    Route::post('/validateDetails', 'StudentController@validatePersonalDetails')->name('stud.validate.details');
    Route::post('/details/store', 'StudentController@storePersonalDetails')->name('stud.store.details');

    Route::post('/photo/upload', 'StudentController@uploadProfilePicture')->name('stud.upload.profile');

});

Route::prefix('sa')->group(function() {
    Route::get('/coor/actions/view/{role}/{id}', 'SuperAdminController@loadCoordinationActions')->name('sa.coor.actions.view');
    Route::get('/activity/logs/{id}', 'SuperAdminController@loadActivityLogs')->name('sa.activity.logs');

    Route::post('/coor/activate/{id}', 'SuperAdminController@activateCoordinator')->name('sa.activate.coor');
    Route::post('/coor/deactivate/{id}', 'SuperAdminController@deactivateCoordinator')->name('sa.deactivate.coor');
});

Route::prefix('guard')->group(function() {
    Route::view('/verify', 'auth.not-verified')->name('verify');
    Route::view('/notactivated', 'auth.not-activated')->name('not.activated');
});

Route::prefix('role')->group(function() {
    Route::get('/view', 'RoleController@viewRoles')->name('role.view');
    Route::post('/store', 'RoleController@storeRoles')->name('role.store');
    Route::get('/edit/{id}', 'RoleController@editRoles')->name('role.edit');
    Route::post('/update/{id}', 'RoleController@updateRoles')->name('role.update');
    Route::get('/delete/{id}', 'RoleController@deleteRoles')->name('role.delete');
});

Route::prefix('permission')->group(function() {
    Route::get('/view', 'PermissionController@viewPermission')->name('permission.view');
    Route::post('/store', 'PermissionController@storePermission')->name('permission.store');
    Route::get('/edit/{id}', 'PermissionController@editPermission')->name('permission.edit');
    Route::post('/update/{id}', 'PermissionController@updatePermission')->name('permission.update');
    Route::get('/delete/{id}', 'PermissionController@deletePermission')->name('permission.delete');
});

Route::prefix('program')->group(function() {
    Route::get('/view', 'ProgramController@viewProgram')->name('program.view');
    Route::post('/store', 'ProgramController@storeProgram')->name('program.store');
    Route::get('/edit/{id}', 'ProgramController@editProgram')->name('program.edit');
    Route::post('/{id}/update', 'ProgramController@updateProgram')->name('program.update');
    Route::get('/delete/{id}', 'ProgramController@deleteProgram')->name('program.delete');

    Route::get('/{id}/requirements/view', 'ProgramRequirementController@viewRequirements')->name('program.requirements.view');
    Route::post('/requirement/store', 'ProgramRequirementController@storeRequirement')->name('program.requirements.store');
    Route::get('/requirement/{id}/edit', 'ProgramRequirementController@editRequirement')->name('program.requirements.edit');
    Route::post('/requirement/{id}/update', 'ProgramRequirementController@updateRequirement')->name('program.requirement.update');
    Route::get('/requirement/{id}/delete', 'ProgramRequirementController@deleteRequirement')->name('program.requirement.delete');

    Route::get('/{id}/payments/view', 'ProgramPaymentController@viewPayments')->name('program.payments.view');
    Route::post('/payment/store', 'ProgramPaymentController@storePayment')->name('program.payment.store');
    Route::get('/payment/{id}/edit', 'ProgramPaymentController@editPayment')->name('program.payment.edit');
    Route::post('/payment/{id}/update', 'ProgramPaymentController@updatePayment')->name('program.payment.update');
    Route::get('/payment/{id}/delete', 'ProgramPaymentController@deletePayment')->name('program.payment.delete');
});

Route::prefix('host')->group(function() {
    Route::get('/view', 'HostCompanyController@viewHost')->name('host.view');
    Route::post('/store', 'HostCompanyController@storeHost')->name('host.store');
    Route::get('/edit/{id}', 'HostCompanyController@editHost')->name('host.edit');
    Route::post('/{id}/update', 'HostCompanyController@updateHost')->name('host.update');
    Route::get('/delete/{id}', 'HostCompanyController@deleteHost')->name('host.delete');
});

Route::prefix('sponsor')->group(function() {
    Route::get('/view', 'SponsorController@view')->name('sponsor.view');
    Route::post('/store', 'SponsorController@store')->name('sponsor.store');
    Route::get('/{id}/edit', 'SponsorController@edit')->name('sponsor.edit');
    Route::post('/{id}/update', 'SponsorController@update')->name('sponsor.update');
    Route::get('/{id}/delete', 'SponsorController@delete')->name('sponsor.delete');

    Route::get('/{id}/requirements/view', 'SponsorRequirementController@view')->name('sponsor.requirement.view');
    Route::post('/requirement/store', 'SponsorRequirementController@store')->name('sponsor.requirement.store');
    Route::get('/requirement/{id}/edit', 'SponsorRequirementController@edit')->name('sponsor.requirement.edit');
    Route::post('/requirement/{id}/update', 'SponsorRequirementController@update')->name('sponsor.requirement.update');
    Route::get('/requirement/{id}/delete', 'SponsorRequirementController@delete')->name('sponsor.requirement.delete');
});

Route::prefix('school')->group(function() {
    Route::get('/view', 'SchoolController@view')->name('school.view');
    Route::post('/store', 'SchoolController@store')->name('school.store');
    Route::get('/{id}/edit', 'SchoolController@edit')->name('school.edit');
    Route::post('{id}/update', 'SchoolController@update')->name('school.update');
    Route::post('{id}/delete', 'SchoolController@delete')->name('school.delete');
});

Route::prefix('event')->group(function() {
    Route::get('/view', 'EventController@view')->name('event.view');
    Route::post('/store', 'EventController@store')->name('event.store');
    Route::get('/{id}/edit', 'EventController@edit')->name('event.edit');
    Route::post('/{id}/update', 'EventController@update')->name('event.update');
    Route::post('/{id}/delete', 'EventController@delete')->name('event.delete');
});

Route::prefix('helper')->group(function() {
    Route::get('/school/view', 'HelperController@schoolHelper')->name('helper.school');
    Route::get('/program/view', 'HelperController@programHelper')->name('helper.program');
    Route::get('/host/view', 'HelperController@hostHelper')->name('helper.host');
    Route::get('/sponsor/view', 'HelperController@sponsorHelper')->name('helper.sponsor');

    Route::get('/applicant/{program}', 'HelperController@applicantCount')->name('helper.applicant');
    Route::get('/{status}/{program}', 'HelperController@statusCount')->name('helper.status.count');
    Route::get('/visa/{filter}/{program?}', 'HelperController@visaCount')->name('helper.visa');
    Route::get('/program/{filter}', 'HelperController@programCount')->name('helper.program');
    Route::get('/accounts/{filter}/{role}', 'HelperController@registeredAccounts')->name('helper.accounts');

    Route::get('/status/{programId}/{from}/{to}/{status?}', 'HelperController@exportToExcel')->name('export.data');
});

Route::prefix('download')->group(function() {
    Route::get('/basic/form/{id}', 'DownloadController@downloadBasic')->name('download.basic');
    Route::get('/sponsor/form/{id}', 'DownloadController@downloadSponsor')->name('download.sponsor');

    Route::get('/basic/requirement/{id}', 'DownloadController@downloadBasicRequirement')->name('download.basic.requirement');
    Route::get('/payment/requirement/{id}', 'DownloadController@downloadPaymentRequirement')->name('download.payment.requirement');
    Route::get('/visa/requirement/{id}', 'DownloadController@downloadVisaRequirement')->name('download.visa.requirement');
});

Route::prefix('filter')->group(function() {
    Route::get('/student/{programId}/{name?}', 'FilterController@filterStudentBy')->name('filter.student');
    Route::get('/status/{programId}/{from}/{to}/{status?}', 'FilterController@filterStatus')->name('filter.status');

    Route::get('/sa/student/{lastname}', 'FilterController@filterSuperAdminStudent')->name('filter.sa.student');
});

Route::get('/verified/{email}/{token}', 'Auth\RegisterController@verified')->name('verified');
Route::post('/submitInquiry', 'InquiryController@submitInquiry')->name('submit.inquiry');

Route::get('/test', function() {
    $test = \Carbon\Carbon::now()->addYear(1)->format('Y');

    return $test;
});
