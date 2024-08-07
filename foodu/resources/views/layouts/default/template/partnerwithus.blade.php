<div class="user_dashboard">
<div class="container no_pad">
<div class="user_detl col-xs-12">
<div class="name-edit-prof">Partner With Tastyeats</div>
<div class="number-email-prof">Be a part of the product tech industry. Be a part of the future.</div>
</div>
</div>
</div>
<div class="container no_pad">
<div class="user_detl col-xs-12 content">
    @if(Session::has('msgstatus') && Session::has('msgstatus') == 'success')
        <div class="alert alert-success" >Your request to be submitted! Will review your request soon. </div>
        {{Session::flush()}}
    @endif
    @if(Session::has('msgstatus') && Session::has('msgstatus') == 'error')
        <div class="alert alert-error" >Something went wrong! Please try someother time.</div>
        {{Session::flush()}}
    @endif
<BR>
       
<form action="{!! url('/sendPartnerRequest') !!}" method="post" novalidate="" enctype="multipart/form-data" data-parsley-validate="" >
    <div class="col-md-6 mb-20">
        <label>* Name</label>
        <input type="text" name="name" class="form-control">        
        @if($errors->has('name'))
        <div class="error">{{ $errors->first('name') }}</div>
        @endif
    </div>
    <div class="col-md-6 mb-20">
        <label>* Shop Name</label>
        <input type="text" name="shop_name" class="form-control" required>      
    </div>
    <div class="col-md-6 mb-20">
        <label>* Address</label>
        <input type="text" name="address" class="form-control" required>        
    </div>
    <div class="col-md-6 mb-20">
        <label>* Contact Number</label>
        <input type="text" name="contact_number" class="form-control" required>     
    </div>
    <div class="col-md-6 mb-20">
        <label>* Email</label>
        <input type="email" name="email" class="form-control" required>     
    </div>
    <div class="col-md-12">
        <label>Categories</label>
            <div class="d-flex mt-20">      
                @if(count($food_categories) > 0)
                    @foreach($food_categories as $k => $v)
                        <span class="checkmark"></span>
                        <input type="checkbox"  id="category_{{$v->id}}" name="category[]" value="{{$v->id}}">
                    <label class="container" for="category_{{$v->id}}"> {{ $v->name }} </label>
                    @endforeach
                @endif
            </div>
    </div>
    <div class="col-md-12 mt-20">   
        <label for="message">Message</label><br>
        <textarea cols="50" rows="10" name="message"></textarea>        
    </div>
    <div class="col-md-12 mt-20">
        <input type="submit" id="sbt" name="sbt" class="btn btn-primary" >              
        <a href="{!! url('partner-with-us') !!}" class="btn btn-primary">Cancel</a>     
    </div>
</form>
</div>
</div>