@extends('admin.layouts.master')
@section('title','Edit Quiz')
@section('maincontent')
   @component('components.breadcumb',['secondaryactive' => 'active'])
      @slot('heading')
         {{ __('Quiz') }}
      @endslot

      @slot('menu1')
         {{ __('Edit Quiz') }}
      @endslot
   
      @slot('button')
      <div class="col-md-4 col-lg-4">
         <div class="widgetbar">
            <a href="{{ url('admin/questions/'.$topic->id) }}" class="float-right btn btn-primary-rgba mr-2"><i class="feather icon-arrow-left mr-2"></i>{{ __('Back') }}</a>
         </div>
      </div>

      @endslot
   @endcomponent
   <div class="contentbar" > 
      <div class="row">
         <div class="col-lg-12 " style="margin-bottom: 30px;" >
            <div class="card p-5">   
                <form id="demo-form2" method="POST" action="{{route('questions.update', $quiz->id)}}"
                  data-parsley-validate class="form-horizontal form-label-left"
                  enctype="multipart/form-data">
                  {{ csrf_field() }}
                  {{ method_field('PUT') }}

                    <input type="hidden" name="course_id" value="{{ $topic->course_id }}" />

                    <input type="hidden" name="topic_id" value="{{ $topic->id }}" />
                    <div class="row">
                        <div class="col-md-6">
                            <div class="col-md-12">
                                <label for="exampleInputTit1e">{{ __('Question') }}</label>
                                <textarea name="question" rows="6" class="form-control"
                                placeholder="Enter Your Question">{{ $quiz->question }}</textarea required>
                                <br>
                            </div>
                            <div class="col-md-12">
                                <label for="exampleInputDetails">{{ __('Answer') }}:<sup
                                  class="redstar">*</sup></label>
                                <select style="width: 100%" name="answer"
                                  class="form-control select2" id="anskey">
                                  <option {{ $quiz->answer == 'A' ? 'selected' : ''}} value="A">
                                    {{ __('A') }}</option>
                                  <option {{ $quiz->answer == 'B' ? 'selected' : ''}} value="B">
                                    {{ __('B') }}</option>
                                  @if($quiz->c != NULL && $quiz->c != '')
                                      <option {{ $quiz->answer == 'C' ? 'selected' : ''}} value="C" id="op1">
                                        {{ __('C') }}</option>
                                  @endif
                                  @if($quiz->d != NULL && $quiz->d != '')
                                      <option {{ $quiz->answer == 'D' ? 'selected' : ''}} value="D" id="op2">
                                        {{ __('D') }}</option>
                                  @endif
                                  @if($quiz->e != NULL && $quiz->e != '')
                                      <option {{ $quiz->answer == 'E' ? 'selected' : ''}} value="E" id="op3">
                                        {{ __('E') }}</option>
                                  @endif
                                </select> 
                            </div>
                            <br>
                            <h4 class="extras-heading">{{ __('Video And Image For Question') }}</h4>
                            <div class="form-group{{ $errors->has('question_video_link') ? ' has-error' : '' }}">
                                <label for="exampleInputDetails">{{ __('Add Video To Question') }} :<sup class="redstar">*</sup></label>
                                <input type="text" name="question_video_link" class="form-control"
                                  placeholder="https://myvideolink.com/embed/.." / value="{{ $quiz->question_video_link }}">
                                <small class="text-danger">{{ $errors->first('question_video_link') }}</small>
                                <small class="text-muted text-info"> <i class="text-dark feather icon-help-circle"></i> {{ __('YouTube And Vimeo Video Support (Only Embed Code Link)') }}</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-12">

                              <label for="exampleInputDetails">{{ __('A Option') }} :<sup
                                  class="redstar">*</sup></label>
                              <input type="text" name="a" value="{{ $quiz->a }}" class="form-control"
                                placeholder="Enter Option A" required>
                            </div>

                            <div class="col-md-12">
                                  <label for="exampleInputDetails">{{ __('B Option') }} :<sup
                                      class="redstar">*</sup></label>
                                  <div class="d-flex justify-content-between">
                                        <input type="text" name="b" value="{{ $quiz->b }}" class="form-control" placeholder="Enter Option B" required>

                                      <button type="button" class="edaddnew btn-primary-rgba btn-sm" onclick="editaddnew({{$quiz->anscnt}})" @if($quiz->anscnt == 3) style="display: none;" @endif >
                                          <i class="feather icon-plus"></i>
                                      </button>
                                  </div>
                            </div>
                       
                              @if( $quiz->c != NULL && $quiz->c != '') 
                                  <div class="col-md-12 deledc">
  
                                        <label for="exampleInputDetails">{{ __('C Option') }} :<sup
                                            class="redstar">*</sup></label>
                                        <div class="d-flex justify-content-between">
                                            <input type="text" name="c" value="{{ $quiz->c }}" class="form-control"
                                            placeholder="Enter Option C" required>

                                            @if($quiz->anscnt == 1 && $quiz->anscnt != 2 && $quiz->anscnt != 3)
                                                <button type="button"  class="editremoveBtn1 btn-danger-rgba btn-sm" onclick="editremoveopt(1)">
                                                    <i class="feather icon-trash"></i>
                                                </button>
                                            @else
                                                <button type="button"  class="editremoveBtn1 btn-danger-rgba btn-sm" onclick="editremoveopt(1)" style="display:none">
                                                    <i class="feather icon-trash"></i>
                                                </button>
                                            @endif
                                        </div>
                                  </div>
                              @endif

                              @if( $quiz->d != NULL && $quiz->d != '')
                                  <div class="col-md-12 deledd">
  
                                      <label for="exampleInputDetails">{{ __('D Option') }} :<sup
                                          class="redstar">*</sup></label>
                                      <div class="d-flex justify-content-between">
                                          <input type="text" name="d" value="{{ $quiz->d }}" class="form-control"
                                            placeholder="Enter Option D" required>
                                          @if($quiz->anscnt == 2 && $quiz->anscnt != 1 && $quiz->anscnt != 3)
                                              <button type="button"  class="editremoveBtn2 btn-danger-rgba btn-sm" onclick="editremoveopt(2)">
                                                  <i class="feather icon-trash"></i>
                                              </button>
                                          @else
                                              <button type="button"  class="editremoveBtn2 btn-danger-rgba btn-sm" onclick="editremoveopt(2)" style="display:none;">
                                                    <i class="feather icon-trash"></i>
                                                </button>
                                          @endif
                                      </div>
                                  </div>
                              @endif

                              @if( $quiz->e != NULL && $quiz->e != '')
                                  <div class="col-md-12 delede">
  
                                    <label for="exampleInputDetails">{{ __('E Option') }} :<sup
                                        class="redstar">*</sup></label>
                                    <div class="d-flex justify-content-between">
                                        <input type="text" name="e" value="{{ $quiz->e }}" class="form-control"
                                          placeholder="Enter Option E" required>
                                        @if($quiz->anscnt == 3 && $quiz->anscnt != 1 && $quiz->anscnt != 2)
                                              <button type="button"  class="editremoveBtn3 btn-danger-rgba btn-sm" onclick="editremoveopt(3)">
                                                  <i class="feather icon-trash"></i>
                                              </button>
                                        @endif
                                    </div>
                                  </div>
                              @endif
                              <div id="editdynopt" class="new-insert">
                              </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label class="text-dark" for="exampleInputSlug">{{ __('Image') }}: </label>
                
                            <div class="input-group mb-3">
                      
                                <div class="input-group-prepend">
                                  <span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
                                </div>
                
                
                                <div class="custom-file">
                        
                                    <input type="file" name="question_img" class="custom-file-input" id="question_img"
                                      aria-describedby="inputGroupFileAddon01" accept=".jpg,.jpeg,.png">
                                    <label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
                                </div>

                            </div>
                           <img src="{{ url('/images/quiz/'.$quiz->question_img) }}" alt="image" style="width:100px;height: 100px;">
                        </div>
                    </div>
                    
                    <input type="hidden" name="editanscnt" id="editanswercnt" value="check" class="editanswercnt">
                
                    <div class="form-group">
                      <a href="javascript:window.location.reload(true)" class="btn btn-danger-rgba"><i class="fa fa-ban"></i>
                        {{ __('Reset') }}</a>
                      <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                        {{ __('Update') }}</button>
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
  function editaddnew(edanscnt)
  {
      var cont = $("#editanswercnt").val();
      if(cont == "check")
      {
         var ansval = edanscnt;
      }
      else
      {
         var ansval = parseInt($('#editanswercnt').val());
      }
      if(ansval == "2")
      {
          $(".new-insert").append(`
              <div class="col-md-12 edansop3" id="edansop3">
                <label for="exampleInputDetails">{{ __('E Option') }} :<sup
                    class="redstar">*</sup></label>
                <div class="d-flex justify-content-between">
                    <input type="text" name="e"  class="form-control"
                      placeholder="Enter Option E" required>
                      <button type="button"  class="editremoveBtne btn-danger-rgba btn-sm" onclick="edremoveopt(3)">
                          <i class="feather icon-trash"></i>
                      </button>
                </div>
              </div>
          `);
          $(".editremoveBtn2").hide();
          $(".editanswercnt").val(ansval+1);
          $(".edaddnew").hide();
          $(".editremoveBtnd").hide();
          $("#anskey").append('<option value="E" id="op3">{{ __("E") }}</option>');
      }
      else if(ansval == "1")
      {
          $(".new-insert").append(`
              <div class="col-md-12 edansop2" id="edansop2">
                <label for="exampleInputDetails">{{ __('D Option') }} :<sup
                    class="redstar">*</sup></label>
                <div class="d-flex justify-content-between">
                    <input type="text" name="d"  class="form-control"
                      placeholder="Enter Option D" required>
                      <button type="button"  class="editremoveBtnd btn-danger-rgba btn-sm" onclick="edremoveopt(2)">
                          <i class="feather icon-trash"></i>
                      </button>
                </div>
              </div>
          `);
        $(".editremoveBtn1").hide();
        $(".editanswercnt").val(ansval+1);
        $(".editremoveBtnc").hide();
        $("#anskey").append('<option value="D" id="op2">{{ __("D") }}</option>');
      }
      else if(ansval == "0")
      {
          $(".new-insert").append(`
              <div class="col-md-12 edansop1" id="edansop1">
                <label for="exampleInputDetails">{{ __('C Option') }} :<sup
                    class="redstar">*</sup></label>
                <div class="d-flex justify-content-between">
                    <input type="text" name="c"  class="form-control"
                      placeholder="Enter Option C" required>
                      <button type="button"  class="editremoveBtnc btn-danger-rgba btn-sm" onclick="edremoveopt(1)">
                          <i class="feather icon-trash"></i>
                      </button>
                </div>
              </div>
          `);
          $(".editanswercnt").val(ansval+1);
          $("#anskey").append('<option value="C" id="op1">{{ __("C") }}</option>');
      }
  }

  function editremoveopt(id)
  {
      if(id == "3")
      {
          $(".delede").remove();
          $(".editanswercnt").val(id-1);
          $(".editremoveBtn2").show();
          $(".edaddnew").show();
          $("#op"+id).remove();
      }
      else if(id == "2")
      {
          $(".deledd").remove();
          $(".editanswercnt").val(id-1);
          $(".editremoveBtn1").show();
          $("#op"+id).remove();
      }
      else if(id == "1")
      {
          $(".deledc").remove();
          $(".editanswercnt").val(id-1);
          $(".edaddnew").show();
          $("#op"+id).remove();
      }
      
  }

  function edremoveopt(id)
  {
      $(".edansop"+id).remove();
      if(id == "3")
      {
          $(".edaddnew").show();
          $(".editremoveBtnd").show();
          $(".editremoveBtn2").show();
          $("#op"+id).remove();
      }
      else if(id == "2")
      {
          $(".editremoveBtnc").show();
          $(".editremoveBtn1").show();
          $("#op"+id).remove();
      }
      else if(id == "1")
      {
         $("#op"+id).remove();
      }
      $(".editanswercnt").val(id-1);
  }
  </script>
@endsection