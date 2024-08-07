<!-- Modal Starts -->

<div class="modal fade bs-modal-lg delete-modal" tabindex="-1" role="basic" aria-hidden="true" data-backdrop="static" data-keyboard="false">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title">{{ __('Confirm Delete') }}</h4>
										</div>
										<div class="modal-body p-2">
										{{ __('Are you sure want to delete?') }}
                                        </div>
										<div class="modal-footer">
											<button type="button" class="btn default" data-dismiss="modal">{{ __('Close') }}</button>
											<button type="button" data-value="1" class="btn btn-danger delete-modal-btn">{{ __('Delete') }}</button>
										</div>
									</div>
									<!-- /.modal-content -->
								</div>
								<!-- /.modal-dialog -->
							</div>


<!-- Modal Ends -->


<!-- Modal Starts -->

<div class="modal fade bs-modal-lg confirm-modal" tabindex="-1" role="basic" aria-hidden="true" data-backdrop="static" data-keyboard="false">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title">{{ __('Confirm Delete') }}</h4>
										</div>
										<div class="modal-body p-2">
											
                                        </div>
										<div class="modal-footer">
											<button type="button" class="btn default" data-dismiss="modal">{{ __('Close') }}</button>
											<button type="button" data-value="0" class="btn btn-danger delete-modal-btn">{{ __('Confirm Delete') }}</button>
										</div>
									</div>
									<!-- /.modal-content -->
								</div>
								<!-- /.modal-dialog -->
							</div>


<!-- Modal Ends -->


<!-- Status Modal -->

<div class="modal fade bs-modal-lg status-modal" tabindex="-1" role="basic" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">{{ __('Confirm Changes') }}</h4>
			</div>
			<div class="modal-body p-2">
			{{ __('Are you sure want to change Status?') }}
            </div>
			<div class="modal-footer">
				<button type="button" class="btn default" data-dismiss="modal">{{ __('Close') }}</button>
				<button type="button"class="btn btn-danger status-modal-btn">{{ __('Change') }}</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>

<!-- End Modal -->


