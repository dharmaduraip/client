@extends('admin.layouts.master')
@section('title','All Categories')
@section('maincontent')
@component('components.breadcumb',['secondaryactive' => 'active'])
@slot('heading')
{{ __('Categories') }}
@endslot

@slot('menu1')
{{ __('Categories') }}
@endslot
@slot('button')
<div class="col-md-4 col-lg-4">
  <div class="widgetbar">
    @can('categories.delete')
<<<<<<< HEAD
    <button type="button" class="float-right btn btn-danger-rgba mr-2 " data-toggle="modal" data-target="#bulk_delete"><i class="feather icon-trash mr-2"></i> {{ __('Delete Selected') }}</button>
    @endcan
    @can('categories.create')
=======
    <button type="button" class="float-right btn btn-danger-rgba mr-2 multipledel" data-toggle="modal"
      data-target="#bulk_delete"><i class="feather icon-trash mr-2"></i> {{ __('Delete Selected') }}</button>
      @endcan
      @can('categories.create')
>>>>>>> 6b1098e089a059e9b1054e9f702f2fa99d3a690e
    <button type="button" class="float-right btn btn-primary-rgba mr-2" data-toggle="modal" data-target="#myModal">
      <i class="feather icon-plus mr-2"></i>{{ __('Add Category') }}</a>
      @endcan
  </div>
</div>

@endslot
@endcomponent
<div class="contentbar">
  <div class="row">

    <div class="col-lg-12">
      <div class="card m-b-30">
        <div class="card-header">
          <h5 class="card-box">{{ __('All Categories') }}</h5>
        </div>
        <div class="card-body">

          <div class="table-responsive">
            <table id="datatable-buttons" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th> <input id="checkboxAll" type="checkbox" class="filled-in" name="checked[]" value="all" />
                    <label for="checkboxAll" class="material-checkbox"></label>#
                  </th>
                  <th>{{ __('Image') }}</th>
                  <th>{{ __('Category') }}</th>
                  <th>{{ __('Icon') }}</th>
                  <th>{{ __('Slug') }}</th>
                  <th>{{ __('Featured') }}</th>
                  <th>{{ __('Status') }}</th>
                  <th>{{ __('Action') }}</th>
                </tr>
              </thead>
              <tbody id="sortable">
                <?php $i = 0; ?>
                @foreach($cate as $key => $cat)
                <?php $i++; ?>
                <tr class="sortable" id="id-{{ $cat->id }}">
                  <td> <input type='checkbox' form='bulk_delete_form' class='check filled-in material-checkbox-input' name='checked[]' value="{{ $cat->id }}" id='checkbox{{ $cat->id }}'>
                    <label for='checkbox{{ $cat->id }}' class='material-checkbox'></label>
                    <?php echo $i; ?>
                    <div id="bulk_delete" class="delete-modal modal fade" role="dialog">
                      <div class="modal-dialog modal-sm">
                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <div class="delete-icon"></div>
                          </div>
                          <div class="modal-body text-center">
                            <h4 class="modal-heading">{{ __('Are You Sure') }} ?</h4>
                            <p>{{ __('Do you really want to delete selected item names here? This process
                              cannot be undone') }}.</p>
                          </div>
                          <div class="modal-footer">
                            <form id="bulk_delete_form" method="post" action="{{ route('categories.bulk_delete') }}">
                              @csrf
                              @method('POST')
                              <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">{{ __('No') }}</button>
                              <button type="submit" class="btn btn-danger">{{ __('Yes') }}</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                  </td>
                  <td>
                    @if($cat['cat_image'] !== NULL && $cat['cat_image'] !== '')
                    <img src="images/category/<?php echo $cat['cat_image'];  ?>" class="img-responsive img-circle">
                    @else
                    <img src="{{ Avatar::create($cat->title)->toBase64() }}" class="img-responsive img-circle">
                    @endif
                  </td>
                  <td>{{$cat->title}}</td>
                  <td>
                    <div class="index-image">
                      <i class="fa {{$cat->icon}}"></i>
                    </div>
                  </td>
                  <td>{{$cat->slug}}</td>
                  <td>
                    <button type="button" class="btn btn-rounded {{ $cat->featured == '1' ?  'btn-success-rgba' : 'btn-danger-rgba' }}">
                      @if( $cat->featured)
                      {{ __('Active') }}
                      @else
                      {{ __('Deactive') }}
                      @endif
                    </button>
                  </td>
                  <td>
                    <button type="button" class="btn btn-rounded {{ $cat->status == '1' ? 'btn-success-rgba' : 'btn-danger-rgba' }}">
                      @if( $cat->status)
                      {{ __('Active') }}
                      @else
                      {{ __('Deactive') }}
                      @endif
                    </button>
                  </td>
                  <td>
                    <div class="dropdown">
                      <button class="btn btn-round btn-outline-primary" type="button" id="CustomdropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-vertical-"></i></button>
                      <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton1">
                        @can('categories.edit')
                        <a class="dropdown-item" data-toggle="modal" data-target="#edit{{$cat->id}}"><i class="feather icon-edit mr-2"></i>{{ __('Edit') }}</a>
                        @endcan
                        @can('categories.delete')
                        <a class="dropdown-item btn btn-link" data-toggle="modal" data-target="#delete{{$cat->id}}">
                          <i class="feather icon-delete mr-2"></i>{{ __("Delete") }}</a>
                        </a>
                        @endcan
                      </div>
                    </div>
                    <div class="modal fade bd-example-modal-sm popup" id="edit{{$cat->id}}" role="dialog" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleSmallModalLabel">{{ __('Edit Category') }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <form id="demo-form" method="post" action="{{url('category/'.$cat->id)}}
                                  " data-parsley-validate class="form-horizontal form-label-left" autocomplete="off" enctype="multipart/form-data">
                              {{ csrf_field() }}
                              {{ method_field('PUT') }}
                              <div class="row">
                                <div class="col-md-12">
                                  <div class="form-group">
                                    <label for="exampleInputTit1e">{{ __('Category') }}:<sup class="redstar">*</sup></label>
                                    <input type="text" class="form-control" name="title" id="exampleInputTitle" value="{{$cat->title}}" required>
                                  </div>

                                  <div class="form-group">
                                    <label for="slug">{{ __('Slug') }}:<sup class="redstar">*</sup></label>
                                    <input pattern="[/^\S*$/]+" placeholder="Please Enter slug" type="text" class="form-control" name="slug" required value="{{$cat->slug}}">
                                  </div>
                                  <div class="form-group">
                                    <label for="exampleInputTit1e">{{ __('Icon') }}:<sup class="redstar">*</sup></label>
                                    <div class="input-group">
                                      <input type="text" class="form-control iconvalue" name="icon" value="{{$cat->icon}}">
                                      <span class="input-group-append">
                                        <button type="button" class="btnicon btn btn-outline-secondary" role="iconpicker"></button>
                                      </span>
                                    </div>



                                  </div>

                                  <div class="row">
                                    <div class="form-group col-md-6">
                                      <div class="toggle_head{{ $key }}">
                                        <label for="exampleInputDetails">{{ __('Status') }}:</label><br>
                                        <input id="status" type="checkbox" class="custom_toggle stalert{{$cat->id}}" onchange="statusalert2({{$cat->id}});" {{ $cat->status == '1' ? 'checked' : '' }} name="status" />
                                      </div>
                                    </div>
                                    <div class="form-group col-md-6 ">
                                      <div class="toggle_head_featured{{ $key }}">
                                        <label for="exampleInputDetails">{{ __('Featured') }}:</label><br>
                                        <input id="featured" type="checkbox" class="custom_toggle_featured" {{ $cat->featured == '1' ? 'checked' : '' }} name="featured" />
                                      </div>
                                    </div>
                                  </div>

                                  <div class="form-group">
<<<<<<< HEAD
                                    <label>{{ __('PreviewImage') }}:</label> - <p class="inline info">{{ __('size') }}: 255x200</p>
                                    <br>
                                    <label>{{ __('Image') }}:<sup class="redstar">*</sup></label>
=======
                                  <label>{{ __('Preview Image') }}:</label> - <p class="inline info">{{ __('size') }}: 255x200</p>
                                  <br>
                                     <label>{{ __('Image') }}:<sup class="redstar">*</sup></label>
>>>>>>> 6b1098e089a059e9b1054e9f702f2fa99d3a690e
                                    <small class="text-muted"><i class="fa fa-question-circle"></i> {{ __('Recommendedsize') }} (1375 x 409px)</small>
                                    <div class="input-group mb-3">
                                      <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
                                      </div>
                                      <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="inputGroupFile01" name="image" aria-describedby="inputGroupFileAddon01" accept=".jpg,.png,.jpeg">
                                        <label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
                                      </div>
                                    </div>

                                    @if(isset($cat['cat_image']))
                                    <img src="{{ url('/images/category/'.$cat['cat_image']) }}" class="image_size" />
                                    @endif
                                  </div>
                                  @if($errors->has('image'))
                                  <p class="error-msg" style="color:red">{{$errors->first('image')}}</p>
                                  @endif
                                </div>

                              </div>
                              <div class="form-group">
                                {{-- <button type="reset" class="btn btn-danger-rgba"><i class="fa fa-ban"></i>
                                  {{ __('Reset') }}</button> --}}
                                <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                                  {{ __('Update') }}</button>

                              </div>
                              <div class="clear-both"></div>
                          </div>
                        </div>

                        </form>
                      </div>
                    </div>

          </div>
        </div>
      </div>

      <div class="modal fade bd-example-modal-sm popup" id="delete{{$cat->id}}" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleSmallModalLabel">{{ __('Delete') }}</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p class="text-muted">{{ __('Do you really want to delete this item ? This process cannot be
                undone') }}.</p>
            </div>
            <div class="modal-footer">
              <form method="post" action="{{url('category/'.$cat->id)}}" data-parsley-validate class="form-horizontal form-label-left">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}

                <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">{{ __('No') }}</button>
                <button type="submit" class="btn btn-danger">{{ __('Yes') }}</button>
              </form>
            </div>
          </div>
        </div>
      </div>


      </td>

      </tr>
      @endforeach
      </tbody>
      </tbody>
      </table>
    </div>
  </div>
</div>
</div>
<!-- End col -->
</div>
<!-- End row -->
</div>
<div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModal">{{ __('Add Category') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

      </div>
      <div class="modal-body">
        <form id="demo-form2" method="post" action="{{url('category/')}}" data-parsley-validate class="form-horizontal form-label-left" autocomplete="off" enctype="multipart/form-data">
          {{ csrf_field() }}

          <div class="row">
            <div class="col-md-12">
              <label for="c_name">{{ __('Name') }}:<sup class="redstar">*</sup></label>
              <input placeholder=" Please Enter Category name" type="text" class="form-control" name="title" required value="{{old('title')}}">
            </div>
          </div>
          <br>

          <div class="row">
            <div class="col-md-12">
              <label for="slug">{{ __('Slug') }}:<sup class="redstar">*</sup></label>
              <input pattern="[/^\S*$/]+" placeholder="Please Enter slug" type="text" class="form-control" name="slug" value="{{old('slug')}}" required>
            </div>
          </div>
          <br>


          <div class="row">
            <div class="col-md-12">
              <label for="icon">{{ __('Icon') }}:<sup class="redstar"></sup></label>

              <!--========================================================================-->
              <div class="input-group">
                <input type="text" class="form-control iconvalue" name="icon" value="Please Choose icon">
                <span class="input-group-append">
                  <button type="button" class="btnicon btn btn-outline-secondary" role="iconpicker"></button>
                </span>
              </div>
              <!--========================================================================-->



            </div>
          </div>
          <br>

          <div class="row">
            <div class="col-md-4">
              <label for="exampleInputDetails">{{ __('Featured') }}:</label><br>
              <input id="status_toggle" type="checkbox" class="custom_toggle_add" name="featured" {{ old('featured') == 'on' ? 'checked' : '' }} />
            </div>

            <div class="col-md-4">
              <label for="exampleInputDetails">{{ __('Status') }}:</label><br>
              <input id="status_toggle" type="checkbox" class="custom_toggle_add" name="status" checked />
            </div>

          </div>
          <br>


          <div class="form-group">
            <label>{{ __('Preview Image') }}:</label> - <p class="inline info">{{ __('size') }}: 255x200</p>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
              </div>
              <div class="custom-file">
                <input type="file" name="image" class="custom-file-input" id="image" aria-describedby="inputGroupFileAddon01" accept=".jpg,.png,.jpeg">
                <label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
              </div>
            </div>


            @if($errors->has('image'))
            <p class="error-msg" style="color:red">{{$errors->first('image')}}</p>
            @endif

          </div>


          <div class="form-group">
            {{-- <button type="reset" id="reset" class="btn btn-danger"><i class="fa fa-ban"></i> {{ __('Reset') }}</button> --}}
            <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
              {{ __('Create') }}</button>
          </div>
          <div class="clear-both"></div>
        </form>
      </div>
    </div>
  </div>
</div>


@endsection

@section('script')

<script type="text/javascript">
  $(document).ready(function() {
    var success_multicolor_on_off = document.querySelectorAll('.custom_toggle_add');
    $(success_multicolor_on_off).map(function(index, val) {
      var switchery = new Switchery(val, {
        color: '#43D187',
        secondaryColor: '#F9616D',
        jackColor: '#A5ECC4',
        jackSecondaryColor: '#FFE4E6'
      });
    });

    $(document).on("click", ".paginate_button.page-item", function() {

      var success_multicolor_on_off = document.querySelectorAll('.custom_toggle');
      var success_multicolor_on_off_featured = document.querySelectorAll('.custom_toggle_featured');
      var active_page = $(".paginate_button.page-item.active").find("a").text();
      if (active_page != "1") {
        var row = (active_page - 1) * 10;
        $(success_multicolor_on_off).map(function(index, val) {
          var newindex = row + index;
          if ($(".toggle_head" + newindex).find("span").attr('class') != "switchery switchery-default") {
            var switchery = new Switchery(val, {
              color: '#43D187',
              secondaryColor: '#F9616D',
              jackColor: '#A5ECC4',
              jackSecondaryColor: '#FFE4E6'
            });
          }

        });

        $(success_multicolor_on_off_featured).map(function(index, val) {
          var newindex = row + index;
          if ($(".toggle_head_featured" + newindex).find("span").attr('class') != "switchery switchery-default") {
            var switchery = new Switchery(val, {
              color: '#43D187',
              secondaryColor: '#F9616D',
              jackColor: '#A5ECC4',
              jackSecondaryColor: '#FFE4E6'
            });
          }
        });
      }
    });
  });

  // status change alert message start
  function statusalert2(id) {
    if ($(".stalert" + id).prop("checked") != true) {
      $.ajax({
        type: "GET",
        url: "{{ route('category.status.alert') }}",
        data: {
          'cat_id': id
        },
        success: function(data) {
          if (data.msg == "active") {
            alert("You can't change this status. because, This category already used in some course.");
            $(".stalert" + id).trigger("click");
          } else {
            return true;
          }
        }
      });
    }

  }
  // status change alert message end 
</script>


<script type="text/javascript">
  $(function() {
    $("#sortable").sortable();
    $("#sortable").disableSelection();
  });

  $("#sortable").sortable({
    update: function(e, u) {
      var data = $(this).sortable('serialize');

      $.ajax({
        url: "{{ route('category_reposition') }}",
        type: 'get',
        data: data,
        dataType: 'json',
        success: function(result) {
          console.log(data);
        }
      });

    }

  });
</script>
<script>
  $("#checkboxAll").on('click', function() {
    $('input.check').not(this).prop('checked', this.checked);
  });
  $(".multipledel").click(function(){
     
     var count = $('[name="checked[]"]:checked').length;
     if(count == "0")
     {
         alert("Atleast One Category is required to be selected");
         return false;
     }
     
 });
</script>

<!-- script to change featured-status start -->
<script>
  $(document).ready(function() {
    var popup_code = {
      !!session('error_code') ? session('error_code') : 0!!
    }
    var id = {
      !!session('cat_id') ? session('cat_id') : 0!!
    }
    if (popup_code == 4) {
      $('#myModal').modal('show');
    }
    if (popup_code == 3) {
      $('#edit' + id).modal('show');
    }
  });

  $(document).on("change", ".status1", function() {
    $.ajax({
      type: "GET",
      dataType: "json",
      url: 'featured-status',
      data: {
        'featured': $(this).is(':checked') ? 1 : 0,
        'id': $(this).data('id')
      },
      success: function(data) {
        console.log(id)
      }
    });

  });
</script>
<!-- script to change featured-status end -->
<!-- script to change status start -->
<script>
  $(document).on("change", ".status2", function() {
    $.ajax({
      type: "GET",
      dataType: "json",
      url: 'cat-status',
      data: {
        'status': $(this).is(':checked') ? 1 : 0,
        'id': $(this).data('id')
      },
      success: function(data) {
        var warning = new PNotify({
          title: 'success',
          text: 'Status Update Successfully',
          type: 'success',
          desktop: {
            desktop: true,
            icon: 'feather icon-thumbs-down'
          }
        });
        warning.get().click(function() {
          warning.remove();
        });
      }
    });
  });
</script>
<!-- script to change status end -->
<!-- ============================================ -->


@endsection