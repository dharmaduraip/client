@extends('layouts.app')

@section('content')

<div class="page-content">
  <!-- Page header -->
  <div class="page-header">
    <div class="page-title">
      <h3>  Notification </h3>
    </div>

    <!-- <ul class="breadcrumb">
     <li><a href="{{ URL::to('dashboard') }}"> Dashboard </a></li>
     <li class="active">Notification  </li>
   </ul> -->
 </div>

 <div class="page-content-wrapper m-t">  

  @if(Session::has('messagetext'))    
  {{ Session::get('messagetext') }}
  @endif  

  <!-- @if(session()->has('messagetext'))
    <div class="alert alert-success">
        {{ session()->get('messagetext') }}
    </div>
@endif -->

  <!-- Start blast email -->

  {!! Form::open(array('url'=>'core/users/doblastnotification/', 'class'=>'form-horizontal ','parsley-validate'=>' ' ,'novalidate'=>' ')) !!}
  <div class="form-group  " >
    <label for="ipt" class=" control-label col-md-3">  </label>
    <div class="col-md-12">
      <ul class="parsley-error-list">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>                
    </div> 
  </div> 

  <div class="d-flex flex-wrap">
    <div class="col-sm-6">
      <div class="form-group  d-flex flex-wrap " >
          <label for="ipt" class=" control-label col-md-3">  Subject   </label>
          <div class="col-md-9">
            <input type="text" class="form-control" rows="15" required="true" name="subject_title">
          </div> 
      </div>
      <div class="form-group  d-flex flex-wrap  " >
          <label for="ipt" class=" control-label col-md-3">  Message   </label>
          <div class="col-md-9">
            <textarea class="form-control" rows="15" required="true" name="message"></textarea> 
          </div> 
      </div> 
      <div class="form-group  d-flex flex-wrap  " >
          <label for="ipt" class=" control-label col-md-3"> {!! Lang::get('core.fr_emailsendto') !!}   </label>
          <div class="col-md-9">
            <div class="d-flex flex-column">
                 @foreach($groups as $row)
                 @if($row->group_id == 3 || $row->group_id == 4)
                 <label class="checkbox">
                  <input type="checkbox" required="true"  name="groups[]" value="{{ $row->group_id}}" /> {{ $row->name }}
                </label>
                @endif

                @endforeach
              <label class="checkbox">
                <input type="checkbox" required="true"  name="groups[]" value="8" /> Delivery boy
              </label>
            </div>
          </div> 
      </div>  		  

    </div>
    <div class="col-sm-6">
      <div class="form-group  d-flex flex-wrap  " >
        <label for="ipt" class=" control-label col-md-3">  Status   </label>
        <div class="col-md-9"> 
          <div class=" d-flex flex-column ">         
            <label class="radio">
              <input type="radio" required="true"  name="uStatus" value="all" > All Status
            </label>
            <label class="radio">
              <input type="radio" required="true" name="uStatus" value="1" > Active 
            </label>  
            <label class="radio">
              <input type="radio" required="true" name="uStatus" value="0" > Unconfirmed
            </label>
            <label class="radio">
              <input type="radio" required="true" name="uStatus" value="2"> Blocked
            </label>  
          </div>                              
        </div> 
      </div>  
    </div>

  </div>  

<div class="col-sm-12">



  <div class="form-group d-flex flex-wrap" >
    <label for="ipt" class=" control-label col-md-3"> </label>
    <div class="col-md-9">
      <button type="submit" name="submit" class="btn btn-primary">{!! Lang::get('core.sb_send') !!} Notification </button>
    </div> 
  </div> 
</div>	                   
{!! Form::close() !!}


<!-- / blast email -->

</div>




</div>      



@stop