

<?php $__env->startSection('content'); ?>
<div class="container-fluid justify-content-center">
    <div class="row h-100vh align-items-center background-white">
        <div class="col-md-7 col-sm-12 text-center background-special h-100 align-middle p-0" id="login-background">
            <div class="login-bg"></div>
        </div>

        <div class="col-md-5 col-sm-12 h-100" id="login-responsive">                
            <div class="card-body pr-10 pl-10 pt-10">

                <h3 class="text-center font-weight-bold mb-8"><?php echo e(__('Welcome to')); ?> <span class="text-info"><?php echo e(config('app.name')); ?></span></h3>

                <?php if($message = Session::get('success')): ?>
                    <div class="alert alert-login alert-success"> 
                        <strong><i class="fa fa-check-circle"></i> <?php echo e($message); ?></strong>
                    </div>
                    <?php endif; ?>

                    <?php if($message = Session::get('error')): ?>
                    <div class="alert alert-login alert-danger">
                        <strong><i class="fa fa-exclamation-triangle"></i> <?php echo e($message); ?></strong>
                    </div>
                <?php endif; ?>

                <form method="POST" action="<?php echo e(route('password.update')); ?>">
                    <?php echo csrf_field(); ?>       

                    <!-- Password Reset Token -->
                    <input type="hidden" name="token" value="<?php echo e($request->route('token')); ?>">
                    
                    <div class="divider">
                        <div class="divider-text text-muted">
                            <small><?php echo e(__('Provide a New Password')); ?></small>
                        </div>
                    </div>

                    <div class="input-box">                             
                        <label for="email" class="fs-12 font-weight-bold text-md-right"><?php echo e(__('Email Address')); ?></label>
                        <input id="email" type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="email" value="<?php echo e(old('email')); ?>" autocomplete="off"  placeholder="Email Address" required>
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="invalid-feedback" role="alert">
                                <?php echo e($message); ?>

                            </span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>                            
                    </div>

                    <div class="input-box">                            
                        <label for="password" class="fs-12 font-weight-bold text-md-right"><?php echo e(__('Password')); ?></label>
                        <input id="password" type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="password" required autocomplete="off" placeholder="Password">
                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="invalid-feedback" role="alert">
                                <?php echo e($message); ?>

                            </span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>                            
                    </div>

                    <div class="input-box">
                        <label for="password-confirm" class="fs-12 font-weight-bold text-md-right"><?php echo e(__('Confirm Password')); ?></label>                       
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="off" placeholder="Confirm Password">                        
                    </div>
                    
                    <div class="form-group mb-0 text-center">                        
                        <button type="submit" class="btn btn-primary mr-2"><?php echo e(__('Reset Password')); ?></button>                                                     
                    </div>

                </form>
            </div>       
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ku52g0exgkyh/public_html/resources/views/auth/password/reset-password.blade.php ENDPATH**/ ?>