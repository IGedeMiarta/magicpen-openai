

<?php $__env->startSection('page-header'); ?>
	<!-- PAGE HEADER -->
	<div class="page-header mt-5-7">
		<div class="page-leftheader">
			<h4 class="page-title mb-0"><?php echo e(__('New Support Request')); ?></h4>
			<ol class="breadcrumb mb-2">
				<li class="breadcrumb-item"><a href="<?php echo e(route('user.dashboard')); ?>"><i class="fa-solid fa-messages-question mr-2 fs-12"></i><?php echo e(__('User')); ?></a></li>
				<li class="breadcrumb-item" aria-current="page"><a href="<?php echo e(route('user.support')); ?>"> <?php echo e(__('Support Request')); ?></a></li>
				<li class="breadcrumb-item active" aria-current="page"><a href="<?php echo e(url('#')); ?>"> <?php echo e(__('Create Support Request')); ?></a></li>
			</ol>
		</div>
	</div>
	<!-- END PAGE HEADER -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>						
	<!-- SUPPORT REQUEST -->
	<div class="row">
		<div class="col-lg-9 col-md-9 col-sm-12">
			<div class="card overflow-hidden border-0">
				<div class="card-header">
					<h3 class="card-title"><?php echo e(__('Create Support Request')); ?></h3>
				</div>
				<div class="card-body pt-5">									
					<form id="" action="<?php echo e(route('user.support.store')); ?>" method="post" enctype="multipart/form-data">
						<?php echo csrf_field(); ?>

						<div class="row">

							<div class="col-lg-6 col-md-6 col-sm-12">				
								<div class="input-box">	
									<h6><?php echo e(__('Support Category')); ?> <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
									<select id="support-category" name="category" data-placeholder="<?php echo e(__('Select Support Case')); ?>:">			
										<option value="General Inquiry" selected><?php echo e(__('General Inquiry')); ?></option>
										<option value="Technical Inquiry"><?php echo e(__('Technical Issue')); ?></option>
										<option value="Billing Inquiry"><?php echo e(__('Billing Issue')); ?></option>
										<option value="Improvement Idea"><?php echo e(__('Improvement Idea')); ?></option>
										<option value="Feedback"><?php echo e(__('Feedback')); ?></option>
									</select>
									<?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
										<p class="text-danger"><?php echo e($errors->first('category')); ?></p>
									<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>	
								</div> 							
							</div>

							<div class="col-lg-6 col-md-6 col-sm-12">						
								<div class="input-box">	
									<h6><?php echo e(__('Support Priority')); ?> <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
									<select id="support-priority" name="priority" data-placeholder="<?php echo e(__('Select Support Case Priority')); ?>:">			
										<option value="Low" selected><?php echo e(__('Low')); ?></option>
										<option value="Normal"><?php echo e(__('Normal')); ?></option>
										<option value="High"><?php echo e(__('High')); ?></option>
										<option value="Critical"><?php echo e(__('Critical')); ?></option>
									</select>
									<?php $__errorArgs = ['priority'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
										<p class="text-danger"><?php echo e($errors->first('priority')); ?></p>
									<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>	
								</div>						
							</div>
						
						</div>

						<div class="row mt-2">							
							<div class="col-lg-12 col-md-12 col-sm-12">							
								<div class="input-box">								
									<h6><?php echo e(__('Subject')); ?> <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
									<div class="form-group">							    
										<input type="text" class="form-control" id="subject" name="subject" required>
									</div> 
									<?php $__errorArgs = ['subject'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
										<p class="text-danger"><?php echo e($errors->first('subject')); ?></p>
									<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>	
								</div> 						
							</div>
						</div>

						<div class="row mt-2">							
							<div class="col-lg-12 col-md-12 col-sm-12">							
								<div class="input-box">
									<div class="input-group file-browser">	
										<h6><?php echo e(__('Attach File')); ?> <span class="text-muted fs-12">(<?php echo e(__('JPG | JPEG | PNG')); ?>)</h6>								
										<input type="text" class="form-control border-right-0 browse-file" placeholder="Include attachment file..." style="margin-right: 80px;" readonly>
										<label class="input-group-btn mt-4">
											<span class="btn btn-primary special-btn">
												<?php echo e(__('Browse')); ?> <input type="file" name="attachment" style="display: none;">
											</span>
										</label>
									</div>	
									<?php $__errorArgs = ['attachment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
										<p class="text-danger"><?php echo e($errors->first('attachment')); ?></p>
									<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
								</div> 						
							</div>
						</div>	

						<div class="row mt-2">
							<div class="col-lg-12 col-md-12 col-sm-12">	
								<div class="input-box">	
									<h6><?php echo e(__('Support Message')); ?> <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>							
									<textarea class="form-control" name="message" rows="10"></textarea>
									<?php $__errorArgs = ['message'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
										<p class="text-danger"><?php echo e($errors->first('message')); ?></p>
									<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>	
								</div>											
							</div>
						</div>

						<!-- ACTION BUTTON -->
						<div class="border-0 text-right mb-2 mt-1">
							<a href="<?php echo e(route('user.support')); ?>" class="btn btn-cancel mr-2"><?php echo e(__('Cancel')); ?></a>
							<button type="submit" class="btn btn-primary"><?php echo e(__('Send')); ?></button>							
						</div>				

					</form>					
				</div>
			</div>
		</div>
	</div>
	<!-- END SUPPORT REQUEST -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
	<script src="<?php echo e(URL::asset('js/avatar.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ku52g0exgkyh/public_html/resources/views/user/support/create.blade.php ENDPATH**/ ?>