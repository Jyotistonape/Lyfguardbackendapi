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
                        <a href="{{route('createPrivateAmbulance')}}" class="btn btn-primary">Add Ambulance <span class="btn-icon-right"><i class="fa fa-plus-square"></i></span>
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
                                <th>Vehicle Number</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Driver</th>
                                <th>Insurance Date</th>
                                <th>Registration Certificate</th>
                                <th>Rate Per KM</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($data['ambulances'])
                                @foreach($data['ambulances'] as $ambulance)
                                    <tr>
                                        <td>{{$ambulance->id}}</td>
                                        <td>{{$ambulance->vehicle_number}}</td>
                                        <td>{{$ambulance->typeName}}</td>
                                        <td>
                                            @if($ambulance->running_status == 1)
                                                <span class="badge badge-success">On Duty</span>
                                            @elseif($ambulance->running_status == 2)
                                                <span class="badge badge-success">On Trip</span>
                                                @else
                                                <span class="badge badge-success">Off Duty</span>
                                            @endif
                                        </td>
                                        <td>{{($ambulance->driverName) ? $ambulance->driverName : 'NA'}}</td>
                                        <td>{{date('d M Y', strtotime($ambulance->insurance_date))}}</td>
                                        <td><img src="{{asset('storage/'. $ambulance->registration_certificate)}}" width="100px" height="100px"> </td>
                                        <td>
                                            <p>0 KM - 5 KM : {{$ambulance->zero_five_km_rate}}</p>
                                            <p>5 KM - 15 KM : {{$ambulance->five_fifteen_km_rate}}</p>
                                            <p>15 KM - 30 KM : {{$ambulance->fifteen_thirty_km_rate}}</p>
                                            <p>30+ KM : {{$ambulance->thirty_above_km_rate}}</p>
                                        </td>
                                        <td>
                                            <a href="{{route('editPrivateAmbulance', $ambulance->id)}}" class="btn btn-sm btn-success"><i class="flaticon-381-edit-1"></i></a>
                                            <form action="{{route('deletePrivateAmbulance', $ambulance->id)}}" method="post"
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
                                <th>Vehicle Number</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Driver</th>
                                <th>Insurance Date</th>
                                <th>Registration Certificate</th>
                                <th>Rate Per KM</th>
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

