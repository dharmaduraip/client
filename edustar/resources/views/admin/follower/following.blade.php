<!-- <div class="contentbar">  -->
    <div class="row">
        
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-header">
                    <h5 class="box-title">{{ __('All Followers') }}</h5>
                </div>
                <div class="card-body">
                
                    <div class="table-responsive">
                        <table id="datatable" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('User') }}</th>
                                    <th>{{ __('Email') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0; ?>
                                @foreach ($followings as $following)
                                <?php $i++; ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td>{{ $following->follow->fname }}</td>
                                    <td>{{ $following->follow->email }}</td>
                                   

                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- </div> -->

