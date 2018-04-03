@extends('layouts.app')

@section('title', 'Program Setting')

@section('content')
    <div id="app">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-body">
                    <button @click="createProgram()" class="btn btn-primary btn-flat btn-sm pull-right m-b-10"><span class="glyphicon glyphicon-plus"></span>&nbsp; Create</button>
                    <table id="program-table" class="table table-striped table-bordered">
                        <thead>
                            <th>#</th>
                            <th>Name</th>
                            <th>Display Name</th>
                            <th>Description</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            <tr v-if="programs.length === 0">
                                <td valign="top" colspan="15" class="text-center">No Records</td>
                            </tr>
                            <tr v-else v-for="program in programs">
                                <td>@{{ program.id }}</td>
                                <td>@{{ program.name }}</td>
                                <td>@{{ program.display_name }}</td>
                                <td>@{{ program.description }}</td>
                                <td>
                                    <button class="btn btn-primary btn-flat btn-xs" data="add"><span class="glyphicon glyphicon-plus"></span></button>&nbsp;
                                    <button class="btn btn-success btn-flat btn-xs" data="edit"><span class="glyphicon glyphicon-pencil"></span></button>&nbsp;
                                    <button class="btn btn-danger btn-flat btn-xs" data="delete"><span class="glyphicon glyphicon-trash"></span></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="box-footer">
                    <ul class="pagination pagination-sm no-margin pull-right">
                        <li>
                            <a @click="previous()">«</a>
                        </li>
                        <li>
                            <a>@{{ current_page }}</a>
                        </li>
                        <li>
                            <a>of</a>
                        </li>
                        <li>
                            <a>@{{ last_page }}</a>
                        </li>
                        <li>
                            <a @click="next()">»</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="modal fade" id="program-modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Modal title</h4>
                    </div>
                    <div class="modal-body">
                        <table id="program-single-table" class="table table-striped table-bordered">
                            <thead>
                                <th>#</th>
                                <th>Name</th>
                                <th>Display Name</th>
                                <th>Description</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Application Form</td>
                                    <td>Application Form</td>
                                    <td>
                                        <button class="btn btn-success btn-flat btn-xs"><span class="glyphicon glyphicon-pencil"></span></button>&nbsp;
                                        <button class="btn btn-danger btn-flat btn-xs"><span class="glyphicon glyphicon-trash"></span></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <div class="modal fade" id="program-single-modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Create Program</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="program-name">Name</label>
                            <input type="text" class="form-control" placeholder="Type Program Name...">
                        </div>
                        <div class="form-group">
                            <label for="program-display-name">Display Name</label>
                            <input type="text" class="form-control" placeholder="Type Display Name...">
                        </div>
                        <div class="form-group">
                            <label for="program-description">Description</label>
                            <input type="text" class="form-control" placeholder="Type Description...">
                        </div>
                    </div>
                    <div class="modal-footer clearfix">
                        <button class="btn btn-success btn-flat btn-block">Save Program</button>
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
                programs: [],
                links: [],
                current_page: '',
                last_page: ''
            },
            mounted: function() {
                this.loadPrograms();
            },
            methods: {
                previous() {
                    axios(this.links.prev)
                        .then((response) => {
                            console.log(response);
                        }).catch((error) => {
                            console.log(error);
                    });
                },
                next() {
                    axios(this.links.next)
                        .then((response) => {
                            console.log(response);
                        }).catch((error) => {
                            console.log(error);
                    });
                },
                loadPrograms() {
                    axios('/program/view')
                        .then((response) => {
                            this.programs = response.data.data;
                            this.links = response.data.links;
                            this.current_page = response.data.meta.current_page;
                            this.last_page = response.data.meta.last_page;
                        }).catch((error) => {
                            console.log(error);
                    });
                },
                createProgram() {
                    $('#program-single-modal').modal('show');
                }
            }
        });
    </script>
@endsection