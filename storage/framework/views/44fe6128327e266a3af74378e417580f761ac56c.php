

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
			<h4 class="page-title mb-0"><?php echo e(__('Support Requests')); ?></h4>
			<ol class="breadcrumb mb-2">
				<li class="breadcrumb-item"><a href="<?php echo e(route('user.dashboard')); ?>"><i class="fa-solid fa-messages-question mr-2 fs-12"></i><?php echo e(__('User')); ?></a></li>
				<li class="breadcrumb-item active" aria-current="page"><a href="<?php echo e(url('#')); ?>"> <?php echo e(__('Support Requests')); ?></a></li>
			</ol>
		</div>
		<div class="page-rightheader">
			<a href="<?php echo e(route('user.support.create')); ?>" class="btn btn-primary mt-1"><?php echo e(__('New Support Request')); ?></a>
		</div>
	</div>
	<!-- END PAGE HEADER -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>						
	<!-- SUPPORT REQUEST DATA TABLE -->
	<div class="row">
		<div class="col-lg-12 col-md-12 col-xm-12">
			<div class="card overflow-hidden border-0">
				<div class="card-header">
					<h3 class="card-title"><?php echo e(__('My Support Request List')); ?></h3>
				</div>
				<div class="card-body pt-2">
					<!-- BOX CONTENT -->
					<div class="box-content">
						<!-- SET DATATABLE -->
						<table id='supportRequestsTable' class='table' width='100%'>
							<thead>
								<tr>
									<th width="10%"><?php echo e(__('Ticket ID')); ?></th>
									<th width="10%"><?php echo e(__('Status')); ?></th>																				
									<th width="10%"><?php echo e(__('Category')); ?></th>	
									<th width="15%"><?php echo e(__('Subject')); ?></th>										
									<th width="10%"><?php echo e(__('Priority')); ?></th>
									<th width="10%"><?php echo e(__('Created Date')); ?></th>
									<th width="10%"><?php echo e(__('Last Updated Date')); ?></th>									
									<th width="5%"><?php echo e(__('Actions')); ?></th>
								</tr>
							</thead>
						</table> <!-- END SET DATATABLE -->
					</div> <!-- END BOX CONTENT -->
				</div>
			</div>
		</div>
	</div>
	<!-- END SUPPORT REQUEST DATA TABLE -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
	<!-- Data Tables JS -->
	<script src="<?php echo e(URL::asset('plugins/datatable/datatables.min.js')); ?>"></script>
	<script src="<?php echo e(URL::asset('plugins/sweetalert/sweetalert2.all.min.js')); ?>"></script>
	<script type="text/javascript">
		$(function () {

			"use strict";
			
			// INITILIZE DATATABLE
			var table = $('#supportRequestsTable').DataTable({
				"lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
				responsive: true,
				colReorder: true,
				"order": [[ 5, "desc" ]],
				language: {
					"emptyTable": "<div><img id='no-results-img' src='<?php echo e(URL::asset('img/files/no-support.png')); ?>'><br><?php echo e(__('You have not created any support tickets yet')); ?></div>",
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
				ajax: "<?php echo e(route('user.support')); ?>",
				columns: [
					{
						data: 'custom-ticket',
						name: 'custom-ticket',
						orderable: true,
						searchable: true
					},
					{
						data: 'custom-status',
						name: 'custom-status',
						orderable: true,
						searchable: true
					},			
					{
						data: 'custom-category',
						name: 'custom-category',
						orderable: true,
						searchable: true
					},
					{
						data: 'custom-subject',
						name: 'custom-subject',						
						orderable: false,
						searchable: true
					},
					{
						data: 'custom-priority',
						name: 'custom-priority',
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
						data: 'resolved-on',
						name: 'resolved-on',
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

			
			// DELETE CONFIRMATION 
			$(document).on('click', '.deleteNotificationButton', function(e) {

				e.preventDefault();

				Swal.fire({
					title: '<?php echo e(__('Confirm Ticket Deletion')); ?>',
					text: '<?php echo e(__('It will permanently delete selected support ticket')); ?>',
					icon: 'warning',
					showCancelButton: true,
					confirmButtonText: '<?php echo e(__('Delete')); ?>',
					reverseButtons: true,
				}).then((result) => {
					if (result.isConfirmed) {
						var formData = new FormData();
						formData.append("id", $(this).attr('id'));
						$.ajax({
							headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
							method: 'post',
							url: 'support/delete',
							data: formData,
							processData: false,
							contentType: false,
							success: function (data) {
								if (data == 'success') {
									Swal.fire('<?php echo e(__('Support Ticket Deleted')); ?>', '<?php echo e(__('Support ticket has been successfully deleted')); ?>', 'success');	
									$("#supportRequestsTable").DataTable().ajax.reload();								
								} else {
									Swal.fire('<?php echo e(__('Delete Failed')); ?>', '<?php echo e(__('There was an error while deleting this support ticket')); ?>', 'error');
								}      
							},
							error: function(data) {
								Swal.fire({ type: 'error', title: 'Oops...', text: '<?php echo e(__('Something went wrong!')); ?>' })
							}
						})
					} 
				})
			});
		});
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ku52g0exgkyh/public_html/resources/views/user/support/index.blade.php ENDPATH**/ ?>