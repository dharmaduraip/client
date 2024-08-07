@extends('common.provider.layout.base')

@section('scripts')
@parent
<script>

$.ajax({
        type:"POST",
        url: getBaseUrl() + "/provider/logout",
        headers: {
            Authorization: "Bearer " + getToken("provider")
        },
        beforeSend: function() {
            showLoader();
        },
        success:function(data){
            hideLoader();
			removeStorage('provider');
            removeStorage('siteSettings');
			window.location.replace("{{ url('/provider/login') }}");
        }, 
        error: (jqXHR, textStatus, errorThrown) => {
            hideLoader();
            removeStorage('provider');
            removeStorage('siteSettings');
            window.location.replace("{{ url('/provider/login') }}");
        }
    });

</script>
@stop
