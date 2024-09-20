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
                        <a href="{{route('createListing')}}" class="btn btn-primary">Add Listing <span class="btn-icon-right"><i class="fa fa-plus-square"></i></span>
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
                                <th>Image</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>City</th>
                                {{--<th>Email</th>--}}
                                {{--<th>Address</th>--}}
                                {{--<th>Latitude</th>--}}
                                {{--<th>Longitude</th>--}}
                                {{--<th>Website</th>--}}
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($data['listings'])
                                @foreach($data['listings'] as $listing)
                                    <tr>
                                        <td>{{$listing->id}}</td>
                                        <td>{{$listing->typeName}}</td>
                                        <td>
                                            @if($listing->image)
                                                <img src="{{asset('storage/'. $listing->image)}}" width="100px" height="100px">
                                                @endif
                                        </td>
                                        <td>{{$listing->name}}</td>
                                        <td>{{$listing->phone}}</td>
                                        {{--<td>{{'Phone1 : '.$listing->phone. ', Phone2 : '.$listing->phone2. ', Phone3 : '.$listing->phone3}}</td>--}}
                                        {{--<td>{{$listing->email}}</td>--}}
{{--                                        <td class="data-trim">{{$listing->address_line1. ', '.$listing->address_line2.', '.$listing->city.', '.$listing->state.', '.$listing->country}}</td>--}}
                                        <td>{{$listing->city}}</td>
                                        {{--<td>{{$listing->latitude}}</td>--}}
                                        {{--<td>{{$listing->longitude}}</td>--}}
{{--                                        <td class="data-trim">{{$listing->website}}</td>--}}
                                        <td>
                                            <a href="{{route('editListing', $listing->id)}}" class="btn btn-sm btn-success"><i class="flaticon-381-edit-1"></i></a>
                                            <form action="{{route('deleteListing', $listing->id)}}" method="post"
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
                                <th>Image</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>City</th>
                                {{--<th>Email</th>--}}
                                {{--<th>Address</th>--}}
                                {{--<th>Latitude</th>--}}
                                {{--<th>Longitude</th>--}}
                                {{--<th>Website</th>--}}
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

