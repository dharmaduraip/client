@extends('website.layouts.app')
<style>
    .fsyz {
        font-size:20px;
    }
    .line {
        border-bottom:1px solid #ddd;
        margin:20px 0px;
    }
    .message .nav-pills .nav-link.active, .nav-pills .show>.nav-link {
        color: #fff;
        background-color: #742892;
    }
    .message .nav-link {
        color: #767f8c;
    }
    .right-content {
       border: 1px solid #ccc;
       border-radius: 6px;
    }
    .right-content img {
        width: 70px;
        height: 70px;
        border-radius: 4px;
    }
    .right-content h3 {
        font-size:20px;
        text-transform:capitalize;
    }
    .right-content p {
        font-size:15px;
    }
    .right-content .cenp {
        color:#767f8c;
    }
    .right-content .icons i{
        font-size:15px;
    }
    .right-content .mrk {
        color:red;
        font-size: 13px;
        text-transform: capitalize;
        position:relative;
        padding-left:16px;
    }
    .mrk:before {
        content:"";
        position:absolute;
        width:10px;
        height:10px;
        border-radius: 50%;
        border-color:green;
        background:green;
        left: 0px;
        top: 5px;
    }
    .wats-pt {
      color: #767f8c;
      font-size:14px; 
    }
    
    .section-2 .head-title{
        font-weight: 600;
        text-transform: capitalize;
    }
    .left-syd .c-tw {
        color:red;
        text-transform: capitalize;
    }
    .left-syd .mv-trsh i{
       font-size: 15px;
    }
    .left-syd .mv-trsh {
       background: #0000009e;
       color: #fff;
       padding: 7px;
       border-radius: 4px;
    }
    .watzp-leftcon img{
       width:70px;
       height:70px;
       border-radius:50%;
       border:1px solid #ccc;
       padding:5px;
    }
    .watzp-leftcon .text {
        margin-left:15px;
    }
    .text-right{
        text-align:right;
    }
    .chat-bubble {
        background: green;
        color: #fff;
        padding: 10px 14px;
        border-radius: 9px;
        position: relative;
        animation: fadeIn 1s ease-in;
    }
    .chat-bubble:after {
        content: "";
        position: absolute;
        bottom:0;
        width: 30px;
        height: 0;
        border: 20px solid transparent;
        border-bottom: 0;
        margin-top: -10px;
        right: 0;
        border-left-color: green;
        border-right: 0;
        margin-right: -20px;
    }
    .chat-box-tray {
        background: #eee;
        display: flex;
        align-items: center;
        padding: 10px 15px;
        align-items: center;
        margin-top: 19px;
        bottom: 0;
        border-top:1px solid #ddd;

    }
    .material-icons {
        background:#742892;
        font-size: 20px;
        text-transform: none;
        letter-spacing: normal;
        word-wrap: normal;
        white-space: nowrap;
        color: #fff;
        border-radius:5px;
        padding:10px;
    }
    .chat-box-tray input {
        margin: 0 10px;
        padding: 6px 2px;
     }
    .slct-sec .select-content select {
        border:1px solid #ccc;
       -webkit-appearance: none;
        appearance: none!important;
        padding:10px 23px;
        height:48px;
        background-image: url("data:image/svg+xml;utf8,<svg fill='black' height='24' viewBox='0 0 24 24' width='24' xmlns='http://www.w3.org/2000/svg'><path d='M7 10l5 5 5-5z'/><path d='M0 0h24v24H0z' fill='none'/></svg>");
        background-repeat: no-repeat;
        background-position-x: 95%;
        background-position-y: center;
        background-size: 30px;
        border-radius: 5px;
    }
    .slct-sec .select-content select:focus {
        border:1px solid #ccc;
    }
    .slct-sec .select-content .brdr-ad {
       border:1px solid #ccc; 
       padding:14px;
    }
    .clr-ad {
       color:#767f8c;
       font-size:15px;
    }
    
    

    
</style>
@section('title')
    {{ __('my_jobs') }}
@endsection
@section('main')
    <div class="dashboard-wrapper">
        <div class="container">
            <div class="row">
                <x-website.company.sidebar />
                <div class="col-lg-9">
                    <div class="dashboard-right">
                        <div class="head pb-3">
                            <i class="fas fa-envelope me-2"></i>
                            <span class="text-capitalize fsyz">inbox</span>
                        </div>
                        <div class="line"></div>
                        <div class="slct-sec row d-flex p-2">
                            <div class="col-md-3">
                                
                            </div>
                            <div class="col-md-9 select-content">
                                <form class="">
                                    <div class="d-flex align-items-center mb-2 p-2">
                                        <div class="col-sm-3 me-2">
                                            <select name="cars" id="cars">
                                                <option value="volvo">Volvo</option>
                                                <option value="saab">Saab</option>
                                                <option value="opel">Opel</option>
                                                <option value="audi">Audi</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-1 text-center brdr-ad me-2">
                                               <i class="fas fa-sync-alt"></i>
                                       </div>
                                       <div class="col-sm-3">
                                            <select name="cars" id="cars">
                                                <option value="volvo">Volvo</option>
                                                <option value="saab">Saab</option>
                                                <option value="opel">Opel</option>
                                                <option value="audi">Audi</option>
                                           </select>
                                       </div>
                                       <div class="col-sm-5 text-right">
                                          <span class="clr-ad">1-3 of 3</span>
                                       </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                         <div class="line"></div>
                        <div class="message d-flex align-items-start">
                          <div class="col-md-3 left-content nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <button class="nav-link active" id="v-pills-log1-tab" data-bs-toggle="pill" data-bs-target="#v-pills-log1" type="button" role="tab" aria-controls="v-pills-log1" aria-selected="true">Home</button>
                            <button class="nav-link" id="v-pills-log2-tab" data-bs-toggle="pill" data-bs-target="#v-pills-log2" type="button" role="tab" aria-controls="v-pills-log2" aria-selected="false">Profile</button>
                            <button class="nav-link" id="v-pills-log3-tab" data-bs-toggle="pill" data-bs-target="#v-pills-log3" type="button" role="tab" aria-controls="v-pills-log3" aria-selected="false">Messages</button>
                            <button class="nav-link" id="v-pills-log4-tab" data-bs-toggle="pill" data-bs-target="#v-pills-log4" type="button" role="tab" aria-controls="v-pills-log4" aria-selected="false">Settings</button>
                          </div>

                          <div class="col-md-9 right-content tab-content p-2" id="v-pills-tabContent">
                            <div class="d-flex justify-content-between align-items-center tab-pane fade show active" id="v-pills-log1" role="tabpanel" aria-labelledby="v-pills-log1-tab">
                                <div class="col-md-1 text-center">
                                    <input type="checkbox" id="box1" name="box1" value="">
                                </div>
                                <div class="col-md-2 d-flex flex-column justify-content-center align-items-center">
                                   <img src="https://cdn.pixabay.com/photo/2015/04/23/22/00/tree-736885_1280.jpg">
                                   <p class="mrk mt-1 mb-0">shiva</p>
                                </div>
                               <div class="col-md-7 d-flex flex-column">
                                   <h3 class="mb-0">new car</h3>
                                   <p class="cenp text-capitalize mb-2">drive this car</p>
                               </div>
                               <div class=" col-md-2 icons d-flex flex-column align-items-center">
                                   <i class="far fa-star mb-2"></i>
                                   <i class="fas fa-trash mb-2"></i>
                                   <i class="fas fa-envelope-open mb-2"></i>
                               </div>
                            </div>
                            <div class="tab-pane fade" id="v-pills-log2" role="tabpanel" aria-labelledby="v-pills-log2-tab">bbb</div>
                            <div class="tab-pane fade" id="v-pills-log3" role="tabpanel" aria-labelledby="v-pills-log3-tab">ccc</div>
                            <div class="tab-pane fade" id="v-pills-log4" role="tabpanel" aria-labelledby="v-pills-log4-tab">ddd</div>
                          </div>
                        </div>
                    </div>

                    <!-- second section -->
                    <div class="section-2 dashboard-right">
                        <div class="head pb-3">
                            <i class="fas fa-envelope me-2"></i>
                            <span class="text-capitalize fsyz">inbox</span>
                        </div>
                        <div class="line"></div>
                        <div class="left-syd d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center p-2">
                                <i class="fas fa-user me-2"></i>
                                <p class="mb-0 head-title">contact request about <span class="c-tw">new test car</span></p>
                            </div>
                            <div class="mv-trsh d-flex">
                               <i class="far fa-star pe-2"></i>
                               <i class="fas fa-trash pe-2"></i>
                               <i class="fas fa-envelope-open pe-2"></i> 
                            </div>
                        </div>
                        <div class="line"></div>
                        <div class="d-flex align-items-start">
                              <div class="col-md-3 nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <button class="nav-link active" id="v-pills-logq-tab" data-bs-toggle="pill" data-bs-target="#v-pills-logq" type="button" role="tab" aria-controls="v-pills-logq" aria-selected="true">inbox</button>
                                <button class="nav-link" id="v-pills-logw-tab" data-bs-toggle="pill" data-bs-target="#v-pills-logw" type="button" role="tab" aria-controls="v-pills-logw" aria-selected="false">unread</button>
                                <button class="nav-link" id="v-pills-logc-tab" data-bs-toggle="pill" data-bs-target="#v-pills-logc" type="button" role="tab" aria-controls="v-pills-logc" aria-selected="false">started</button>
                                <button class="nav-link" id="v-pills-logd-tab" data-bs-toggle="pill" data-bs-target="#v-pills-logd" type="button" role="tab" aria-controls="v-pills-logd" aria-selected="false">important</button>
                              </div>

                              <div class=" col-md-9 tab-content" id="v-pills-tabContent">
                                <div class="tab-pane fade show active" id="v-pills-logq" role="tabpanel" aria-labelledby="v-pills-logq-tab">
                                    <div class="watzp-leftcon d-flex">
                                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTKRzHHirDMQU_v0RHsILVKVt2O2RzpYR_EA_wiH5XaZQiOO_SBqb_8clGzD2cNXMTFoB0&usqp=CAU">
                                        <div class="text">
                                           <h6>hi</h6> 
                                           <p class="wats-pt">jul 11th 2023 at 12.28</p>
                                        </div>
                                    </div>
                                    <div class="watzp-rightcon d-flex justify-content-end">
                                        <div class="d-flex flex-column">
                                            <h6 class="text-right chat-bubble">hii</h6>
                                            <p class="wats-pt text-right">jul 11th 2023 at 12.28</p>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="chat-box-tray">
                                            <input type="text" placeholder="Type your message here...">
                                            <i class="fas fa-paperclip material-icons me-2 "></i>
                                            <i class="fab fa-telegram-plane material-icons me-2 "></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="v-pills-logw" role="tabpanel" aria-labelledby="v-pills-logw-tab">222</div>
                                <div class="tab-pane fade" id="v-pills-logc" role="tabpanel" aria-labelledby="v-pills-logc-tab">333</div>
                                <div class="tab-pane fade" id="v-pills-logd" role="tabpanel" aria-labelledby="v-pills-logd-tab">555</div>
                              </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dashboard-footer text-center body-font-4 text-gray-500">
                <x-website.footer-copyright />
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $('.delete').on('click', function(event) {
            var form = $(this).closest("form");
            var name = $(this).data("name");
            event.preventDefault();
            swal({
                    title: `{{ __('are_you_sure_want_to_delete_this_item') }}`,
                    text: "{{ __('if_you_delete_this') }}, {{ __('it_will_be_gone_forever') }}",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                    }
                });
        });
    </script>

    <script>
        $('#status-filter').on('change', function() {
            this.submit();
        })
    </script>
@endsection
