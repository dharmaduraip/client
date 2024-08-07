@extends('admin.layouts.master')
@section('title','All Quiz')
@section('maincontent')
@component('components.breadcumb',['secondaryactive' => 'active'])
@slot('heading')
   {{ __('Quiz') }}
@endslot

@slot('menu1')
   {{ __('Quiz') }}
@endslot
@slot('button')

<div class="col-md-4 col-lg-4">
    <div class="widgetbar">
      @if($topic->type == NULL)
        <a href="{{ route('import.quiz') }}"  class="float-right btn btn-primary-rgba mr-2"><i class="feather icon-plus mr-2"></i>{{ __('Import Quiz') }}</a>
        <a data-toggle="modal" data-target="#myModalquiz" href="#"  class="float-right btn btn-primary-rgba mr-2"><i class="feather icon-plus mr-2"></i>{{ __('Add Question') }}</a>
      @endif

      @if($topic->type == '1')
        <a data-toggle="modal" data-target="#myModalquizsubject"  class="float-right btn btn-primary-rgba mr-2"><i class="feather icon-plus mr-2"></i>{{ __('Add Question') }}</a>
      @endif


      <a href="{{ url('course/create/'. $topic->courses->id) }}" class="float-right btn btn-primary-rgba mr-2"><i class="feather icon-arrow-left mr-2"></i>{{ __('Back') }}</a>

    </div>                        
</div>
@endslot
@endcomponent
<div class="contentbar"> 
  <div class="row">
    @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif
      <div class="col-lg-12">
          <div class="card m-b-30">
              <div class="card-header">
                  <h5 class="box-title">{{ __('All Quiz') }}</h5>
              </div>
              <div class="card-body">
              
                  <div class="table-responsive">
                      <table id="datatable-buttons" class="table table-striped table-bordered">
                          <thead>
                          <tr>
                        
                              <th>#</th>
                              <th>{{ __('Course') }}</th>
                              <th>{{ __('Topic') }}</th>
                              <th>{{ __('Question') }}</th>
                              @if($topic->type == NULL)
                              <th>{{ __('A') }}</th>
                              <th>{{ __('B') }}</th>
                              <th>{{ __('C') }}</th>
                              <th>{{ __('D') }}</th>
                              <th>{{ __('E') }}</th>
                              <th>{{ __('Answer') }}</th>
                              @endif
                              
                              <th>{{ __('Action') }}</th>
                            </tr>
                          </thead>
                          <tbody id="sortable">
                            <?php $i=0;?>
                            @foreach($quizes as $quiz)
                            <?php $i++;?>
                            <tr class="sortable" id="id-{{ $quiz->id }}">

                              <td><?php echo $i;?></td>
                              <td>{{$quiz->courses->title}}</td>
                              <td>{{$quiz->topic->title}}</td>
                              <td>{{$quiz->question}}</td>
                              @if($topic->type == NULL)
                              <td>{{$quiz->a}}</td>
                              <td>{{$quiz->b}}</td>
                              <td>{{$quiz->c}}</td>
                              <td>{{$quiz->d}}</td>
                              <td>{{$quiz->e}}</td>
                              <td>{{$quiz->answer}}</td>
                              @endif
                              <td>
                                <div class="dropdown">
                                    <button class="btn btn-round btn-outline-primary" type="button" id="CustomdropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-vertical-"></i></button>
                                    <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton1">
                                      @if($topic->type == NULL)
                                        <a class="dropdown-item"  href="{{ url('admin/edit/objective/'.$quiz->id.'/'.$topic->id ) }}"   ><i class="feather icon-edit mr-2"></i>{{ __('Edit') }}</a>
                                        @endif
                                        @if($topic->type == '1')
                                        <a class="dropdown-item" data-toggle="modal" data-target="#myModaleditsub{{$quiz->id}}" href="#"><i class="feather icon-edit mr-2"></i>{{ __('Edit') }}</a>
                                        @endif
                                        <a class="dropdown-item btn btn-link" data-toggle="modal" data-target="#delete{{ $quiz->id }}" >
                                            <i class="feather icon-delete mr-2"></i>{{ __("Delete") }}</a>
                                        </a>
                                    </div>
                                </div>

                                <!-- delete Modal start -->
                                <div class="modal fade bd-example-modal-sm" id="delete{{$quiz->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleSmallModalLabel">{{ __('Delete') }}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                    <h4>{{ __('Are You Sure ?')}}</h4>
                                                    <p>{{ __('Do you really want to delete')}} ? {{ __('This process cannot be undone.')}}</p>
                                            </div>
                                            <div class="modal-footer">
                                                <form method="post" action="{{url('admin/questions/'.$quiz->id)}}" class="pull-right">
                                                    {{csrf_field()}}
                                                    {{method_field("DELETE")}}
                                                    <button type="reset" class="btn btn-secondary" data-dismiss="modal">{{ __('No') }}</button>
                                                    <button type="submit" class="btn btn-primary">{{ __('Yes') }}</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- delete Model ended -->

                            </td>
                             
                          
                            </tr>
            
                            <!--Model for edit question-->
                           {{--  <div class="modal fade" id="myModaledit{{$quiz->id}}" tabindex="-1" role="dialog"
                              aria-labelledby="myModalLabel">
                              <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                      <h5 class="modal-title" id="my-modal-title">
                                        <b>{{ __('Add Quiz') }}</b>
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                                   
                                  </div>
                                  <div class="box box-primary">
                                    <div class="panel panel-sum">
                                      <div class="modal-body">
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
                                                          class="form-control select2">
                                                          <option {{ $quiz->answer == 'A' ? 'selected' : ''}} value="A">
                                                            {{ __('A') }}</option>
                                                          <option {{ $quiz->answer == 'B' ? 'selected' : ''}} value="B">
                                                            {{ __('B') }}</option>
                                                          @if($quiz->c != NULL && $quiz->c != '')
                                                              <option {{ $quiz->answer == 'C' ? 'selected' : ''}} value="C">
                                                                {{ __('C') }}</option>
                                                          @endif
                                                          @if($quiz->d != NULL && $quiz->d != '')
                                                              <option {{ $quiz->answer == 'D' ? 'selected' : ''}} value="D">
                                                                {{ __('D') }}</option>
                                                          @endif
                                                          @if($quiz->e != NULL && $quiz->e != '')
                                                              <option {{ $quiz->answer == 'E' ? 'selected' : ''}} value="E">
                                                                {{ __('E') }}</option>
                                                          @endif
                                                        </select> 
                                                    </div>
                                                    <br>
                                                    <h4 class="extras-heading">{{ __('Video And Image For Question') }}</h4>
                                                    <div class="form-group{{ $errors->has('question_video_link') ? ' has-error' : '' }}">
                                                        <label for="exampleInputDetails">{{ __('Add Video To Question') }} :<sup class="redstar">*</sup></label>
                                                        <input type="text" name="question_video_link" class="form-control"
                                                          placeholder="https://myvideolink.com/embed/.." />
                                                        <small class="text-danger">{{ $errors->first('question_video_link') }}</small>
                                                        <small class="text-muted text-info"> <i class="text-dark feather icon-help-circle"></i> {{ __('YouTube And Vimeo Video Support (Only Embed Code Link)') }}</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="col-md-12">
                  
                                                      <label for="exampleInputDetails">{{ __('AOption') }} :<sup
                                                          class="redstar">*</sup></label>
                                                      <input type="text" name="a" value="{{ $quiz->a }}" class="form-control"
                                                        placeholder="Enter Option A" required>
                                                    </div>
              
                                                    <div class="col-md-12">
                                                          <label for="exampleInputDetails">{{ __('BOption') }} :<sup
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
                          
                                                                <label for="exampleInputDetails">{{ __('COption') }} :<sup
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
                          
                                                              <label for="exampleInputDetails">{{ __('DOption') }} :<sup
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
                          
                                                            <label for="exampleInputDetails">{{ __('EOption') }} :<sup
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
                                                              aria-describedby="inputGroupFileAddon01">
                                                            <label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
                                                        </div>
                                                    </div>
                                              
                                                </div>
                                            </div>
                                            
                                            <input type="text" name="editanscnt" id="editanswercnt" value="check" class="editanswercnt">
                                        
                                            <div class="form-group">
                                              <button type="reset" class="btn btn-danger-rgba"><i class="fa fa-ban"></i>
                                                {{ __('Reset') }}</button>
                                              <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                                                {{ __('Update') }}</button>
                                            </div>
                          
                                            <div class="clear-both"></div>
                                        </form>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div> --}}
                            <!--Model close -->
            
                            <!--Model for edit question-->
                            <div class="modal fade" id="myModaleditsub{{$quiz->id}}" tabindex="-1" role="dialog"
                              aria-labelledby="myModalLabel">
                              <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <div class="col-12 d-flex justify-content-between">
                                        <h5>{{ __('Edit Question') }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                    </div>
                                  </div>
                                  <div class="box box-primary">
                                    <div class="panel panel-sum">
                                      <div class="modal-body">
                                        <form id="demo-form2" method="POST" action="{{route('questions.update', $quiz->id)}}"
                                          data-parsley-validate class="form-horizontal form-label-left"
                                          enctype="multipart/form-data">
                                          {{ csrf_field() }}
                                          {{ method_field('PUT') }}
            
                                          <input type="hidden" name="course_id" value="{{ $topic->course_id }}" />
            
                                          <input type="hidden" name="topic_id" value="{{ $topic->id }}" />
            
                                          <input type="hidden" name="type" value="1" />
           
                                          <div class="row">
                                            <div class="col-md-12">
                                              <label for="exampleInputTit1e">{{ __('Question') }}</label>
                                              <textarea name="question" rows="6" class="form-control" 
                                                placeholder="Enter Your Question">{{ $quiz->question }}</textarea>
                                              <br>
                                            </div>
            
            
                                          </div>
                                          <br>
            
            
            
                                          <div class="col-md-12">
                                            <div class="extras-block">
                                              <h4 class="extras-heading">{{ __('Images And Video For Question') }}</h4>
                                              <div class="row">
                                                <div class="col-md-6">
                                                  <div
                                                    class="form-group{{ $errors->has('question_video_link') ? ' has-error' : '' }}">
            
            
                                                    <label for="exampleInputDetails">{{ __('Add Video To Question') }} :</label>
                                                    <input type="text" name="question_video_link"
                                                      value="{{ $quiz->question_video_link }}" class="form-control"
                                                      placeholder="https://myvideolink.com/embed/.." />
            
                                                    <small class="text-danger">{{ $errors->first('question_video_link') }}</small>
                                                    <small class="text-muted text-info"> <i class="text-dark feather icon-help-circle"></i>{{ __('YouTube And Vimeo Video Support (Only Embed Code Link)') }}</small>

                                                  </div>
                                                </div>
                                                <div class="col-md-6">
                                                  <div class="form-group{{ $errors->has('question_img') ? ' has-error' : '' }}">
            
            
                                                    <label for="exampleInputDetails">{{ __('Add Image To Question') }} :</label>
                                                    <input type="file" name="question_img" class="form-control" accept=".jpg,.jpeg,.png"/>
            
            
                                                    <small class="text-danger">{{ $errors->first('question_img') }}</small>
                                                    <small class="text-muted text-info"> <i class="text-dark feather icon-help-circle"></i> {{ __('Please Choose Only .JPG, .JPEG and .PNG') }}</small>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
            
            
                                          <div class="form-group">
                                            <button type="reset" class="btn btn-danger"><i class="fa fa-ban"></i>
                                             {{ __('Reset') }} </button>
                                            <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
                                              {{ __('Update') }}</button>
                                          </div>
                          
                                          <div class="clear-both"></div>
                                        </form>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <!--Model close -->
            
            
                            @endforeach
            
                          </tbody>
                      </table>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <div class="modal fade" id="myModalquiz" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <div class="col-12 d-flex justify-content-between">
              <h4 class="modal-title" id="myModalLabel"> {{ __('Add') }} {{ __('Question') }}</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                  aria-hidden="true">&times;</span></button>   
          </div>
        </div>
        <div class="box box-primary">
          <div class="panel panel-sum">
            <div class="modal-body">
              <form id="demo-form2" method="post" action="{{route('questions.store')}}" data-parsley-validate
                class="form-horizontal form-label-left" enctype="multipart/form-data">
                {{ csrf_field() }}
  
                <input type="hidden" name="course_id" value="{{ $topic->course_id }}" />
  
                <input type="hidden" name="topic_id" value="{{ $topic->id }}" />
  <div class="row">
    <div class="col-md-6">
      <div class="col-md-12">
        <label for="exampleInputTit1e">{{ __('Question') }}</label>
        <textarea name="question" rows="6" class="form-control" placeholder="Enter Your Question" required></textarea>
        <br>
      </div>
      <div class="col-md-12">
        <label for="exampleInputDetails">{{ __('Answer') }}:<sup
            class="redstar">*</sup></label>
        <select style="width: 100%" name="answer" id="anskey" class="form-control select2" >
          <option value="none" selected disabled hidden>
            {{ __('Select an Option') }}
          </option>
          <option value="A">{{ __('A') }}</option>
          <option value="B">{{ __('B') }}</option>
          <!-- <option value="C">{{ __('C') }}</option>
          <option value="D">{{ __('D') }}</option>
          <option value="E">{{ __('E') }}</option> -->
        </select>
      </div>
      <br>
      <h4 class="extras-heading">{{ __('Video And Image For Question') }}</h4>
    <div class="form-group{{ $errors->has('question_video_link') ? ' has-error' : '' }}">
  
  
      <label for="exampleInputDetails">{{ __('Add Video To Question') }} :<sup class="redstar">*</sup></label>
      <input type="text" name="question_video_link" class="form-control"
        placeholder="https://myvideolink.com/embed/.." />
      <small class="text-danger">{{ $errors->first('question_video_link') }}</small>
      <small class="text-muted text-info"> <i class="text-dark feather icon-help-circle"></i> {{ __('YouTube And Vimeo Video Support (Only Embed Code Link)') }}</small>
    </div>
    </div>
    <div class="col-md-6">
      <div class="col-md-12">
  
        <label for="exampleInputDetails">{{ __('A Option') }} :<sup
            class="redstar">*</sup></label>
        <input type="text" name="a" class="form-control" placeholder="Enter Option A" required>
      </div>

      <div class="col-md-12">
          <label for="exampleInputDetails">{{ __('B Option') }} :<sup
              class="redstar">*</sup></label>
          <div class="d-flex justify-content-between">
            <input type="text" name="b" class="form-control" placeholder="Enter Option B" required>
            <button type="button" class="addnew btn-primary-rgba btn-sm" >
                <i class="feather icon-plus"></i>
            </button>
        </div>
      </div>

      <div id="dynopt">
        
      </div>
      {{-- <div class="col-md-12">

        <label for="exampleInputDetails">{{ __('COption') }} :<sup
            class="redstar">*</sup></label>
        <input type="text" name="c" class="form-control" placeholder="Enter Option C" />
      </div>

      <div class="col-md-12">

        <label for="exampleInputDetails">{{ __('DOption') }} :<sup
            class="redstar">*</sup></label>
        <input type="text" name="d" class="form-control" placeholder="Enter Option D" />
      </div> --}}
    </div>
    <div class="form-group col-md-6">
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
      
    </div>
  </div>
  <input type="hidden" name="anscnt" id="answercnt" value="0">
  <div class="form-group">
    {{-- <button type="reset" class="btn btn-danger"><i class="fa fa-ban"></i> {{ __('Reset') }}</button> --}}
    <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
      {{ __('Create') }}</button>
  </div>

  <div class="clear-both"></div>
 
  
              
               
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--Model close -->
  
  
  <!--Model for add question -->
  <div class="modal fade" id="myModalquizsubject" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <div class="col-12 d-flex justify-content-between">
              <h5>{{ __('Add Question') }}</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                  aria-hidden="true">&times;</span></button>
          </div>
        </div>
        <div class="box box-primary">
          <div class="panel panel-sum">
            <div class="modal-body">
              <form id="demo-form2" method="post" action="{{route('questions.store')}}" data-parsley-validate
                class="form-horizontal form-label-left" enctype="multipart/form-data">
                {{ csrf_field() }}
  
                <input type="hidden" name="course_id" value="{{ $topic->course_id }}" />
  
                <input type="hidden" name="topic_id" value="{{ $topic->id }}" />
  
  
                <input type="hidden" name="type" value="1" />
  
                <div class="row">
                  <div class="col-md-12">
                    <label for="exampleInputTit1e">{{ __('Question') }}</label>
                    <textarea name="question" rows="6" class="form-control" placeholder="Enter Your Question"></textarea>
                    <br>
                  </div>
  
  
                </div>
                <br>
  
  
                <div class="col-md-12">
                  <div class="extras-block">
                    <h4 class="extras-heading">{{ __('Video And Image For Question') }}</h4>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group{{ $errors->has('question_video_link') ? ' has-error' : '' }}">
  
  
                          <label for="exampleInputDetails">{{ __('Add Video To Question') }} :</label>
                          <input type="text" name="question_video_link" class="form-control"
                            placeholder="https://myvideolink.com/embed/.."  />
                          <small class="text-danger">{{ $errors->first('question_video_link') }}</small>
                          <small class="text-muted text-info"> <i class="text-dark feather icon-help-circle"></i> {{ __('YouTube And Vimeo Video Support (Only Embed Code Link)') }}</small>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group{{ $errors->has('question_img') ? ' has-error' : '' }}">
  
                          <label for="exampleInputDetails">{{ __('Add Image To Question') }} :</label>
                          <input type="file" name="question_img" class="form-control" accept=".jpg,.jpeg,.png"/>
                          <small class="text-danger">{{ $errors->first('question_img') }}</small>
                          <small class="text-muted text-info"> <i class="text-dark feather icon-help-circle"></i> {{ __('Please Choose Only .JPG, .JPEG and .PNG') }}</small>

         
                        </div>
                      </div>
                      <br>
  
                      <br>
                    </div>
                  </div>
                </div>
  
  
                <div class="form-group">
                  <button type="reset" class="btn btn-danger"><i class="fa fa-ban"></i> {{__('Reset')}}</button>
                  <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
                    {{__('Create')}}</button>
                </div>
    
                <div class="clear-both"></div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('script')
  <script type="text/javascript">
    $( function() {
      $( "#sortable" ).sortable();
      $( "#sortable" ).disableSelection();
    } );
  
     $("#sortable").sortable({
     update: function (e, u) {
      var data = $(this).sortable('serialize');
     
      $.ajax({
          url: "{{ route('questions_reposition') }}",
          type: 'get',
          data: data,
          dataType: 'json',
          success: function (result) {
            console.log(data);
          }
      });
  
    }
  
  });

  $(document).ready(function(){
    $(".addnew").click(function(){
        var anscnt = parseInt($('#answercnt').val())+1;
        if(anscnt == "1")
        {
          $("#dynopt").append(`
              <div class="col-md-12" id="ansop`+anscnt+`">
                  <label for="exampleInputDetails">{{ __('C Option') }} :<sup
                    class="redstar">*</sup></label>
                  <div class="d-flex justify-content-between">
                      <input type="text" name="c" class="form-control" placeholder="Enter Option C" required>
                      <button type="button" id="anshide`+anscnt+`" class="removeBtn btn-danger-rgba btn-sm" onclick="removeopt(`+anscnt+`)">
                          <i class="feather icon-trash"></i>
                      </button>
                  </div>
              </div>
            `);
          $("#anskey").append('<option value="C" id="op1">{{ __("C") }}</option>');
        }
        else if(anscnt == "2")
        {
            $("#dynopt").append(`
                <div class="col-md-12" id="ansop`+anscnt+`">
                  <label for="exampleInputDetails">{{ __('D Option') }} :<sup
                      class="redstar">*</sup></label>
                  <div class="d-flex justify-content-between">
                      <input type="text" name="d" class="form-control" placeholder="Enter Option D" required>
                      <button type="button" id="anshide`+anscnt+`" class="removeBtn btn-danger-rgba btn-sm" onclick="removeopt(`+anscnt+`)">
                          <i class="feather icon-trash"></i>
                      </button>
                  </div>
              </div>

            `);
            $("#anskey").append('<option value="D" id="op2">{{ __("D") }}</option>');
            var mincnt = $('#answercnt').val();
            $("#anshide"+mincnt).hide();
        }
        else if(anscnt == "3")
        {
            $("#dynopt").append(`
                <div class="col-md-12" id="ansop`+anscnt+`">
                  <label for="exampleInputDetails">{{ __('E Option') }} :<sup
                      class="redstar">*</sup></label>
                  <div class="d-flex justify-content-between">
                      <input type="text" name="e" class="form-control" placeholder="Enter Option E" required>
                      <button type="button" id="anshide`+anscnt+`" class="removeBtn btn-danger-rgba btn-sm" onclick="removeopt(`+anscnt+`)">
                          <i class="feather icon-trash"></i>
                      </button>
                  </div>
              </div>

            `);
            $("#anskey").append('<option value="E" id="op3">{{ __("E") }}</option>');
            var mincnt = $('#answercnt').val();
            $("#anshide"+mincnt).hide();
            $(".addnew").hide();
        }
        $("#answercnt").val(anscnt);
    });

    

  });
  function removeopt(anscnt)
  {
      $("#ansop"+anscnt).remove();
      $("#op"+anscnt).remove();
      var remcnt = parseInt($('#answercnt').val())-1;
      $("#answercnt").val(remcnt);
      $("#anshide"+remcnt).show();
      if(remcnt != "3")
      {
          $(".addnew").show();
      }

  }


  

</script>
@endsection