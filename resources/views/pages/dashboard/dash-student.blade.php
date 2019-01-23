@extends('layouts.app')

@section('title', 'Students')

@section('content')
    <div id="app" v-cloak>
        <div class="col-md-3">
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <a href="javascript:void(0)" @click="selectPhoto()">
                        <img class="profile-user-img img-responsive img-circle" :src="student.profile_picture | avatar" alt="User profile picture"/>
                    </a>
                    <h3 class="profile-username text-center">@{{ student.first_name }}&nbsp; @{{ student.last_name }}</h3>
                    <p class="text-muted text-center">@{{ student.program }}</p>
                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b>Application Status</b>
                            <a class="pull-right text-green text-sm">@{{ student.application_status }}</a>
                        </li>
                        <!--
                        <li class="list-group-item" v-if="student.application_status !== 'New Applicant'">
                            <b>Program Coordinator</b>
                            <a class="pull-right text-green text-sm">@{{ student.coor_first }} @{{ student.coor_last }}</a>
                        </li>
                        -->
                    </ul>
                    <button class="btn btn-primary btn-block btn-flat" @click="viewProfile()">View Profile</button>
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header with-border">
                    <i class="fa fa-calendar"></i>
                    <label for="" class="control-label">Schedule of Events</label>
                </div>
                <div class="box-body">
                    <ul class="products-list product-list-in-box">
                        <li class="item" v-if="events == 0">
                            No Upcoming Event
                        </li>
                        <li v-else class="item" v-for="event in events">
                            <div class="product-img">
                                <img src="http://via.placeholder.com/50x50" alt="">
                            </div>
                            <div class="product-info">
                                <a href="javascript:void(0)" class="product-title" @click="viewEvent(event.id)">
                                    @{{ event.name }}
                                    <span class="label label-primary pull-right">@{{ event.date }}</span>
                                </a>
                                <span class="product-description">
                                    @{{ event.description }}
                                </span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#profile" data-toggle="tab" aria-expanded="true">
                            <span class="fa fa-user"></span>
                            <label for="" class="control-label">Profile</label>
                        </a>
                    </li>
                    <li class="">
                        <a href="#basic" data-toggle="tab" aria-expanded="false">
                            <span class="fa fa-file"></span>
                            <label for="" class="control-label">Basic Requirements</label>
                        </a>
                    </li>
                    <li class="">
                        <a href="#payment" data-toggle="tab" aria-expanded="false">
                            <span class="fa fa-file"></span>
                            <label for="" class="control-label">Payment Requirements</label>
                        </a>
                    </li>
                    <li class="">
                        <a href="#visa" data-toggle="tab" aria-expanded="false">
                            <span class="fa fa-plane"></span>
                            <label for="" class="control-label">Visa Requirements</label>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="profile">
                        <label class="control-label">Application Details</label>
                        <table class="table table-striped table-bordered table-condensed">
                            <tbody>
                            <tr>
                                <td style="width: 35%;">Application ID</td>
                                <td class="text-bold text-green">
                                    @{{ student.application_id }}
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 35%;">Visa Interview Status</td>
                                <td class="text-bold">
                                    @{{ student.visa_interview_status }}
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <label class="control-label">Personal Details</label>
                        <table class="table table-striped table-bordered table-condensed">
                            <tbody>
                                <tr>
                                    <td style="width: 35%;">First name</td>
                                    <td v-if="!setting.firstNameIsEdit">
                                        <label class="text-bold"> @{{ student.first_name }}</label>
                                        <a @click="hideField('firstName');" href="#" class="pull-right">
                                            <span class="fa fa-edit"></span>
                                        </a>
                                    </td>
                                    <td v-else>
                                        <div class="input-group">
                                            <input v-model="field" type="text" class="form-control input-sm">
                                            <span class="input-group-btn">
                                                    <button @click="updateField('first_name', field); setting.firstNameIsEdit = false;" class="btn btn-primary btn-flat btn-sm">Update</button>
                                                </span>
                                            <span class="input-group-btn">
                                                    <button @click="setting.firstNameIsEdit = false;" class="btn btn-danger btn-flat btn-sm">Cancel</button>
                                                </span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Middle name</td>
                                    <td v-if="!setting.middleNameIsEdit">
                                        <label class="text-bold">@{{ student.middle_name }}</label>
                                        <a @click="hideField('middleName');" href="#" class="pull-right">
                                            <span class="fa fa-edit"></span>
                                        </a>
                                    </td>
                                    <td v-else>
                                        <div class="input-group">
                                            <input v-model="field" type="text" class="form-control input-sm">
                                            <span class="input-group-btn">
                                                    <button @click="updateField('middle_name', field); setting.middleNameIsEdit = false;" class="btn btn-primary btn-flat btn-sm">Update</button>
                                                </span>
                                            <span class="input-group-btn">
                                                    <button @click="setting.middleNameIsEdit = false;" class="btn btn-danger btn-flat btn-sm">Cancel</button>
                                                </span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Last name</td>
                                    <td v-if="!setting.lastNameIsEdit">
                                        <label class="text-bold">@{{ student.last_name }}</label>
                                        <a @click="hideField('lastName');" href="#" class="pull-right">
                                            <span class="fa fa-edit"></span>
                                        </a>
                                    </td>
                                    <td v-else>
                                        <div class="input-group">
                                            <input v-model="field" type="text" class="form-control input-sm">
                                            <span class="input-group-btn">
                                                    <button @click="updateField('last_name', field); setting.lastNameIsEdit = false;" class="btn btn-primary btn-flat btn-sm">Update</button>
                                                </span>
                                            <span class="input-group-btn">
                                                    <button @click="setting.lastNameIsEdit = false;" class="btn btn-danger btn-flat btn-sm">Cancel</button>
                                                </span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Birthdate</td>
                                    <td v-if="!setting.birthDateIsEdit">
                                        <label class="text-bold">@{{ student.birthdate }}</label>
                                        <a @click="hideField('birthdate');" href="#" class="pull-right">
                                            <span class="fa fa-edit"></span>
                                        </a>
                                    </td>
                                    <td v-else>
                                        <div class="input-group">
                                            <input v-model="field" type="date" class="form-control input-sm">
                                            <span class="input-group-btn">
                                                    <button @click="updateField('birthdate', field); setting.birthDateIsEdit = false;" class="btn btn-primary btn-flat btn-sm">Update</button>
                                                </span>
                                            <span class="input-group-btn">
                                                    <button @click="setting.birthDateIsEdit = false;" class="btn btn-danger btn-flat btn-sm">Cancel</button>
                                                </span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Gender</td>
                                    <td v-if="!setting.genderIsEdit">
                                        <label class="text-bold">@{{ student.gender }}</label>
                                        <a @click="hideField('gender');" href="#" class="pull-right">
                                            <span class="fa fa-edit"></span>
                                        </a>
                                    </td>
                                    <td v-else>
                                        <div class="input-group">
                                            <select v-model="field" class="form-control input-sm">
                                                <option value="">Select gender</option>
                                                <option value="MALE">Male</option>
                                                <option value="FEMALE">Female</option>
                                            </select>
                                            <span class="input-group-btn">
                                                    <button @click="updateField('gender', field); setting.genderIsEdit = false;" class="btn btn-primary btn-flat btn-sm">Update</button>
                                                </span>
                                            <span class="input-group-btn">
                                                    <button @click="setting.genderIsEdit = false;" class="btn btn-danger btn-flat btn-sm">Cancel</button>
                                                </span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 20%;">Address</td>
                                    <td v-if="!setting.addressIsEdit">
                                        <label class="text-bold">@{{ student.address }}</label>
                                        <a @click="hideField('address');" href="#" class="pull-right">
                                            <span class="fa fa-edit"></span>
                                        </a>
                                    </td>
                                    <td v-else>
                                        <div class="input-group">
                                            <input v-model="field" type="text" class="form-control input-sm">
                                            <span class="input-group-btn">
                                                    <button @click="updateField('address', field); setting.addressIsEdit = false;" class="btn btn-primary btn-flat btn-sm">Update</button>
                                                </span>
                                            <span class="input-group-btn">
                                                    <button @click="setting.addressIsEdit = false;" class="btn btn-danger btn-flat btn-sm">Cancel</button>
                                                </span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Home number</td>
                                    <td v-if="!setting.homeNumberIsEdit">
                                        <label class="text-bold">@{{ student.home_number }}</label>
                                        <a @click="hideField('homeNumber');" href="#" class="pull-right">
                                            <span class="fa fa-edit"></span>
                                        </a>
                                    </td>
                                    <td v-else>
                                        <div class="input-group">
                                            <input v-model="field" type="number" class="form-control input-sm">
                                            <span class="input-group-btn">
                                                    <button @click="updateField('home_number', field); setting.homeNumberIsEdit = false;" class="btn btn-primary btn-flat btn-sm">Update</button>
                                                </span>
                                            <span class="input-group-btn">
                                                    <button @click="setting.homeNumberIsEdit = false;" class="btn btn-danger btn-flat btn-sm">Cancel</button>
                                                </span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Mobile number</td>
                                    <td v-if="!setting.mobileNumberIsEdit">
                                        <label class=" text-bold">@{{ student.mobile_number }}</label>
                                        <a @click="hideField('mobileNumber');" href="#" class="pull-right">
                                            <span class="fa fa-edit"></span>
                                        </a>
                                    </td>
                                    <td v-else>
                                        <div class="input-group">
                                            <input v-model="field" type="number" class="form-control input-sm">
                                            <span class="input-group-btn">
                                                    <button @click="updateField('mobile_number', field); setting.mobileNumberIsEdit = false;" class="btn btn-primary btn-flat btn-sm">Update</button>
                                                </span>
                                            <span class="input-group-btn">
                                                    <button @click="setting.mobileNumberIsEdit = false;" class="btn btn-danger btn-flat btn-sm">Cancel</button>
                                                </span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Skype ID</td>
                                    <td v-if="!setting.skypeIdIsEdit">
                                        <label class="text-bold">@{{ student.skype_id }}</label>
                                        <a @click="hideField('skypeId');" href="#" class="pull-right">
                                            <span class="fa fa-edit"></span>
                                        </a>
                                    </td>
                                    <td v-else>
                                        <div class="input-group">
                                            <input v-model="field" type="text" class="form-control input-sm">
                                            <span class="input-group-btn">
                                                <button @click="updateField('skype_id', field); setting.skypeIdIsEdit = false;" class="btn btn-primary btn-flat btn-sm">Update</button>
                                            </span>
                                            <span class="input-group-btn">
                                                <button @click="setting.skypeIdIsEdit = false;" class="btn btn-danger btn-flat btn-sm">Cancel</button>
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Facebook Email</td>
                                    <td class="text-bold">
                                        @{{ student.fb_email }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <label class="control-label">School Details</label>
                        <table class="table table-striped table-bordered table-condensed">
                            <tbody>
                                <tr>
                                    <td style="width: 35%;">College</td>
                                    <td class="text-bold">
                                        @{{ student.school }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Course</td>
                                    <td class="text-bold">
                                        @{{ student.course }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Year Level</td>
                                    <td class="text-bold">
                                        @{{ student.year }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <label class="control-label">Host Company Details</label>
                        <table class="table table-striped table-bordered table-condensed">
                            <tbody>
                                <tr>
                                    <td style="width: 35%;">Host Company</td>
                                    <td class="text-bold">
                                        @{{ student.company }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Position</td>
                                    <td class="text-bold">
                                        @{{ student.position }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Start Date</td>
                                    <td class="text-bold">
                                        @{{ student.program_start_date }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>End Date</td>
                                    <td class="text-bold">
                                        @{{ student.program_end_date }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Stipend</td>
                                    <td class="text-bold">
                                        @{{ student.stipend }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Visa Sponsor</td>
                                    <td class="text-bold">
                                        @{{ student.sponsor }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <label for="" class="control-label">Visa Interview Details</label>
                        <table class="table table-striped table-bordered table-condensed">
                            <tbody>
                                <tr>
                                    <td style="width: 35%;">Program ID Number</td>
                                    <td class="text-bold">
                                        @{{ student.program_id_no }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>SEVIS ID</td>
                                    <td class="text-bold">
                                        @{{ student.sevis_id }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Interview Schedule</td>
                                    <td class="text-bold">
                                        @{{ student.visa_interview_schedule }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <label for="" class="control-label">Flight Details</label>
                        <table class="table table-striped table-bordered table-condensed">
                            <tbody>
                                <tr>
                                    <td style="width: 35%;">Departure Date</td>
                                    <td class="text-bold">
                                        @{{ student.date_of_departure }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Arrival Date</td>
                                    <td class="text-bold">
                                        @{{ student.date_of_arrival }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane" id="basic">
                        <table class="table table-striped table-bordered table-condensed">
                            <thead>
                            <th style="width: 75%;">Requirements</th>
                            <th class="text-center">Status</th>
                            </thead>
                            <tbody>
                            <tr v-for="requirement in basicRequirements.data">
                                <td>@{{ requirement.name }}</td>
                                <td class="text-center">
                                    <span v-if="requirement.status" style="color: green;" class="fa fa-check"></span>
                                    <span v-else style="color: red;" class="fa fa-remove"></span>
                                </td>
                            </tr>
                            </tbody>
                        </table>

                    </div>
                    <div class="tab-pane" id="payment">
                        <table class="table table-striped table-bordered table-condensed">
                            <thead>
                            <th style="width: 75%;">Requirements</th>
                            <th class="text-center">Status</th>
                            </thead>
                            <tbody>
                            <tr v-for="requirement in paymentRequirements.data">
                                <td>@{{ requirement.name }}</td>
                                <td class="text-center">
                                    <span v-if="requirement.status" style="color: green;" class="fa fa-check"></span>
                                    <span v-else style="color: red;" class="fa fa-remove"></span>
                                </td>
                            </tr>
                            </tbody>
                        </table>

                    </div>
                    <div class="tab-pane" id="visa">
                        <table class="table table-striped table-bordered table-condensed">
                            <thead>
                            <th style="width: 75%;">Requirements</th>
                            <th class="text-center">Status</th>
                            </thead>
                            <tbody>
                            <tr v-for="requirement in visaRequirements.data">
                                <td>@{{ requirement.name }}</td>
                                <td class="text-center">
                                    <span v-if="requirement.status" style="color: green;" class="fa fa-check"></span>
                                    <span v-else style="color: red;" class="fa fa-remove"></span>
                                </td>
                            </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="profile-modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="overlay-wrapper" :style="{ display: loading ? 'block' : 'none' }">
                        <div class="overlay">
                            <i class="fa fa-circle-o-notch fa-spin fa-2x"></i>
                        </div>
                    </div>
                    <div class="modal-header">
                        <label for="" class="control-label"><i class="fa fa-user"></i>  User Profile</label>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"></h4>
                    </div>
                    <div class="modal-body">
                        <label class="control-label">Personal Details</label>
                        <table class="table table-striped table-bordered table-condensed">
                            <tbody>
                                <tr>
                                    <td class="text-sm" style="width: 20%;">First name</td>
                                    <td v-if="!setting.firstNameIsEdit" class="text-center">
                                        <label class="text-sm text-bold"> @{{ student.first_name }}</label>
                                        <a @click="hideField('firstName');" href="#" class="pull-right">
                                            <span class="fa fa-edit"></span>
                                        </a>
                                    </td>
                                    <td v-else>
                                        <div class="input-group">
                                            <input v-model="field" type="text" class="form-control input-sm">
                                            <span class="input-group-btn">
                                                    <button @click="updateField('first_name', field); setting.firstNameIsEdit = false;" class="btn btn-primary btn-flat btn-sm">Update</button>
                                                </span>
                                            <span class="input-group-btn">
                                                    <button @click="setting.firstNameIsEdit = false;" class="btn btn-danger btn-flat btn-sm">Cancel</button>
                                                </span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-sm">Middle name</td>
                                    <td v-if="!setting.middleNameIsEdit" class="text-center">
                                        <label class="text-sm text-bold">@{{ student.middle_name }}</label>
                                        <a @click="hideField('middleName');" href="#" class="pull-right">
                                            <span class="fa fa-edit"></span>
                                        </a>
                                    </td>
                                    <td v-else>
                                        <div class="input-group">
                                            <input v-model="field" type="text" class="form-control input-sm">
                                            <span class="input-group-btn">
                                                    <button @click="updateField('middle_name', field); setting.middleNameIsEdit = false;" class="btn btn-primary btn-flat btn-sm">Update</button>
                                                </span>
                                            <span class="input-group-btn">
                                                    <button @click="setting.middleNameIsEdit = false;" class="btn btn-danger btn-flat btn-sm">Cancel</button>
                                                </span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-sm">Last name</td>
                                    <td v-if="!setting.lastNameIsEdit" class="text-center">
                                        <label class="text-sm text-bold">@{{ student.last_name }}</label>
                                        <a @click="hideField('lastName');" href="#" class="pull-right">
                                            <span class="fa fa-edit"></span>
                                        </a>
                                    </td>
                                    <td v-else>
                                        <div class="input-group">
                                            <input v-model="field" type="text" class="form-control input-sm">
                                            <span class="input-group-btn">
                                                    <button @click="updateField('last_name', field); setting.lastNameIsEdit = false;" class="btn btn-primary btn-flat btn-sm">Update</button>
                                                </span>
                                            <span class="input-group-btn">
                                                    <button @click="setting.lastNameIsEdit = false;" class="btn btn-danger btn-flat btn-sm">Cancel</button>
                                                </span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-sm">Birthdate</td>
                                    <td v-if="!setting.birthDateIsEdit" class="text-center">
                                        <label class="text-sm text-bold">@{{ student.birthdate }}</label>
                                        <a @click="hideField('birthdate');" href="#" class="pull-right">
                                            <span class="fa fa-edit"></span>
                                        </a>
                                    </td>
                                    <td v-else>
                                        <div class="input-group">
                                            <input v-model="field" type="date" class="form-control input-sm">
                                            <span class="input-group-btn">
                                                    <button @click="updateField('birthdate', field); setting.birthDateIsEdit = false;" class="btn btn-primary btn-flat btn-sm">Update</button>
                                                </span>
                                            <span class="input-group-btn">
                                                    <button @click="setting.birthDateIsEdit = false;" class="btn btn-danger btn-flat btn-sm">Cancel</button>
                                                </span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-sm">Gender</td>
                                    <td v-if="!setting.genderIsEdit" class="text-center">
                                        <label class="text-sm text-bold">@{{ student.gender }}</label>
                                        <a @click="hideField('gender');" href="#" class="pull-right">
                                            <span class="fa fa-edit"></span>
                                        </a>
                                    </td>
                                    <td v-else>
                                        <div class="input-group">
                                            <select v-model="field" class="form-control input-sm">
                                                <option value="">Select gender</option>
                                                <option value="MALE">Male</option>
                                                <option value="FEMALE">Female</option>
                                            </select>
                                            <span class="input-group-btn">
                                                    <button @click="updateField('gender', field); setting.genderIsEdit = false;" class="btn btn-primary btn-flat btn-sm">Update</button>
                                                </span>
                                            <span class="input-group-btn">
                                                    <button @click="setting.genderIsEdit = false;" class="btn btn-danger btn-flat btn-sm">Cancel</button>
                                                </span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <label class="control-label">Contact Details</label>
                        <table class="table table-striped table-bordered table-condensed">
                            <tbody>
                                <tr>
                                    <td class="text-sm" style="width: 20%;">Address</td>
                                    <td v-if="!setting.addressIsEdit" class="text-center">
                                        <label class="text-sm text-bold">@{{ student.address }}</label>
                                        <a @click="hideField('address');" href="#" class="pull-right">
                                            <span class="fa fa-edit"></span>
                                        </a>
                                    </td>
                                    <td v-else>
                                        <div class="input-group">
                                            <input v-model="field" type="text" class="form-control input-sm">
                                            <span class="input-group-btn">
                                                    <button @click="updateField('address', field); setting.addressIsEdit = false;" class="btn btn-primary btn-flat btn-sm">Update</button>
                                                </span>
                                            <span class="input-group-btn">
                                                    <button @click="setting.addressIsEdit = false;" class="btn btn-danger btn-flat btn-sm">Cancel</button>
                                                </span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-sm">Home number</td>
                                    <td v-if="!setting.homeNumberIsEdit" class="text-center">
                                        <label class="text-sm text-bold">@{{ student.home_number }}</label>
                                        <a @click="hideField('homeNumber');" href="#" class="pull-right">
                                            <span class="fa fa-edit"></span>
                                        </a>
                                    </td>
                                    <td v-else>
                                        <div class="input-group">
                                            <input v-model="field" type="number" class="form-control input-sm">
                                            <span class="input-group-btn">
                                                    <button @click="updateField('home_number', field); setting.homeNumberIsEdit = false;" class="btn btn-primary btn-flat btn-sm">Update</button>
                                                </span>
                                            <span class="input-group-btn">
                                                    <button @click="setting.homeNumberIsEdit = false;" class="btn btn-danger btn-flat btn-sm">Cancel</button>
                                                </span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-sm">Mobile number</td>
                                    <td v-if="!setting.mobileNumberIsEdit" class="text-center">
                                        <label class="text-sm text-bold">@{{ student.mobile_number }}</label>
                                        <a @click="hideField('mobileNumber');" href="#" class="pull-right">
                                            <span class="fa fa-edit"></span>
                                        </a>
                                    </td>
                                    <td v-else>
                                        <div class="input-group">
                                            <input v-model="field" type="number" class="form-control input-sm">
                                            <span class="input-group-btn">
                                                    <button @click="updateField('mobile_number', field); setting.mobileNumberIsEdit = false;" class="btn btn-primary btn-flat btn-sm">Update</button>
                                                </span>
                                            <span class="input-group-btn">
                                                    <button @click="setting.mobileNumberIsEdit = false;" class="btn btn-danger btn-flat btn-sm">Cancel</button>
                                                </span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <label class="control-label">School Details</label>
                        <table class="table table-striped table-bordered table-condensed">
                            <tbody>
                                <tr>
                                    <td class="text-sm" style="width: 20%;">School</td>
                                    <td v-if="!setting.schoolIsEdit" class="text-center">
                                        <label class="text-sm text-bold">@{{ student.school }}</label>
                                        <a @click="hideField('school');" href="#" class="pull-right">
                                            <span class="fa fa-edit"></span>
                                        </a>
                                    </td>
                                    <td v-else>
                                        <div class="input-group">
                                            <select v-model="field" class="form-control input-sm">
                                                <option value="">Select school</option>
                                            </select>
                                            <span class="input-group-btn">
                                                <button @click="updateField('school', field); setting.schoolIsEdit = false;" class="btn btn-primary btn-flat btn-sm">Update</button>
                                            </span>
                                            <span class="input-group-btn">
                                                <button @click="setting.schoolIsEdit = false;" class="btn btn-danger btn-flat btn-sm">Cancel</button>
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-sm">Course</td>
                                    <td v-if="!setting.courseIsEdit" class="text-center">
                                        <label class="text-sm text-bold">@{{ student.course }}</label>
                                        <a @click="hideField('course');" href="#" class="pull-right">
                                            <span class="fa fa-edit"></span>
                                        </a>
                                    </td>
                                    <td v-else>
                                        <div class="input-group">
                                            <input v-model="field" type="text" class="form-control input-sm">
                                            <span class="input-group-btn">
                                                <button @click="updateField('course', field); setting.courseIsEdit = false;" class="btn btn-primary btn-flat btn-sm">Update</button>
                                            </span>
                                            <span class="input-group-btn">
                                                <button @click="setting.courseIsEdit = false;" class="btn btn-danger btn-flat btn-sm">Cancel</button>
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-sm">Skype ID</td>
                                    <td v-if="!setting.skypeIdIsEdit" class="text-center">
                                        <label class="text-sm text-bold">@{{ student.skype_id }}</label>
                                        <a @click="hideField('skypeId');" href="#" class="pull-right">
                                            <span class="fa fa-edit"></span>
                                        </a>
                                    </td>
                                    <td v-else>
                                        <div class="input-group">
                                            <input v-model="field" type="text" class="form-control input-sm">
                                            <span class="input-group-btn">
                                                <button @click="updateField('skype_id', field); setting.skypeIdIsEdit = false;" class="btn btn-primary btn-flat btn-sm">Update</button>
                                            </span>
                                            <span class="input-group-btn">
                                                <button @click="setting.skypeIdIsEdit = false;" class="btn btn-danger btn-flat btn-sm">Cancel</button>
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <div class="modal fade" id="view-event" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
            <form>
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title"></h4>
                        </div>
                        <div class="modal-body">
                            <div class="box box-solid">
                                <div class="box-body">
                                    <div>
                                        <label>@{{ event.name }}</label>
                                        <label class="pull-right">@{{ event.date }}</label>
                                    </div>
                                    <div class="m-t-10">
                                        <p class="text-justify">
                                            @{{ event.description }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </form>
        </div><!-- /.modal -->

        <div class="modal fade" id="photo-upload" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title"></h4>
                        </div>
                        <div class="modal-body">
                            <input type="file" ref="file" @change="handleFileUpload()">
                        </div>
                        <div class="modal-footer clearfix">
                            <button @click="uploadPhoto()" class="btn btn-primary btn-flat btn-block">Upload File</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </div>
@endsection

@section('script')
    <script>
        const app = new Vue({
            el: '#app',
            data: {
                student: [],
                basicRequirements: {
                    links: {
                        prev: '',
                        next: ''
                    }
                },
                paymentRequirements:{
                    links: {
                        prev: '',
                        next: ''
                    }
                },
                visaRequirements: {
                    links: {
                        prev: '',
                        next: ''
                    }
                },
                events: [],
                event: [],
                user_id: '{{ Auth::user()->id }}',
                setting: {
                    firstNameIsEdit: false,
                    middleNameIsEdit: false,
                    lastNameIsEdit: false,
                    birthDateIsEdit: false,
                    genderIsEdit: false,
                    addressIsEdit: false,
                    homeNumberIsEdit: false,
                    mobileNumberIsEdit: false,
                    schoolIsEdit: false,
                    courseIsEdit: false,
                    skypeIdIsEdit: false
                },
                field: '',
                loading: false,
                file: ''
            },
            mounted: function() {
                this.loadStudentDetails();
                this.loadEvents();
                setTimeout(() => {
                    this.loadBasicRequirements(this.student.program_id);
                    this.loadPaymentRequirements(this.student.program_id);
                    this.loadVisaRequirements(this.student.visa_sponsor_id);
                }, 1000);
            },
            filters: {
                avatar: function (value) {
                    if (!value) {
                        return 'https://placeimg.com/150/150/any'
                    } else {
                        return `/storage/${value}`
                    }
                }
            },
            methods: {
                handleFileUpload () {
                    this.file = this.$refs.file.files[0];
                },
                loadStudentDetails() {
                    axios.get(`/stud/view/${this.user_id}`)
                        .then((response) => {
                            this.student = response.data.data;
                            this.program_id = response.data.data.program_id;
                        }).catch((error) => {
                            console.log(error);
                    })
                },
                loadBasicRequirements(programId) {
                    axios.get(`/stud/requirement/basic/${programId}`)
                        .then((response) => {
                            this.basicRequirements = response.data;
                        }).catch((error) => {
                        console.log(error);
                    });
                },
                loadPaymentRequirements(programId) {
                    axios.get(`/stud/requirement/payment/${programId}`)
                        .then((response) => {
                            this.paymentRequirements = response.data;
                        }).catch((error) => {
                            console.log(error);
                    });
                },
                loadVisaRequirements(sponsorId) {
                    axios.get(`/stud/requirement/visa/${sponsorId}`)
                        .then((response) => {
                            this.visaRequirements = response.data;
                        }).catch((error) => {
                            console.log(error);
                    });
                },
                loadEvents() {
                    axios.get('/event/view')
                        .then((response) => {
                            this.events = response.data.data;
                        }).catch((error) => {
                            console.log(error);
                    })
                },
                pagination(link, type) {
                    axios.get(link)
                        .then((response) => {
                            switch (type) {
                                case 'basic':
                                    this.basicRequirements = response.data;
                                    break;
                                case 'payment':
                                    this.paymentRequirements = response.data;
                                    break;
                                case 'visa':
                                    this.visaRequirements = response.data;
                                    break;
                            }
                        })
                },
                viewProfile() {
                    $('#profile-modal').modal('show');
                },
                viewEvent(id) {
                    this.event = _.find(this.events, (obj) => { return obj.id === id });
                    $('#view-event').modal('show');
                },
                selectPhoto () {
                    $('#photo-upload').modal('show');
                },
                uploadPhoto () {
                    let formData = new FormData();
                    formData.append('file', this.file);

                    axios.post(`/stud/photo/upload`, formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                        .then((response) => {
                            this.loadStudentDetails();
                            $('#photo-upload').modal('hide');
                            swal({
                                title: 'Success',
                                type: 'success',
                                confirmButtonText: 'Continue'
                            })
                        });
                },
                updateField(field, input) {
                    this.loading = true;
                    let formData = new FormData();
                    formData.append('field', input);
                    axios.post(`/coor/update/${field}/${this.student.user_id}`, formData)
                        .then((response) => {
                            this.loading = false;
                            this.field = '';
                            this.loadStudentDetails();
                            swal({
                                title: `${field} Updated!`,
                                type: 'success',
                                confirmButtonText: 'Continue'
                            })
                        }).catch((error) => {
                            this.loading = false;
                            swal({
                                title: 'Something went wrong',
                                type: 'error',
                                confirmButtonText: 'Go Back!'
                            })
                    })
                },
                hideField(field) {
                    switch (field) {
                        case 'firstName':
                            this.setting.firstNameIsEdit = true;
                            this.setting.middleNameIsEdit = false;
                            this.setting.lastNameIsEdit = false;
                            this.setting.birthDateIsEdit = false;
                            this.setting.genderIsEdit = false;
                            this.setting.addressIsEdit = false;
                            this.setting.homeNumberIsEdit = false;
                            this.setting.mobileNumberIsEdit = false;
                            this.setting.schoolIsEdit = false;
                            this.setting.courseIsEdit = false;
                            this.setting.skypeIdIsEdit = false;
                            break;
                        case 'middleName':
                            this.setting.firstNameIsEdit = false;
                            this.setting.middleNameIsEdit = true;
                            this.setting.lastNameIsEdit = false;
                            this.setting.birthDateIsEdit = false;
                            this.setting.genderIsEdit = false;
                            this.setting.addressIsEdit = false;
                            this.setting.homeNumberIsEdit = false;
                            this.setting.mobileNumberIsEdit = false;
                            this.setting.schoolIsEdit = false;
                            this.setting.courseIsEdit = false;
                            this.setting.skypeIdIsEdit = false;
                            break;
                        case 'lastName':
                            this.setting.firstNameIsEdit = false;
                            this.setting.middleNameIsEdit = false;
                            this.setting.lastNameIsEdit = true;
                            this.setting.birthDateIsEdit = false;
                            this.setting.genderIsEdit = false;
                            this.setting.addressIsEdit = false;
                            this.setting.homeNumberIsEdit = false;
                            this.setting.mobileNumberIsEdit = false;
                            this.setting.schoolIsEdit = false;
                            this.setting.courseIsEdit = false;
                            this.setting.skypeIdIsEdit = false;
                            break;
                        case 'birthdate':
                            this.setting.firstNameIsEdit = false;
                            this.setting.middleNameIsEdit = false;
                            this.setting.lastNameIsEdit = false;
                            this.setting.birthDateIsEdit = true;
                            this.setting.genderIsEdit = false;
                            this.setting.addressIsEdit = false;
                            this.setting.homeNumberIsEdit = false;
                            this.setting.mobileNumberIsEdit = false;
                            this.setting.schoolIsEdit = false;
                            this.setting.courseIsEdit = false;
                            this.setting.skypeIdIsEdit = false;
                            break;
                        case 'gender':
                            this.setting.firstNameIsEdit = false;
                            this.setting.middleNameIsEdit = false;
                            this.setting.lastNameIsEdit = false;
                            this.setting.birthDateIsEdit = false;
                            this.setting.genderIsEdit = true;
                            this.setting.addressIsEdit = false;
                            this.setting.homeNumberIsEdit = false;
                            this.setting.mobileNumberIsEdit = false;
                            this.setting.schoolIsEdit = false;
                            this.setting.courseIsEdit = false;
                            this.setting.skypeIdIsEdit = false;
                            break;
                        case 'address':
                            this.setting.firstNameIsEdit = false;
                            this.setting.middleNameIsEdit = false;
                            this.setting.lastNameIsEdit = false;
                            this.setting.birthDateIsEdit = false;
                            this.setting.genderIsEdit = false;
                            this.setting.addressIsEdit = true;
                            this.setting.homeNumberIsEdit = false;
                            this.setting.mobileNumberIsEdit = false;
                            this.setting.schoolIsEdit = false;
                            this.setting.courseIsEdit = false;
                            this.setting.skypeIdIsEdit = false;
                            break;
                        case 'homeNumber':
                            this.setting.firstNameIsEdit = false;
                            this.setting.middleNameIsEdit = false;
                            this.setting.lastNameIsEdit = false;
                            this.setting.birthDateIsEdit = false;
                            this.setting.genderIsEdit = false;
                            this.setting.addressIsEdit = false;
                            this.setting.homeNumberIsEdit = true;
                            this.setting.mobileNumberIsEdit = false;
                            this.setting.schoolIsEdit = false;
                            this.setting.courseIsEdit = false;
                            this.setting.skypeIdIsEdit = false;
                            break;
                        case 'mobileNumber':
                            this.setting.firstNameIsEdit = false;
                            this.setting.middleNameIsEdit = false;
                            this.setting.lastNameIsEdit = false;
                            this.setting.birthDateIsEdit = false;
                            this.setting.genderIsEdit = false;
                            this.setting.addressIsEdit = false;
                            this.setting.homeNumberIsEdit = false;
                            this.setting.mobileNumberIsEdit = true;
                            this.setting.schoolIsEdit = false;
                            this.setting.courseIsEdit = false;
                            this.setting.skypeIdIsEdit = false;
                            break;
                        case 'school':
                            this.setting.firstNameIsEdit = false;
                            this.setting.middleNameIsEdit = false;
                            this.setting.lastNameIsEdit = false;
                            this.setting.birthDateIsEdit = false;
                            this.setting.genderIsEdit = false;
                            this.setting.addressIsEdit = false;
                            this.setting.homeNumberIsEdit = false;
                            this.setting.mobileNumberIsEdit = false;
                            this.setting.schoolIsEdit = true;
                            this.setting.courseIsEdit = false;
                            this.setting.skypeIdIsEdit = false;
                            break;
                        case 'course':
                            this.setting.firstNameIsEdit = false;
                            this.setting.middleNameIsEdit = false;
                            this.setting.lastNameIsEdit = false;
                            this.setting.birthDateIsEdit = false;
                            this.setting.genderIsEdit = false;
                            this.setting.addressIsEdit = false;
                            this.setting.homeNumberIsEdit = false;
                            this.setting.mobileNumberIsEdit = false;
                            this.setting.schoolIsEdit = false;
                            this.setting.courseIsEdit = true;
                            this.setting.skypeIdIsEdit = false;
                            break;
                        case 'skypeId':
                            this.setting.firstNameIsEdit = false;
                            this.setting.middleNameIsEdit = false;
                            this.setting.lastNameIsEdit = false;
                            this.setting.birthDateIsEdit = false;
                            this.setting.genderIsEdit = false;
                            this.setting.addressIsEdit = false;
                            this.setting.homeNumberIsEdit = false;
                            this.setting.mobileNumberIsEdit = false;
                            this.setting.schoolIsEdit = false;
                            this.setting.courseIsEdit = false;
                            this.setting.skypeIdIsEdit = true;
                            break;
                    }
                }
            }
        });
    </script>
@endsection