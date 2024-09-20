@extends('layouts.panel')

@section('headscript')
    <link href="{{asset('assets/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">
@endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{$data['pageName']}}</h4>
                    <h4 class="card-title">
                        <a href="{{route('createHospital')}}" class="btn btn-primary">Add Hospital <span class="btn-icon-right"><i class="fa fa-plus-square"></i></span>
                        </a>
                    </h4>
                </div>
                <div class="card-body">
                    @include('incl.message')
                    <div class="table-responsive">
                        <table id="example" class="display" style="min-width: 845px">
                            <thead>
                            <tr>
                                <th>ID#</th>
                                <th>Type</th>
                                <th>Name</th>
{{--                                <th>Logo</th>--}}
{{--                                <th>Banner</th>--}}
{{--                                <th>Website</th>--}}
                                <th>HospitalAdmin</th>
                                <th>Admin Email</th>
                                <th>Wallet Balance</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($data['hospitals'])
                                @foreach($data['hospitals'] as $hospital)
                                    <tr>
                                        <td>{{$hospital->id}}</td>
                                        <td>{{$hospital->typeName}}</td>
                                        <td>{{$hospital->name}}</td>
{{--                                        <td>--}}
{{--                                            @if($hospital->logo)--}}
{{--                                            <img src="{{asset('storage/'. $hospital->logo)}}" width="100px" height="100px">--}}
{{--                                                @endif--}}
{{--                                        </td>--}}
{{--                                        <td>--}}
{{--                                            @if($hospital->banner)--}}
{{--                                                <img src="{{asset('storage/'. $hospital->banner)}}" width="100px" height="100px">--}}
{{--                                            @endif--}}
{{--                                        </td>--}}
{{--                                        <td>{{$hospital->website}}</td>--}}
                                        <td>{{$hospital->userName}}</td>
                                        <td>{{$hospital->userEmail}}</td>
                                        <td>{{$hospital->wallet_balance}}</td>
                                        <td>
                                            <a href="{{route('editHospital', $hospital->id)}}" class="btn btn-sm btn-success"><i class="flaticon-381-edit-1"></i></a>
                                            <form action="{{route('deleteHospital', $hospital->id)}}" method="post"
                                                  style="display: inline"
                                                  onsubmit="return confirm('Do you really want to delete this?');">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-sm btn-danger"><i class="flaticon-381-trash-1"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>ID#</th>
                                <th>Type</th>
                                <th>Name</th>
                                {{--                                <th>Logo</th>--}}
                                {{--                                <th>Banner</th>--}}
                                {{--                                <th>Website</th>--}}
                                <th>HospitalAdmin</th>
                                <th>Admin Email</th>
                                <th>Wallet Balance</th>
                                <th>Action</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')

    <!-- Datatable -->
    <script src="{{asset('assets/vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins-init/datatables.init.js')}}"></script>
@endsection

