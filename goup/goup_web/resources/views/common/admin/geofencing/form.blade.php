@extends('common.admin.layout.base')
{{ App::setLocale(  isset($_COOKIE['admin_language']) ? $_COOKIE['admin_language'] : 'en'  ) }}

@section('title') {{ __('Add Geo Fencing') }} @stop

@section('styles')
@parent
<link rel="stylesheet" href="{{ asset('assets/plugins/data-tables/css/dataTables.bootstrap.min.css')}}" />
<link rel="stylesheet" href="{{ asset('assets/plugins/data-tables/css/responsive.bootstrap.min.css')}}">
@stop

@section('content')

<div class="main-content-container container-fluid px-4">
    <div class="page-header row no-gutters py-4">
        <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
            <span class="text-uppercase page-subtitle">@if(isset($id)) {{ __('Edit') }} @else {{ __('Add') }} @endif {{ __('Geo Fence') }}</span>
            <h3 class="page-title">@if(isset($id)) {{ __('Edit') }} @else {{ __('Add') }} @endif {{ __('Geo Fence') }}</h3>
        </div>
    </div>
    <div class="row mb-4 mt-20">
        <div class="col-md-12">
            <div class="card card-small">
                <div class="card-header border-bottom">
                    <h6 style="padding: 10px 0;" class="m-0 pull-left">@if(isset($id)) {{ __('Edit') }} @else {{ __('Add') }} @endif {{ __('Geo Fence') }}</h6>
                </div>

                <div class="col-md-12">
                    <div class="note_txt">
                        @if(Helper::getDemomode() == 1)
                        <p>** Demo Mode : {{ __('admin.demomode') }}</p>
                        <span class="pull-left">(*personal information hidden in demo)</span>
                        @endif

                    </div>
                </div>
                <form class="validateForm">
                    @csrf()
                    @if(!empty($id))
                    <input type="hidden" name="_method" value="PATCH">
                    <input type="hidden" name="id" value="{{$id}}">
                    @endif
                    <div style="margin:16px 16px 0" class="form-group row">

                        <div class="form-group col-md-3">
                            <label for="country_id" class="col-xs-2 col-form-label">{{ __('admin.city.country') }}</label>
                            <select name="country_id" id="country_id" class="form-control">
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="city_id" class="col-xs-2 col-form-label">{{ __('admin.city.city') }}</label>
                            <select name="city_id" id="city_id" class="form-control">
                             <option value="">Select</option>
                         </select>
                     </div>
                     <div class="form-group col-md-3">
                        <label for="location_name" class="col-xs-2 col-form-label">{{ __('admin.geo_fencing.location') }}</label>
                        <input class="form-control" type="text" value="" name="location_name" required id="location_name" placeholder="Location">
                    </div>
                    <div style="padding-top:40px;" class="form-group col-md-3">
                        <label style="float:left;" for="is_airport" class="col-xs-2 col-form-label"><input  type="checkbox" value="AIRPORT" name="type" id="is_airport" >{{ __('admin.geo_fencing.is_airport') }}</label> 
                    </div>
                    <input type="hidden" name="ranges" class="ranges" value="">
                </div>

                <div id="map" style="margin:16px 2%; width: 96%; height: 470px;"></div>
                
                <div style="margin-left:16px"  id="bar">
                    <button id="clear" type="reset" class="btn btn-secondary" >{{ __('Clear') }}</button>
                    <button type="reset" class="btn btn-danger" >{{ __('Reset') }}</button>
                    <button type="submit" class="btn btn-info" >{{ __('Submit') }}</button>
                </div>
                <br /><br />
            </form>
        </div>
    </div>
</div>
</div>
@stop
@section('scripts')
@parent
<script src="https://maps.googleapis.com/maps/api/js?key={{Helper::getSettings()->site->browser_key}}&libraries=places,drawing"></script>
<script>
    var map;
    var polygon;
    var s_latitude = document.getElementById('latitude');
    var s_longitude = document.getElementById('longitude');
    var s_address = document.getElementById('address');
    var arr = [];
    var selectedShape;
    var selected_city;

    var old_latlng = new Array();
    var markers = new Array();

    var OldPath = [];//JSON.parse($('input.ranges').val());

    //if($("input[name=id]").length == 0) {
        if( navigator.geolocation ) {
            navigator.geolocation.getCurrentPosition( success, fail );
        } else {
            console.log('Sorry, your browser does not support geolocation services');
            initMap();
        }
    //}
    

    function success(position)
    {

        if(position.coords.longitude != "" && position.coords.latitude != ""){
            current_longitude = position.coords.longitude;
            current_latitude = position.coords.latitude;
        }

        initMap(current_latitude, current_longitude);
    }

    function fail()
    {
        initMap();
    }

    function initMap(current_latitude, current_longitude) {

        var userLocation = new google.maps.LatLng(current_latitude, current_longitude);

        map = new google.maps.Map(document.getElementById('map'), {
            center: userLocation,
            zoom: 15,
        });

        var drawingManager = new google.maps.drawing.DrawingManager({
            drawingMode: google.maps.drawing.OverlayType.POLYGON,
            drawingControl: true,
            drawingControlOptions: {
                position: google.maps.ControlPosition.TOP_CENTER,
                drawingModes: [google.maps.drawing.OverlayType.POLYGON]
            },
            polygonOptions: {
                editable: true,
                draggable: true,
                fillColor: '#ff0000',
                strokeColor: '#ff0000',
                strokeWeight: 1
            }
        });
        drawingManager.setMap(map);

        google.maps.event.addListener(drawingManager, 'overlaycomplete', function(e) {
            var bounds = [];
            var layer_bounds = [];
            var newShape = e.overlay;
            
            if (e.type == google.maps.drawing.OverlayType.POLYGON) {
                var locations = e.overlay.getPath().getArray();
                arr.push(e);
                $.each(locations, function(index, value) {
                    var markerLat = (value.lat()).toFixed(6);
                    var markerLng = (value.lng()).toFixed(6);
                    layer_bounds.push(new google.maps.LatLng((value.lat()).toFixed(6), (value.lng()).toFixed(6)));
                    json = {
                        'lat': markerLat,
                        'lng': markerLng
                    };
                    bounds.push(json);
                });
                $('input.ranges').val(JSON.stringify(bounds));

                overlayClickListener(e.overlay);
                drawingManager.setOptions({
                    drawingMode: null,
                    drawingControl: false
                });
                setSelection(newShape);
            }
        });

        var old_polygon = [];

        $(OldPath).each(function(index, value) {
            old_polygon.push(new google.maps.LatLng(value.lat, value.lng));
            old_latlng.push(new google.maps.LatLng(value.lat, value.lng));
        });

        polygon = new google.maps.Polygon({
            path: old_polygon,
            strokeColor: "#ff0000",
            strokeOpacity: 0.8,
            // strokeWeight: 1,
            fillColor: "#ff0000",
            fillOpacity: 0.3,
            editable: true,
            draggable: true,
        });

        polygon.setMap(map);



        $(document).on('click', '#clear', function(e) {
            drawingManager.setMap(map);
            polygon.setMap(null);
            deleteSelectedShape();
            $('input[name=ranges]').val('');
            e.preventDefault();
            return false;
        });
    }

    $(document).ready(function()
    {
        basicFunctions();

        var id = "";

        if($("input[name=id]").length){
            id = "/"+ $("input[name=id]").val();
        }

        $.ajax({
            type:"GET",
            url: getBaseUrl() + "/admin/company_country_list",
            headers: {
                Authorization: "Bearer " + getToken("admin")
            },
            success:function(data){
                var data = parseData(data);
                $("#country_id").empty();
                $("#country_id").append('<option value="">Select</option>');
                $.each(data.responseData,function(key,item){
                    if(item.country.length !=0){
                        $("#country_id").append('<option value="'+item.country.id+'">'+item.country.country_name+'</option>');
                    }
                });
                loadData();
            }
        });

        $('#country_id').on('change', function(){
            var country_id =$("#country_id").val();
            $.ajax({
                type:"GET",
                url: getBaseUrl() + "/admin/countrycities/"+country_id,
                headers: {
                    Authorization: "Bearer " + getToken("admin")
                },
                'beforeSend': function (request) {
                    showInlineLoader();
                },
                success:function(data){
                    var data = parseData(data);
                    $("#city_id").html('');
                    $("#city_id").append('<option value="">Select</option>');
                    $.each(data.responseData,function(key,item){
                        $("#city_id").append('<option value="'+item.city.id+'">'+item.city.city_name+'</option>');
                    });
                    setCity();
                    hideInlineLoader();
                }

            });
        });


        var geocoder = new google.maps.Geocoder();
        $('select[name=city_id]').on('change', function(){
            if($(this).val() != "") {
                var country =$('select[name=country_id]').find('option:selected').text();
                var city =$(this).find('option:selected').text();

                geocoder.geocode( { 'address': city + ',' +country}, function(results, status) {              
                    if (status == google.maps.GeocoderStatus.OK) {
                        var latitude = results[0].geometry.location.lat();
                        var longitude = results[0].geometry.location.lng();
                        initMap(latitude, longitude);

                    } 
                });
            }
        });


        $('.validateForm').validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                rules: {
                    country_id: { required: true },
                    city_id: { required: true },
                    location_name: { required: true },
                    ranges: { required: true }
                },

                messages: {
                    country_id: { required: "Country is required." },
                    city_id: { required: "City is required." },
                    location_name: { required: "Location is required." },
                    ranges: { required: "Range is required." },

                },
                highlight: function(element)
                {
                    $(element).closest('.form-group').addClass('has-error');
                },
                success: function(label) {
                    label.closest('.form-group').removeClass('has-error');
                    label.remove();
                },
                submitHandler: function(form) {
                    var formGroup = $(".validateForm").serialize().split("&");
                    var data = new FormData();
                    for(var i in formGroup) {
                        var params = formGroup[i].split("=");
                        data.append( decodeURIComponent(params[0]), decodeURIComponent(params[1]) );
                    }
                    var url = getBaseUrl() + "/admin/geofence"+id;
                    saveRow( url, null, data, "admin", "/admin/geo-fencing");

                }
            });

    });

function setCity() {
    if(selected_city != null || selected_city !== undefined) {
        $('select[name=city_id]').val(selected_city);
    }
}

function loadData() {
    @if(isset($id))

    var OldPath = [];

    $.ajax({
        type:"GET",
        url: getBaseUrl() + "/admin/geofence/"+ {{$id}},
        async: false,
        headers: {
            Authorization: "Bearer " + getToken("admin")
        },
        success:function(response){
            var data = parseData(response);
            selected_city = data.responseData.city_id;
            $('input[name=location_name]').val(data.responseData.location_name);
            $('select[name=country_id]').val(data.responseData.country_id);
            $('select[name=country_id]').trigger('change');
            var types = data.responseData.type;
           
            $("input[name='type'][value='"+types+"']").prop('checked', true);
            
            $("input[name='type'][value='test']").trigger('change');
            $('input[name=ranges]').val(data.responseData.ranges);
            OldPath = JSON.parse(data.responseData.ranges);

            var old_polygon = [];
            var newLocation;

            $(OldPath).each(function(index, value){
                newLocation = new google.maps.LatLng(value.lat, value.lng);
                old_polygon.push(new google.maps.LatLng(value.lat, value.lng));
                old_latlng.push(new google.maps.LatLng(value.lat, value.lng));
            });

            polygon = new google.maps.Polygon({
                path: old_polygon,
                strokeColor: "#ff0000",
                strokeOpacity: 0.8,
                strokeWeight: 1,
                fillColor: "#ff0000",
                fillOpacity: 0.3,
                editable: true,
                draggable: true,
            });

            map = new google.maps.Map(document.getElementById('map'), {
                center: newLocation,
                zoom: 10,
            });

            polygon.setMap(map);

            setSelection(polygon);

        }
    });



    @endif
}

function createMarker(markerOptions) {
    var marker = new google.maps.Marker(markerOptions);
    markers.push(marker);
    old_latlng.push(marker.getPosition());
    return marker;
}

function overlayClickListener(overlay) {
    google.maps.event.addListener(overlay, "mouseup", function(event) {
        var arr_loc = [];
        var locations = overlay.getPath().getArray();
        $.each(locations, function(index, value) {
            var locLat = (value.lat()).toFixed(6);
            var locLng = (value.lng()).toFixed(6);
            ltlg = {
                'lat': locLat,
                'lng': locLng
            };
            arr_loc.push(ltlg);
        });
        $('input[name=ranges]').val(JSON.stringify(arr_loc));
    });
}

function setSelection(shape) {
    if (shape.type == 'polygon') {
        clearSelection();
        shape.setEditable(true);
    }
    selectedShape = shape;
}

function clearSelection() {
    if (selectedShape) {
        console.log(selectedShape.type);
        if (selectedShape.type == 'polygon') {
            selectedShape.setEditable(false);
        }

        selectedShape = null;
    }
}

function deleteSelectedShape() {
    if (selectedShape) {
        $('input[name=ranges]').val('');
        selectedShape.setMap(null);
    }
}
</script>
@stop