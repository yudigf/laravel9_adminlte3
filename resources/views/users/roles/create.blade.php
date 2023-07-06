@extends('adminlte::page')

@section('title', 'Create Roles | Dashboard')

@section('content_header')
    <h1>Create Roles</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div id="errorBox"></div>
            <form action="{{ route('users.roles.store') }}" method="POST">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name" class="form-label">Name <span class="text-danger"> *</span></label>
                            <input type="text" name="name" class="form-control" placeholder="For example Manager" value="{{ old('name') }}">
                            @if($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                        <label for="name" class="form-label">Assign Permissions <span class="text-danger"> *</span></label>

                        <!--DataTable-->
                        <div class="table-resnponsive">
                            <table id="tblData" class="table table-bordered table-striped dataTable dtr-inline">
                                <thead>
                                    <tr>
                                        <th>

                                        </th>
                                        <th>Name</th>
                                        <th>Guard</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Save Role</button>
                    </div>
                </div>
            </form>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> 
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
        $(document).ready(function(){
            var table = $('#tblData').DataTable({
                responsive:true, processing:true, serverSide:true, autoWidth:false, bPaginate:false, bFilter:false,
                ajax:"{{ route('users.permissions.index') }}",
                columns:[
                    {data:'chkBox', name:'chkBox'},
                    {data:'name', name:'name'},
                    {data:'guard_name', name:'guard_name'},
                    
                ], 
                order:[[0, "desc"]]
            });
        })
    </script>
@stop

@section('plugins.Datatables', true)