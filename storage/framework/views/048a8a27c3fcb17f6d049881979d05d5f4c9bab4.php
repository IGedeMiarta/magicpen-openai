

<?php $__env->startSection('css'); ?>
	<!-- Telephone Input CSS -->
	<link href="<?php echo e(URL::asset('plugins/telephoneinput/telephoneinput.css')); ?>" rel="stylesheet" >
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-header'); ?>
	<!-- EDIT PAGE HEADER -->
	<div class="page-header mt-5-7">
		<div class="page-leftheader">
			<h4 class="page-title mb-0"><?php echo e(__('Set Defaults')); ?></h4>
			<ol class="breadcrumb mb-2">
				<li class="breadcrumb-item"><a href="<?php echo e(route('user.dashboard')); ?>"><i class="fa-solid fa-id-badge mr-2 fs-12"></i><?php echo e(__('User')); ?></a></li>
				<li class="breadcrumb-item" aria-current="page"><a href="<?php echo e(route('user.profile')); ?>"> <?php echo e(__('My Profile')); ?></a></li>
				<li class="breadcrumb-item active" aria-current="page"><a href="<?php echo e(url('#')); ?>"> <?php echo e(__('Set Defaults')); ?></a></li>
			</ol>
		</div>
	</div>
	<!-- END PAGE HEADER -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
	<!-- EDIT USER PROFILE PAGE -->
	<div class="row">
		<div class="col-xl-3 col-lg-4 col-sm-12">
			<div class="card border-0" id="dashboard-background">
				<div class="widget-user-image overflow-hidden mx-auto mt-5"><img alt="User Avatar" class="rounded-circle" src="<?php if(auth()->user()->profile_photo_path): ?><?php echo e(asset(auth()->user()->profile_photo_path)); ?> <?php else: ?> <?php echo e(URL::asset('img/users/avatar.jpg')); ?> <?php endif; ?>"></div>
				<div class="card-body text-center">
					<div>
						<h4 class="mb-1 mt-1 font-weight-bold text-primary fs-16"><?php echo e(auth()->user()->name); ?></h4>
						<h6 class="text-white fs-12"><?php echo e(auth()->user()->job_role); ?></h6>
					</div>
				</div>
				<div class="card-footer p-0">
					<div class="row">
						<div class="col-sm-12">
							<div class="text-center p-4">
								<div class="d-flex w-100">
									<div class="flex w-100">
										<div class="flex w-100">
											<h4 class="mb-3 mt-1 font-weight-800 text-primary text-shadow fs-16"><?php echo e(number_format(auth()->user()->available_words + auth()->user()->available_words_prepaid)); ?> / <?php echo e(number_format(auth()->user()->total_words)); ?></h4>
											<h6 class="text-white fs-12 text-shadow"><?php echo e(__('Words Left')); ?></h6>
										</div>
										<div class="flex w-100 mt-4">
											<h4 class="mb-3 mt-1 font-weight-800 text-primary text-shadow fs-16"><?php echo e(number_format(auth()->user()->available_images + auth()->user()->available_images_prepaid)); ?> / <?php echo e(number_format(auth()->user()->total_images)); ?></h4>
											<h6 class="text-white fs-12 text-shadow"><?php echo e(__('Images Left')); ?></h6>
										</div>
									</div>
									<div class="flex w-100">
										<div class="flex w-100">
											<h4 class="mb-3 mt-1 font-weight-800 text-primary text-shadow fs-16"><?php echo e(number_format(auth()->user()->available_chars + auth()->user()->available_chars_prepaid)); ?> / <?php echo e(number_format(auth()->user()->total_chars)); ?></h4>
											<h6 class="text-white fs-12 text-shadow"><?php echo e(__('Characters Left')); ?></h6>
										</div>
										<div class="flex w-100 mt-4">
											<h4 class="mb-3 mt-1 font-weight-800 text-primary text-shadow fs-16"><?php echo e(number_format(auth()->user()->available_minutes + auth()->user()->available_minutes_prepaid)); ?> / <?php echo e(number_format(auth()->user()->total_minutes)); ?></h4>
											<h6 class="text-white fs-12 text-shadow"><?php echo e(__('Minutes Left')); ?></h6>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card-footer p-0">
					<div class="row" id="profile-pages">
						<div class="col-sm-12">
							<div class="text-center pt-4">
								<a href="<?php echo e(route('user.profile')); ?>" class="fs-13 text-white"><i class="fa fa-user-shield mr-1"></i> <?php echo e(__('View Profile')); ?></a>
							</div>
						</div>
						<div class="col-sm-12">
							<div class="text-center pt-3">
								<a href="<?php echo e(route('user.profile.defaults')); ?>" class="fs-13 text-primary"><i class="fa-sharp fa-solid fa-sliders mr-1"></i> <?php echo e(__('Set Defaults')); ?></a>
							</div>
						</div>
						<div class="col-sm-12">
							<div class="text-center p-3 ">
								<a href="<?php echo e(route('user.security')); ?>" class="fs-13 text-white"><i class="fa fa-lock-hashtag mr-1"></i> <?php echo e(__('Change Password')); ?></a>
							</div>
						</div>
						<div class="col-sm-12">
							<div class="text-center pb-4">
								<a href="<?php echo e(route('user.security.2fa')); ?>" class="fs-13 text-white"><i class="fa fa-shield-check mr-1"></i> <?php echo e(__('2FA Authentication')); ?></a>
							</div>
						</div>
						<div class="col-sm-12">
							<div class="text-center pb-4">
								<a href="<?php echo e(route('user.profile.delete')); ?>" class="fs-13 text-white"><i class="fa fa-user-xmark mr-1"></i> <?php echo e(__('Delete Account')); ?></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-xl-9 col-lg-8 col-sm-12">
			<form method="POST" class="w-100" action="<?php echo e(route('user.profile.update.defaults', [auth()->user()->id])); ?>" enctype="multipart/form-data">
				<?php echo method_field('PUT'); ?>
				<?php echo csrf_field(); ?>

				<div class="card border-0">
					<div class="card-header">
						<h3 class="card-title"><i class="fa-sharp fa-solid fa-sliders mr-2 text-primary"></i><?php echo e(__('Set Defaults')); ?></h3>
					</div>
					<div class="card-body pb-0">					
						<div class="row">
							<div class="col-md-6 col-sm-12">
								<!-- LANGUAGE -->
								<div class="input-box">	
									<h6><?php echo e(__('Default AI Voiceover Studio Language')); ?></h6>
									<select id="languages" name="default_voiceover_language" data-placeholder="<?php echo e(__('Select AI Voiceover Default Language')); ?>" data-callback="language_select">			
										<?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<option value="<?php echo e($language->language_code); ?>" data-img="<?php echo e(URL::asset($language->language_flag)); ?>" <?php if(auth()->user()->default_voiceover_language == $language->language_code): ?> selected <?php endif; ?>> <?php echo e($language->language); ?></option>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</select>
								</div> <!-- END LANGUAGE -->
							</div>

							<div class="col-md-6 col-sm-12">
								<!-- VOICE -->
								<div class="input-box">	
									<h6><?php echo e(__('Default AI Voiceover Studio Voice')); ?></h6>
									<select id="voices" name="default_voiceover_voice" data-placeholder="<?php echo e(__('Select Default Voice')); ?>">			
										<?php $__currentLoopData = $voices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $voice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<option value="<?php echo e($voice->voice_id); ?>" 		
												data-img="<?php echo e(URL::asset($voice->avatar_url)); ?>"										
												data-id="<?php echo e($voice->voice_id); ?>" 
												data-lang="<?php echo e($voice->language_code); ?>" 
												data-type="<?php echo e($voice->voice_type); ?>"
												data-gender="<?php echo e($voice->gender); ?>"																						
												<?php if(auth()->user()->default_voiceover_voice == $voice->voice_id): ?> selected <?php endif; ?>
												data-class="<?php if(auth()->user()->language !== $voice->language_code): ?> remove-voice <?php endif; ?>"> 
												<?php echo e($voice->voice); ?>  														
											</option>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</select>
								</div> <!-- END VOICE -->
							</div>
						</div>
						<div class="card-footer border-0 text-right mb-2 pr-0">
							<button type="submit" class="btn btn-primary"><?php echo e(__('Save')); ?></button>							
						</div>					
					</div>				
				</div>
			</form>
		</div>
	</div>
	<!-- EDIT USER PROFILE PAGE --> 
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
	<script src="<?php echo e(URL::asset('js/admin-config.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ku52g0exgkyh/public_html/resources/views/user/profile/default.blade.php ENDPATH**/ ?>