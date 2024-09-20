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
                        <a href="{{route('createFirstAid')}}" class="btn btn-primary">Add FirstAid <span class="btn-icon-right"><i class="fa fa-plus-square"></i></span>
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
                                <th>Category</th>
                                <th>Title</th>
                                <th>Descrption</th>
                                <th>Video Link</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($data['firstAid'])
                                @foreach($data['firstAid'] as $aid)
                                    <tr>
                                        <td>{{$aid->id}}</td>
                                        <td>{{$aid->catName}}</td>
                                        <td>{{$aid->title}}</td>
                                        <td class="data-trim"><span>{{$aid->description}}</span></td>
                                        <td class="data-trim-m">{{$aid->video_link}}</td>
                                        <td>
                                            <a href="{{route('editFirstAid', $aid->id)}}" class="btn btn-sm btn-success"><i class="flaticon-381-edit-1"></i></a>
                                            <form action="{{route('deleteFirstAid', $aid->id)}}" method="post"
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
                                <th>Category</th>
                                <th>Title</th>
                                <th>Descrption</th>
                                <th>Video Link</th>
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

