@extends('order.shop.layout.base')

@section('scripts')
@parent
<script>

$.ajax({
        type:"POST",
        url: getBaseUrl() + "/shop/logout",
        headers: {
            Authorization: "Bearer " + getToken("shop")
        },
        success:function(data){
			removeStorage('shop');
            removeStorage('siteSettings');
            window.location.replace("{{ url('/shop/login') }}");
        }, 
        error: (jqXHR, textStatus, errorThrown) => {
            removeStorage('shop');
            removeStorage('siteSettings');
            window.location.replace("{{ url('/shop/login') }}");
        }
    });

</script>
@stop