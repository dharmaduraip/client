@extends('admin.layouts.master')
@section('title', 'User Verification - Admin')
@section('maincontent')
@component('components.breadcumb',['fourthactive' => 'active'])
@slot('heading')

@endslot
@slot('menu1')
{{ __('Manage Users') }}
@endslot
@slot('button')
<div class="col-md-4 col-lg-4">
    <div class="widgetbar">
    </div>
</div>
@endslot
@endcomponent
<div class="contentbar">
    <div class="row">
        @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            @foreach($errors->all() as $error)
            <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true" style="color:red;">&times;</span></button></p>
            @endforeach
        </div>
        @endif

        <!-- row started -->
        <div class="col-lg-12">

            <div class="card m-b-30">
                <!-- Card header will display you the heading -->
                <div class="card-header">
                    <h5 class="card-box">{{ __('Users') }}</h5>
                </div>

                <!-- card body started -->
                <div class="card-body">
                    <div class="table-responsive">
                        <!-- table to display faq start -->
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                            <thead>
                                <th>
                                    #
                                </th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Role') }}</th>
                                <th>{{ __('Is Verify') }}</th>
                                <th>{{ __('Is Blocked') }}</th>
                                <th>{{ __('Action') }}</th>
                            </thead>

                            <tbody>
                                @foreach($users as $key=>$user)
                                <td>
                                    <?php echo $key+1; ?>
                                </td>
                                <td data-toggle="modal" data-target="#exampleModal">{{$user->fname}} {{$user->lname}}</td>
                                <td>{{$user->role}}</td>
                                <td>
                                    <label class="switch">
                                            <input class="faq verifyuser{{$user->id}}" type="checkbox" data-id="{{$user->id}}" name="is_verify" onclick="is_verifyuser({{$user->id}})"
                                                {{ $user->is_verify == '1' ? 'checked' : '' }}>
                                            <span class="knob"></span>
                                    </label>
                                </td>
                                <td>
                                    <label class="switch">
                                            <input class="faq is_blockeduser{{$user->id}}" type="checkbox" data-id="{{$user->id}}" name="is_blocked" onclick="is_blockeduser({{$user->id}})" 
                                                {{ $user->is_blocked == '1' ? 'checked' : '' }} >
                                            <span class="knob"></span>
                                    </label>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal{{$user->id}}"><i class="feather icon-eye mr-2"></i>View</button>
                                </td>
                                </tr>

                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">{{$user->fname}} {{$user->lname}}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-lg-4">Email :</div><div class="col-lg-8">{{$user->email}}</div>
                                                <div class="col-lg-4">Mobile :</div><div class="col-lg-8">{{$user->mobile}}</div>
                                                <div class="col-lg-4">Role :</div><div class="col-lg-8">{{$user->role}}</div>
                                                @if($user->document_detail)
                                                    @if(isset($user->document_detail))
                                                    <div class="col-lg-4">Document Detail :</div><div class="col-lg-4">{{$user->document_detail}}</div><div class="col-lg-4"><a href="{{ url('images/user_img/'.$user->document_file) }}" target="_blank"><i class="fa fa-file" aria-hidden="true"></i></a></div>
                                                    @endif
                                                @else
                                                <div class="col-lg-12 text-center mt-2">No Document</div>
                                                @endif
                                                @if($user->is_blocked == "1" && $user->block_note != NULL)
                                                    <div class="col-lg-12 mt-3"><b>This User is Blocked</b></div>
                                                    <div class="col-lg-4">Reason :</div><div class="col-lg-8">{{$user->block_note}}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <!-- <button type="button" class="btn btn-info"  data-toggle="modal" data-target="#blockedModal{{$user->id}}">Block</button> -->
                                            <button type="button" class="btn btn-success text-light" onclick="verify({{$user->id}})">@if($user->is_verify == "0")Verify @else Un Verify @endif</button>
                                            
                                        </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal -->
                                <div class="modal fade" id="blockedModal{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="blockedModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="blockedModalLabel">{{$user->fname}} {{$user->lname}}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('user_blocked') }}" method="POST" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="form-group col-lg-12">
                                                        <label for="exampleFormControlTextarea1">Block Note</label>
                                                        <textarea class="form-control" name="block_note" id="exampleFormControlTextarea1" rows="3" required></textarea>
                                                        <input type="hidden" name="id" value="{{$user->id}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </div>
                                        </form>
                                        </div>
                                    </div>
                                </div>
                                                        
                                @endforeach
                            </tbody>
                        </table>
                        <!-- table to display faq data end -->
                    </div><!-- table-responsive div end -->
                </div><!-- card body end -->

            </div><!-- col end -->
        </div>
    </div>
</div><!-- row end -->
@endsection
@section('script')
<script>
function verify(id) {
    $.ajax({
        url: "{{ route('verifed_user') }}",
        type: 'GET',
        data: {id:id},
        dataType: 'JSON',
        success: function (data) { 
            console.log(data)
            window.location.reload();
        }
    }); 
}
function is_verifyuser(id)
{
    var user_id = id;
    if($(".verifyuser"+id).is(':checked'))
    {
        var is_verify = 1;
    }
    else
    {
        var is_verify = 0;
    }
    $.ajax({
        url: "{{ route('is_verifyuser') }}",
        type: 'GET',
        data: {is_verify:is_verify,user_id:user_id},
        dataType: 'JSON',
        success: function (data) { 
            // console.log(data);
            var warning = new PNotify( {
                title: 'success', text:'Update Successfully', type: 'success', desktop: {
                desktop: true, icon: 'feather icon-thumbs-down'
                }
            });
            warning.get().click(function() {
                warning.remove();
            });
        }
    }); 
}
function is_blockeduser(id)
{
    var user_id = id;
    if($(".is_blockeduser"+id).is(':checked'))
    {
        var is_blocked = 1;
        $('#blockedModal'+user_id).modal('show'); 
    }
    else
    {
        var is_blocked = 0;
        $.ajax({
            url: "{{ route('is_blockeduser') }}",
            type: 'GET',
            data: {is_blocked:is_blocked,user_id:user_id},
            dataType: 'JSON',
            success: function (data) { 
                // console.log(data);
                var warning = new PNotify( {
                    title: 'success', text:'Update Successfully', type: 'success', desktop: {
                    desktop: true, icon: 'feather icon-thumbs-down'
                    }
                });
                warning.get().click(function() {
                    warning.remove();
                });
                location.reload();
            }
        }); 
    }
    
    
}
</script>
@endsection