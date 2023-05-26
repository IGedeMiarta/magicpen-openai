

<?php $__env->startSection('css'); ?>
	<!-- Data Table CSS -->
	<link href="<?php echo e(URL::asset('plugins/datatable/datatables.min.css')); ?>" rel="stylesheet" />
	<!-- Sweet Alert CSS -->
	<link href="<?php echo e(URL::asset('plugins/sweetalert/sweetalert2.min.css')); ?>" rel="stylesheet" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-header'); ?>
	<!-- PAGE HEADER -->
	<div class="page-header mt-5-7">
		<div class="page-leftheader">
			<h4 class="page-title mb-0"><?php echo e(__('AI Voices Customization')); ?></h4>
			<ol class="breadcrumb mb-2">
				<li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>"><i class="fa-solid fa-microchip-ai mr-2 fs-12"></i><?php echo e(__('Admin')); ?></a></li>
				<li class="breadcrumb-item"><a href="<?php echo e(route('admin.davinci.dashboard')); ?>"> <?php echo e(__('Davinci Management')); ?></a></li>
				<li class="breadcrumb-item active" aria-current="page"><a href="#"> <?php echo e(__('AI Voices Customization')); ?></a></li>
			</ol>
		</div>
		<div class="page-rightheader">			
			<a id="activateAllVoices" href="#" class="btn btn-primary mt-1"><?php echo e(__('Activate All')); ?></a>
			<a id="deactivateAllVoices" href="#" class="btn btn-primary mt-1"><?php echo e(__('Deactivate All')); ?></a>
		</div>
	</div>
	<!-- END PAGE HEADER -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>	
	<!-- ALL USERS PROCESSED TEXT RESULTS -->
	<div class="row">
		<div class="col-lg-12 col-md-12 col-xm-12">
			<div class="card border-0">
				<div class="card-header">
					<h3 class="card-title"><?php echo e(__('All AI Voiceover Studio Voices')); ?></h3>
				</div>
				<div class="card-body pt-2">
					<!-- BOX CONTENT -->
					<div class="box-content">
							<!-- SET DATATABLE -->
							<table id='allResultsTable' class='table' width='100%'>
									<thead>
										<tr>									
											<th width="4%"><?php echo e(__('Status')); ?></th> 
											<th width="1%"><?php echo e(__('Avatar')); ?></th>
											<th width="1%"><?php echo e(__('Vendor')); ?></th>
											<th width="8%"><?php echo e(__('Language')); ?></th>
											<th width="5%"><?php echo e(__('Language Code')); ?></th>
											<th width="5%"><?php echo e(__('Voice Name')); ?></th>
											<th width="7%"><?php echo e(__('Voice ID')); ?></th>
											<th width="2%"><?php echo e(__('Gender')); ?></th>
											<th width="2%"><?php echo e(__('Voice Engine')); ?></th>
											<th width="1%"><?php echo e(__('Sample')); ?></th>							
											<th width="4%"><?php echo e(__('Updated On')); ?></th>	    										 						           	
											<th width="7%"><?php echo e(__('Actions')); ?></th>
										</tr>
									</thead>
							</table> <!-- END SET DATATABLE -->
					</div> <!-- END BOX CONTENT -->
				</div>
			</div>
		</div>
	</div>
	<!-- END ALL USERS PROCESSED TEXT RESULTS -->

	<!-- CHANGE VOICE NAME MODAL -->
	<div class="modal fade" id="changeNameModal" tabindex="-1" role="dialog" aria-labelledby="changeNameModalLabel" aria-hidden="true" data-keyboard="false">
		<div class="modal-dialog modal-dialog-centered modal-md" role="document">
			<div class="modal-content">
				<div class="modal-header mb-1">
					<h4 class="modal-title" id="myModalLabel"><i class="mdi mdi-animation"></i> <?php echo e(__('Update Voice Name')); ?></h4>
					<button type="button" class="close" data-dismiss="modal" id="modal-close" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body" id="changeNameModalBody">
					<div>
						<!-- VOICE NAME -->
					</div>
				</div>			
			</div>
		</div>
	</div>
	<!-- END MODAL -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
	<!-- Data Tables JS -->
	<script src="<?php echo e(URL::asset('plugins/datatable/datatables.min.js')); ?>"></script>
	<script src="<?php echo e(URL::asset('plugins/sweetalert/sweetalert2.all.min.js')); ?>"></script>
	<!-- Green Audio Players JS -->
	<script src="<?php echo e(URL::asset('plugins/audio-player/green-audio-player.js')); ?>"></script>
	<script src="<?php echo e(URL::asset('js/audio-player.js')); ?>"></script>
	<script type="text/javascript">
		$(function () {

			"use strict";

			// INITILIZE DATATABLE
			var table = $('#allResultsTable').DataTable({
				"lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
				responsive: {
					details: {type: 'column'}
				},
				"order": [[ 4, "asc" ]],
				colReorder: true,
				language: {
					"emptyTable": "<div><img id='no-results-img' src='<?php echo e(URL::asset('img/files/no-result.png')); ?>'><br>Activate preferred cloud vendor first</div>",
					search: "<i class='fa fa-search search-icon'></i>",
					lengthMenu: '_MENU_ ',
					paginate : {
						first    : '<i class="fa fa-angle-double-left"></i>',
						last     : '<i class="fa fa-angle-double-right"></i>',
						previous : '<i class="fa fa-angle-left"></i>',
						next     : '<i class="fa fa-angle-right"></i>'
					}
				},
				pagingType : 'full_numbers',
				processing: true,
				serverSide: true,
				ajax: "<?php echo e(route('admin.davinci.voices')); ?>",
				columns: [
					{
						data: 'custom-status',
						name: 'custom-status',
						orderable: true,
						searchable: true
					},	
					{
						data: 'avatar',
						name: 'avatar',
						orderable: true,
						searchable: true
					},	
					{
						data: 'vendor',
						name: 'vendor',
						orderable: true,
						searchable: true
					},
					{
						data: 'custom-language',
						name: 'custom-language',
						orderable: true,
						searchable: true
					},		
					{
						data: 'language_code',
						name: 'language_code',
						orderable: true,
						searchable: true
					},
					{
						data: 'voice',
						name: 'voice',
						orderable: true,
						searchable: true
					},
					{
						data: 'voice_id',
						name: 'voice_id',
						orderable: true,
						searchable: true
					},
					{
						data: 'gender',
						name: 'gender',
						orderable: true,
						searchable: true
					},
					{
						data: 'custom-voice-type',
						name: 'custom-voice-type',
						orderable: true,
						searchable: true
					},
					{
						data: 'single',
						name: 'single',
						orderable: true,
						searchable: true
					},							
					{
						data: 'created-on',
						name: 'created-on',
						orderable: true,
						searchable: true
					},									
					{
						data: 'actions',
						name: 'actions',
						orderable: false,
						searchable: false
					},
				]
			});


			// UPDATE VOICE NAME
			$(document).on('click', '.changeVoiceNameButton', function(e) {

				e.preventDefault();

				Swal.fire({
					title: 'Update Voice Name',
					showCancelButton: true,
					confirmButtonText: 'Update',
					reverseButtons: true,
					input: 'text',
				}).then((result) => {
					if (result.value) {
						var formData = new FormData();
						formData.append("name", result.value);
						formData.append("id", $(this).attr('id'));
						$.ajax({
							headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
							method: 'post',
							url: 'voice/update',
							data: formData,
							processData: false,
							contentType: false,
							success: function (data) {
								if (data == 'success') {
									Swal.fire('<?php echo e(__('Voice Name Updated')); ?>', '<?php echo e(__('Voice name has been successfully updated')); ?>', 'success');
									$("#allResultsTable").DataTable().ajax.reload();
								} else {
									Swal.fire('<?php echo e(__('Update Error')); ?>', '<?php echo e(__('Voice name was not updated correctly')); ?>', 'error');
								}      
							},
							error: function(data) {
								Swal.fire('Update Error', data.responseJSON['error'], 'error');
							}
						})
					} else if (result.dismiss !== Swal.DismissReason.cancel) {
						Swal.fire('<?php echo e(__('No Voice Name Entered')); ?>', '<?php echo e(__('Make sure to provide a name before updating')); ?>', 'error')
					}
				})
			});


			// CHANGE AVATARS
			$(document).on('click', '.changeAvatarButton', function(e) {

				e.preventDefault();

				Swal.fire({
					title: 'Change Voice Avatar',
					showCancelButton: true,
					confirmButtonText: 'Upload',
					reverseButtons: true,	
					input: 'file',
				}).then((file) => {
					if (file.value) {
						var formData = new FormData();
						var file = $('.swal2-file')[0].files[0];
						formData.append("avatar", file);
						formData.append("id", $(this).attr('id'));
						$.ajax({
							headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
							method: 'post',
							url: 'voices/avatar/upload',
							data: formData,
							processData: false,
							contentType: false,
							success: function (data) {
								if (data == 'success') {
									Swal.fire('<?php echo e(__('Avatar Uploaded')); ?>', '<?php echo e(__('Voice Avatar has been successfully uploaded')); ?>', 'success');
									$("#allResultsTable").DataTable().ajax.reload();
								} else {
									Swal.fire('<?php echo e(__('Upload Error')); ?>', '<?php echo e(__('Make sure you are uploading an image file')); ?>', 'error');
								}      
							},
							error: function(data) {
								Swal.fire({ type: 'error', title: 'Oops...', text: 'Something went wrong!' })
							}
						})
					} else if (file.dismiss !== Swal.DismissReason.cancel) {
						Swal.fire('<?php echo e(__('No File Selected')); ?>', '<?php echo e(__('Make sure to select an image file before uploading')); ?>', 'error')
					}
				})
			});


			// ACTIVATE VOICE
			$(document).on('click', '.activateVoiceButton', function(e) {

				e.preventDefault();

				var formData = new FormData();
				formData.append("id", $(this).attr('id'));

				$.ajax({
					headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
					method: 'post',
					url: 'voices/voice/activate',
					data: formData,
					processData: false,
					contentType: false,
					success: function (data) {
						if (data == 'success') {
							Swal.fire('<?php echo e(__('Voice Activated')); ?>', '<?php echo e(__('Voice has been activated successfully')); ?>', 'success');
							$("#allResultsTable").DataTable().ajax.reload();
						} else {
							Swal.fire('<?php echo e(__('Voice Already Active')); ?>', '<?php echo e(__('Selected voice is already activated')); ?>', 'error');
						}      
					},
					error: function(data) {
						Swal.fire({ type: 'error', title: 'Oops...', text: 'Something went wrong!' })
					}
				})

			});


			// DEACTIVATE VOICE
			$(document).on('click', '.deactivateVoiceButton', function(e) {

				e.preventDefault();

				var formData = new FormData();
				formData.append("id", $(this).attr('id'));

				$.ajax({
					headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
					method: 'post',
					url: 'voices/voice/deactivate',
					data: formData,
					processData: false,
					contentType: false,
					success: function (data) {
						if (data == 'success') {
							Swal.fire('<?php echo e(__('Voice Deactivated')); ?>', '<?php echo e(__('Voice has been deactivated successfully')); ?>', 'success');
							$("#allResultsTable").DataTable().ajax.reload();
						} else {
							Swal.fire('<?php echo e(__('Voice Already Deactive')); ?>', '<?php echo e(__('Selected voice is already deactivated')); ?>', 'error');
						}      
					},
					error: function(data) {
						Swal.fire({ type: 'error', title: 'Oops...', text: 'Something went wrong!' })
					}
				})

			});


			// ACTIVATE ALL VOICES
			$(document).on('click', '#activateAllVoices', function(e) {

				e.preventDefault();

				$.ajax({
					headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
					method: 'get',
					url: 'voices/activate/all',
					processData: false,
					contentType: false,
					success: function (data) {
						if (data == 'success') {
							Swal.fire('<?php echo e(__('All Voices Activated')); ?>', '<?php echo e(__('All voice were successfully activated')); ?>', 'success');
							$("#allResultsTable").DataTable().ajax.reload();
						}   
					},
					error: function(data) {
						Swal.fire({ type: 'error', title: 'Oops...', text: 'Something went wrong!' })
					}
				})

			});


			// ACTIVATE ALL VOICES
			$(document).on('click', '#deactivateAllVoices', function(e) {

				e.preventDefault();

				$.ajax({
					headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
					method: 'get',
					url: 'voices/deactivate/all',
					processData: false,
					contentType: false,
					success: function (data) {
						if (data == 'success') {
							Swal.fire('<?php echo e(__('All Voices Deactivated')); ?>', '<?php echo e(__('All voice were successfully deactivated')); ?>', 'success');
							$("#allResultsTable").DataTable().ajax.reload();
						}   
					},
					error: function(data) {
						Swal.fire({ type: 'error', title: 'Oops...', text: 'Something went wrong!' })
					}
				})

			});

		});
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ku52g0exgkyh/public_html/resources/views/admin/davinci/voices/index.blade.php ENDPATH**/ ?>