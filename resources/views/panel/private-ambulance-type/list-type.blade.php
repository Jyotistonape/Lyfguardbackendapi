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
                        <a href="{{route('createPrivateAmbulanceType')}}" class="btn btn-primary">Add Ambulance Type  <span class="btn-icon-right"><i class="fa fa-plus-square"></i></span>
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
                                <th>Name</th>
                                {{--<th>Image</th>--}}
                                {{--<th>Descrption</th>--}}
                                <!-- <th>Has Amenity</th> -->
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($data['types'])
                                @foreach($data['types'] as $type)
                                    <tr>
                                        <td>{{$type->id}}</td>
                                        <td>{{$type->name}}</td>
                                        <!-- <td>{{($type->has_amenity == 1) ? 'Yes' : 'No'}}</td> -->
                                        
                                        <td>
                                            <a href="{{route('editPrivateAmbulanceType', $type->id)}}" class="btn btn-sm btn-success"><i class="flaticon-381-edit-1"></i></a>
                                            <form action="{{route('deletePrivateAmbulanceType', $type->id)}}" method="post"
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
                                <th>Name</th>
                                {{--<th>Image</th>--}}
                                {{--<th>Descrption</th>--}}
                                {{--<th>Price</th>--}}
                                <!-- <th>Has Amenity</th> -->
                                <!-- <th>Action</th> -->
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

