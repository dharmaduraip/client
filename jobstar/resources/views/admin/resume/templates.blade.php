@extends('admin.layouts.app')
@section('title')
    {{ __('Resume_templates') }}
@endsection
@section('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />
    <style type="text/css">
        .tempdiv{
            width:150px;
            height: 150px;
        }
        .tempimg{
            height: 100%;
            width: 100%;
        }
    </style>
@endsection
@section('content')
     <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title line-height-36">{{ __('Resume Templates') }}</h3>
                    </div>
                </div>
                <div class="card-body table-responsive p-3 m-0">
                    <div class="col-sm-12">
                        <table class="ll-table table table-hover text-nowrap" id="myTable">
                            <thead>
                                <tr>
                                    <th>{{__('id')}}</th>
                                    <th>{{__('Template Image')}}</th>
                                    <th>{{__('Template Type')}}</th>
                                    <th>{{__('Status')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($templates as $template)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="tempdiv">
                                                <img src="{{ url('uploads/templates/'.$template->template_name) }}" alt="{{ $template->template_type }}" class="tempimg">
                                            </div>
                                        </td>
                                        <td>{{ $template->template_type }}</td>
                                        <td>
                                            @if($template->status == "1")
                                                <span class="badge badge-success">{{__('Active')}}</span>
                                            @else
                                                <span class="badge badge-danger">{{__('Inactive')}}</span>
                                            @endif
                                        </td>
                                    </tr>   
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>      
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready( function () {
            $('#myTable').DataTable();
            // responsive: true,
        });
    </script>
@endsection