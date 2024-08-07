@extends('common.admin.layout.base')

@section('scripts')
@parent
<script>

$.ajax({
        type:"POST",
        url: getBaseUrl() + "/admin/logout",
        headers: {
            Authorization: "Bearer " + getToken("admin")
        },
        beforeSend: function() {
            showLoader();
        },
        success:function(data){
            hideLoader();
			removeStorage('admin');
            removeStorage('siteSettings');
            window.location.replace("{{ url('/admin/login') }}");
            document.cookie = 'admin_login=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
        }, 
        error: (jqXHR, textStatus, errorThrown) => {
            hideLoader();
            removeStorage('admin');
            removeStorage('siteSettings');
            window.location.replace("{{ url('/admin/login') }}");
            document.cookie = 'admin_login=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
        }
    });

</script>
@stop