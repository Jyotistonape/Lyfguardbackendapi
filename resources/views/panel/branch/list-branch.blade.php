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
                        <a href="{{route('createBranch')}}" class="btn btn-primary">Add Branch <span class="btn-icon-right"><i class="fa fa-plus-square"></i></span>
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
                                <th>Hospital</th>
                                <th>Name</th>
                                <th>Phone</th>
{{--                                <th>Website</th>--}}
{{--                                <th>Address</th>--}}
{{--                                <th>Latitude</th>--}}
{{--                                <th>Longitude</th>--}}
                                <th>Is Emergency</th>
                                <th>Is Partner</th>
{{--                                <th>BranchAdmin</th>--}}
                                <th>Admin Email</th>
{{--                                <th>Wallet</th>--}}
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($data['branches'])
                                @foreach($data['branches'] as $branch)
                                    <tr>
                                        <td>{{$branch->id}}</td>
                                        <td>{{$branch->typeName}}</td>
                                        <td>{{$branch->hospitalName}}</td>
                                        <td>{{$branch->name}}</td>
                                        <td>{{$branch->phone}}</td>
{{--                                        <td>{{$branch->website}}</td>--}}
{{--                                        <td class="data-trim">{{$branch->address_line1. ', '.$branch->address_line2.', '.$branch->city.', '.$branch->state.', '.$branch->country}}</td>--}}
{{--                                        <td>{{$branch->latitude}}</td>--}}
{{--                                        <td>{{$branch->longitude}}</td>--}}
                                        <td>
                                            @if($branch->is_emergency == 1)
                                                <span>Yes</span>
                                            @else
                                                <span>No</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($branch->is_partner == 1)
                                                <span>Yes</span>
                                            @else
                                                <span>No</span>
                                            @endif
                                        </td>
{{--                                        <td>{{$branch->userName}}</td>--}}
                                        <td>{{$branch->userEmail}}</td>
{{--                                        <td>{{$branch->wallet_balance}}</td>--}}
                                        <td>
                                           <a href="{{route('editBranch', $branch->id)}}" class="btn btn-sm btn-success"><i class="flaticon-381-edit-1"></i></a>
                                            <form action="{{route('deleteBranch', $branch->id)}}" method="post"
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
                                <th>Hospital</th>
                                <th>Name</th>
                                <th>Phone</th>
{{--                                <th>Website</th>--}}
{{--                                <th>Address</th>--}}
{{--                                <th>Location</th>--}}
                                <th>Is Emergency</th>
                                <th>Is Partner</th>
{{--                                <th>BranchAdmin</th>--}}
                                <th>Admin Email</th>
{{--                                <th>Wallet</th>--}}
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

