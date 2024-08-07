@extends('common.provider.layout.base')
@section('styles')
@parent
<link rel="stylesheet"  type='text/css' href="{{ asset('assets/plugins/cropper/css/cropper.css')}}" />
<style>
.upload-btn {
    /*height: 150px !important;*/
}
</style>
@stop
@section('content')
@include('common.admin.includes.image-modal')
<section class="z-1 content-box" id="profile-form"> 
         <div class="profile-section">
            <div class="dis-center col-md-12 p-0 dis-center">
               <ul class="nav nav-tabs" role="tablist">
               <li class="nav-item">
                     <a class="nav-link active tabs all  ALL" data-value="all" data-toggle="tab" href="#all" role="tab" data-toggle="tab">@lang('provider.general')</a>
                  </li>
                 
               </ul>
            </div>
            <div class="clearfix tab-content">
              
                <h5 style="color: red" id="mynote">@lang('provider.document_note')</h5>
               
               <div role="tabpanel" class="tab-pane  col-sm-12 col-md-12 col-lg-12 p-0" id="TRANSPORT">
                  <div class="col-md-12 p-0">
                     <div class="profile-content">
                        <div class="row m-0">
                           <form class="w-100">
                             <div id="transport"></div>
                            </form>
                        </div>
                     </div>
                  </div>
               </div>
               <div role="tabpanel" class="tab-pane col-sm-12 col-md-12 col-lg-12 p-0  min-46vh" id="ORDER">
                  <div class="col-md-12 p-0">
                     <div class="profile-content">
                        <div class="row m-0">
                           <form class="w-100">
                           <div id="order"></div>
                            </form>
                        </div>
                     </div>
                  </div>
               </div>
               <div role="tabpanel" class="tab-pane col-sm-12 col-md-12 col-lg-12 p-0" id="SERVICE">
                  <div class="col-md-12 p-0">
                     <div class="profile-content">
                        <div class="row m-0">
                           <form class="w-100">
                           <div id="service"></div>
                            </form>
                        </div>
                     </div>
                  </div>
                </div>
                <div role="tabpanel" class="tab-pane col-sm-12 col-md-12 col-lg-12 p-0" id="DELIVERY">
                  <div class="col-md-12 p-0">
                     <div class="profile-content">
                        <div class="row m-0">
                           <form class="w-100">
                           <div id="courier"></div>
                            </form>
                        </div>
                     </div>
                  </div>
                </div>

               <div role="tabpanel" class="tab-pane active col-sm-12 col-md-12 col-lg-12 p-0" id="all">
                  <div class="col-md-12 p-0">
                     <div class="profile-content">
                        <div class="row m-0">
                           <form class="w-100">
                           <div id="all"></div>
                            </form>
                        </div>
                     </div>
                  </div>
                
               </div>
            </div>
         </div>
      </section>
@stop
@section('scripts')
@parent
<script src="{{ asset('assets/plugins/cropper/js/cropper.js')}}" > </script>  
<script src="{{ asset('assets/layout/js/crop.js')}}" > </script> 
<script>

   $('body').on('change', '.picture_upload', function(e) {
      var files = e.target.files;
      var obj = $(this);
      if (files && files.length > 0) {
        blobName = files[0].name;
         cropImage(obj, files[0], obj.closest('.image-placeholder').find('img'), function(data) {
            var placeholder = obj.closest('.image-placeholder');

            var reader = new FileReader();
            reader.readAsDataURL(data); // converts the blob to base64 and calls onload

            reader.onload = function() {
               placeholder.find('textarea').val(reader.result);
            };
            
            placeholder.find('input[name=file_name]').val(blobName);
         });
      }
    });

    $.ajax({
        url: getBaseUrl() + "/provider/adminservices",
        type: "get",
        async: false,
        headers: {
            Authorization: "Bearer " + getToken("provider")
        },
        success: (data, textStatus, jqXHR) => {
            var response = data.responseData;
            var html = ``;
            for (var i in response) {
                if (response[i].providerservices) {
                    html += `<li class="nav-item">
                     <a class="nav-link  tabs ` + response[i].admin_service + `" data-value="` + response[i].admin_service + `" data-toggle="tab" href="#` + response[i].admin_service + `" role="tab" data-toggle="tab">` + response[i].admin_service + `</a>
                  </li>`;
                }
            }
            $('.nav-tabs').append(html);
        },
        error: (jqXHR, textStatus, errorThrown) => {
            alertMessage(textStatus, jqXHR.responseJSON.message, "danger");
        }
    });

   $('.tabs').click(function() {
      var tabvalue = $(this).data('value');
      documentslist(tabvalue);
   })

   function documentslist(type) {
    $.ajax({
        url: getBaseUrl() + "/provider/listdocuments",
        type: "post",
        data: {
            type: type
        },
        headers: {
            Authorization: "Bearer " + getToken("provider")
        },
        'beforeSend': function(request) {
            showInlineLoader();
            
        },
        success: (data, textStatus, jqXHR) => { 
            var response = data.responseData;
            if(response.length >0){
              $('#mynote').show();
            }else{
              $('#mynote').hide();
            }
            var html = `<div class="col-md-12 col-sm-12 ">`;
            for (var i in response) {
                var image = "";
                var backendImage = "";
                var date = "";
                var button = ``;
                if (response[i].provider_document) {
                    if (response[i].file_type == "image") {
                        image = `<img class ='img-fluid' src =` + response[i].provider_document.url['0'].url + ` style=''> `;
                    } else {
                        image = `<a  target="blank" href=` + response[i].provider_document.url['0'].url + `><img class="pdf" style="width:100px" src="{{ asset('assets/layout/images/common/svg/pdf-file.svg') }}" alt="add_document"><div class="fileUpload up-btn profile-up-btn"><div data-name="front"></div></div></a>`;
                    }
                } else {
                    if (response[i].file_type == "image") {
                        image = `<div class="image-placeholder w-100">
                            <img width="100" height="100" />
                            <textarea style="display:none"></textarea>
                            <input type='hidden' name='file_name' value="">
                            <input type="file" name="picture" class="upload-btn picture_upload"  accept="image/x-png,image/gif,image/jpeg" >
                       <input type='hidden' class='document_length' value=""></div>`;
                    } else {

                        image = `<img class="pdf" src="{{ asset('assets/layout/images/common/svg/pdf.svg') }}" alt="add_document"><div class="fileUpload up-btn profile-up-btn"><input type="file" id="profile_img_upload_btn" class="upload"   accept="application/pdf"></div>`;
                    }
                }

                if (response[i].provider_document) {

                    if (response[i].is_backside == 1) {

                        backendImage = ` <div class="col-sm-12 col-md-4 col-xl-4 pl-0  mt-2"> <div class="c-pointer"> <div class="add-document w-100">`;
                        if (response[i].file_type == "image") {
                            backendImage += `<img class ='img-fluid' src =` + response[i].provider_document.url['1'].url + ` style=''>`;
                        } else {
                            backendImage += `<a  target="blank" href=` + response[i].provider_document.url['1'].url + `><img class="pdf" style="width:100px" src="{{ asset('assets/layout/images/common/svg/pdf-file.svg') }}" alt="add_document"><div class="fileUpload up-btn profile-up-btn"><div data-name="front"></div></div></a>`;
                        }
                        backendImage += `</div><div><h5 class="p-0 text-center"><strong>Back</strong></h5></div></div></div>`;
                    } else {
                        backendImage = `<div class="col-sm-12 col-md-4 col-xl-4 pl-0  mt-2"> <div class="c-pointer"> <div class="add-document w-100"></div> <div><h5 class="p-0 text-center"><strong>No Back Image</strong></h5></div> </div></div>`;
                    }


                } else {

                    if (response[i].is_backside == 1) {
                        backendImage = ` <div class="col-sm-12 col-md-4 col-xl-4 pl-0  mt-2"> <div class="c-pointer"> <div class="add-document w-100"> <input type='hidden' class='is_backside' value="1"> `;
                        if (response[i].file_type == "image") {
                            backendImage += `<div data-name="back" class="image-placeholder w-100"> <img width="100" height="100" /> <textarea style="display:none"></textarea> <input type='hidden' name='file_name' value=""> <input type="file" name="picture" class="upload-btn picture_upload"   accept="image/x-png,image/gif,image/jpeg" > </div>`;
                        } else {
                            backendImage += `<img class="pdf" src="{{ asset('assets/layout/images/common/svg/pdf.svg') }}" alt="add_document"><div class="fileUpload up-btn profile-up-btn"><input type="file" name="front" accept="application/pdf"/></div>`;
                        }
                        backendImage += `</div><div><h5 class="p-0 text-center"><strong>Back</strong></h5></div></div></div>`;
                    } else {
                        backendImage = ` <div class="col-sm-12 col-md-4 col-xl-4 pl-0  mt-2"> <div class="c-pointer"> <div class="add-document w-100"></div> <div><h5 class="p-0 text-center"><strong>No Back Image</strong></h5></div> </div></div>`;
                    }
                }

                if (response[i].provider_document) {
                    date = `<div class="col-sm-12 col-md-4 col-xl-4 pl-0  mt-2 "> <h5 class=" no-padding"><strong>Expiry date</strong></h5> <input class="form-control" type="date" name="expires_at" id="expires_at" placeholder="Expiry Date" value = ` + response[i].provider_document.expires_at + `required onkeypress="return false" onkeypress="return false">`;
                    if (response[i].file_type == "image") {
                        button = `<a class="btn btn-danger  edit-profile mt-2 delete_image" data-type='` + response[i].type + `' data-id =` + response[i].provider_document.id + ` >Delete <i class="fa fa-trash" aria-hidden="true"></i></a></div>`;
                    } else {
                        button = `<a class="btn btn-danger  edit-profile mt-2 delete_pdf" data-type='` + response[i].type + `' data-id =` + response[i].provider_document.id + ` >Delete <i class="fa fa-trash" aria-hidden="true"></i></a></div>`;
                    }
                } else {
                    date = `<div class="col-sm-12 col-md-4 col-xl-4 pl-0  mt-2"> <h5 class=" no-padding"><strong>Expiry date</strong></h5> <input class="form-control" type="date" name="expires_at" id="expires_at" placeholder="" onkeypress="return false">`;
                    if (response[i].file_type == "image") {
                        button = `<a class="btn btn-primary edit-profile mt-2  upload_image" data-type='` + response[i].type + `' >Save <i class="fa fa-check" aria-hidden="true"></i></a></div>`;
                    } else {
                        button = `<a class="btn btn-primary edit-profile mt-2  upload_pdf" data-type='` + response[i].type + `' >Save <i class="fa fa-check" aria-hidden="true"></i></a></div>`;
                    }
                }

                html += `<h6><strong>Upload ` + response[i].name + `</strong></h6>
                    <p>You can upload  ` + response[i].file_type + `</p>
                    <div class="col-sm-12 col-md-12 col-lg-12 p-0 document-upload uploader">
                    <input type="hidden" name="document_id" value="` + response[i].id + `" />
                    <div class="col-sm-12 col-md-4 col-xl-4 pl-0  mt-2">
                    <div class="c-pointer"> <div class="add-document w-100"> ` + image + ` </div> <div><h5 class="p-0 text-center"><strong>Front</strong></h5></div> </div> </div>

                      ` + backendImage + `
                      ` + date + `
                      ` + button;


                html += `</div></div>`;
            }
            html += `</div>`;
            $('#' + type).html(html);

            hideInlineLoader();
        }
    });
}

$('body').on('click', '.upload_image', function() {
    var type = $(this).data('type');
    var is_backside = $(this).closest('.uploader').find('.is_backside').val();
    var image = $(this).closest('.uploader').find('textarea').length;
    if (is_backside != undefined && image != 2) {
        alertMessage('error', 'Upload Front and Back Image', "danger");
        return false;
    }

    var data = new FormData();
    data.append(`expires_at`, $(this).closest('.uploader').find('input[name=expires_at]').val());
    data.append(`document_id`, $(this).closest('.uploader').find('input[name=document_id]').val());

    $(this).closest('.uploader').find('textarea').each(function(i) {
        if($(this).val() != "") data.append(`file[` + i + `]`,  blobToFile(($(this).val()).replace(/data:image\/png;base64,/g, ''), $(this).parent().find('input[name=file_name]').val(), "image/png"),  $(this).parent().find('input[name=file_name]').val());
        //data.append(`file[` + i + `]`, blobToFile(($(this).val()).replace(/data:image\/png;base64,/g, ''), $(this).attr('name') + ".png", "image/png"));
    });

    upload(data, type);
});

$('body').on('click', '.upload_pdf', function() {
    var type = $(this).data('type');
    var is_backside = $(this).closest('.uploader').find('.is_backside').val();
    var pdf = 0;
    var data = new FormData();
    data.append(`expires_at`, $(this).closest('.uploader').find('input[name=expires_at]').val());
    data.append(`document_id`, $(this).closest('.uploader').find('input[name=document_id]').val());

    $(this).closest('.uploader').find('input[type="file"]').each(function(i) {
        if ($(this)[0].files.length > 0) {
            data.append(`file[` + i + `]`, $(this)[0].files[0]);
            pdf++;
        }
    });
    if (is_backside != undefined && pdf != 2) {
        alertMessage('error', 'Upload Front and Back PDF', "danger");
        return false;
    }
    upload(data, type);
});


//Delete the record detail
$('body').on('click', '.delete_image', function() {
    var id = $(this).data('id');
    var type = $(this).data('type');
    var result = confirm("Are You sure Want to delete?");
    $.ajax({
        type: "Delete",
        url: getBaseUrl() + "/provider/providerdocument/" + id,
        headers: {
            Authorization: "Bearer " + getToken("provider")
        },
        'beforeSend': function(request) {
            showInlineLoader();
        },
        success: function(data) {
            var result = data.responseData;
            var data = parseData(data).responseData;
            alertMessage("Success", "Deleted Successfully", "success");
            var providerdata = localStorage.getItem('provider');
            providerdata = JSON.parse(decodeHTMLEntities(providerdata));
            providerdata.is_document = 0;
            localStorage.setItem("provider", JSON.stringify(providerdata));
            setTimeout(function() {
                window.location.replace('/provider/document/' + type);
            }, 1000);
        }
    });
});
$('body').on('click', '.delete_pdf', function() {
    var id = $(this).data('id');
    var type = $(this).data('type');
    var result = confirm("Are You sure Want to delete?");
    $.ajax({
        type: "Delete",
        url: getBaseUrl() + "/provider/providerdocument/" + id,
        headers: {
            Authorization: "Bearer " + getToken("provider")
        },
        'beforeSend': function(request) {
            showInlineLoader();
        },
        success: function(data) {
            var result = data.responseData;
            var data = parseData(data).responseData;
            alertMessage("Success", "Deleted Successfully", "success");
            var providerdata = localStorage.getItem('provider');
            providerdata = JSON.parse(decodeHTMLEntities(providerdata));
            providerdata.is_document = 0;
            localStorage.setItem("provider", JSON.stringify(providerdata));
            setTimeout(function() {
                window.location.replace('/provider/document/' + type);
            }, 1000);

        }
    });

});

function upload(data, type) {
    $.ajax({
        url: getBaseUrl() + "/provider/documents",
        type: "post",
        data: data,
        headers: {
            Authorization: "Bearer " + getToken("provider")
        },
        beforeSend: function(request) {
            showLoader();
        },
        processData: false,
        contentType: false,
        success: function(response, textStatus, jqXHR) {
            var data = parseData(response).responseData;
            alertMessage("Success", "Created Successfully", "success");
            var providerdata = localStorage.getItem('provider');
            providerdata = JSON.parse(decodeHTMLEntities(providerdata));
            providerdata.is_document = data.is_document;
            localStorage.setItem("provider", JSON.stringify(providerdata));
            setTimeout(function() {
                window.location.replace('/provider/document/' + type);
            }, 1000);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alertMessage('error', jqXHR.responseJSON.message, "danger");
            hideLoader();
        }
    });
}
$('body').on('click', '#expires_at', function() {
    var today = new Date().toISOString().split('T')[0];
    document.getElementsByName("expires_at")[0].setAttribute('min', today);

});


documentslist('all');
$('.' + "{{$type}}").trigger('click');

function blobToFile(base64Data, tempfilename, contentType) {
       contentType = contentType || '';
       var sliceSize = 1024;
       var byteCharacters = atob(base64Data);
       var bytesLength = byteCharacters.length;
       var slicesCount = Math.ceil(bytesLength / sliceSize);
       var byteArrays = new Array(slicesCount);
   
       for (var sliceIndex = 0; sliceIndex < slicesCount; ++sliceIndex) {
           var begin = sliceIndex * sliceSize;
           var end = Math.min(begin + sliceSize, bytesLength);
   
           var bytes = new Array(end - begin);
           for (var offset = begin, i = 0 ; offset < end; ++i, ++offset) {
               bytes[i] = byteCharacters[offset].charCodeAt(0);
           }
           byteArrays[sliceIndex] = new Uint8Array(bytes);
       }
       var file = new File(byteArrays, tempfilename, { type: contentType });
       return file;
   }

</script>
@stop