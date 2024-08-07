@extends('website.layouts.app')

@section('title')
{{ __('build-resume') }}
@endsection

@section('css')
<style>
    .choose-template {
        background-color: #f6f0f8 !important;
    }
    .centerbg{
        display: flex;
        justify-content: center;
    }
    .tempimg {
        height: 100%;
        width: 100%;
    }

    .tempsize {
        height: 440px;
        width: 340px;
        border: 3px solid #00000000;
    }

    /* krishna */
    .tempsize:hover {
        border: 3px solid #742892 !important;
        cursor: pointer;
    }

    #choose-template {
        position: fixed;
        bottom: 10px;
        left: 50%;
        /* right: 0px;
        margin: 0 auto; */
    }

    .tempsize.border i {
        display: block !important;
        position: absolute;
        right: 13px;
        top: 15px;
        color: white;
    }

    .tempsize.border {
        position: relative;
        border: 3px solid #742892 !important;
    }

    .tempsize.border::before {
        content: "";
        position: absolute;
        height: 60px;
        width: 60px;
        background-color: #772b8e;
        top: 0;
        right: 0;
        border-radius: 0px 0px 0px 106px;
    }

    /* krishna */
</style>
@endsection

@section('main')
<div class="dashboard-wrapper">
    <div class="container">
        <div class="row">
            <x-website.candidate.sidebar />
            <div class="col-lg-9">
                <div class="dashboard-right">
                    <h5>{{__('Build Resume')}}</h5>
                    <div>
                        <p class="text-center">{{__('Templates we recommend for you')}}</p>
                        <div class="choose-template">
                            <div class="col-12">
                                <div class="row">
                                    @foreach($templates as $template)
                                    <div class="col-6 pt-5 centerbg">
                                        <div class="tempsize" data-id="{{ $template->id }}">
                                            <i class="fas fa-check d-none"></i>
                                            <img src="{{ url('uploads/templates/'.$template->template_name) }}" class="tempimg">
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="template_id" class="tempid">
                        <div class="d-flex justify-content-center" id="choose-template">
                            <input type="button" value="{{__('CHOOSE THIS TEMPLATE')}}" class="btn btn-warning ctt">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        $(".ctt").addClass('d-none');
        $(".tempsize").click(function() {
            $(".tempsize").removeClass('border');
            $(".tempid").val($(this).attr('data-id'));
            $(this).addClass('border');
            $(".ctt").removeClass('d-none');
        });

        $(".ctt").click(function() {
            var template_id = $(".tempid").val();
            if (template_id == "") {
                alert("Please Choose Any one Resume Template!");
            } else {
                $.ajax({
                    url: "{{ route('candidate.template') }}",
                    type: "POST",
                    data: {
                        template_id: template_id,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        if (data.result == true) {
                            window.location = "{{ url('candidate/build-resume/header')}}";
                        } else {
                            location.reload();
                        }
                    }
                });
            }
        });
    });
</script>
@endsection