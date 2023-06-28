<?php $__env->startSection('page-header'); ?>
    <!-- PAGE HEADER -->
    <div class="page-header mt-5-7">
        <div class="page-leftheader">
            <h4 class="page-title mb-0"><?php echo e(__('Affiliate Program')); ?></h4>
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="<?php echo e(route('user.dashboard')); ?>"><i
                            class="fa-solid fa-badge-dollar mr-2 fs-12"></i><?php echo e(__('User')); ?></a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="<?php echo e(route('user.referral')); ?>">
                        <?php echo e(__('Affiliate Program')); ?></a></li>
            </ol>
        </div>
    </div>
    <!-- END PAGE HEADER -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    
    <div class="row">
        <div class="col-lg-6 col-md-12 col-xm-12">
            <div class="card overflow-hidden border-0">
                <div class="card-body pt-7 pb-6">
                    <h3 class="card-title fs-20 text-center"><?php echo e(__('Affiliate Program')); ?></h3>
                    <p class="fs-12 text-center pl-6 pr-6 mb-6"><?php echo e($referral['referral_headline']); ?></p>

                    <div class="row text-center justify-content-md-center">
                        <div class="col-md-3 col-sm-12 referral-box special-shadow">
                            <div><i class="fa-solid fa-user-group fs-25"></i></div>
                            <a class="fs-12 font-weight-bold"
                                href="<?php echo e(route('user.referral.referrals')); ?>"><?php echo e(__('My Referrals')); ?></a>
                        </div>
                        <div class="col-md-3 col-sm-12 referral-box special-shadow">
                            <div><i class="fa-solid fa-money-check-dollar-pen fs-25"></i></div>
                            <a class="fs-12 font-weight-bold"
                                href="<?php echo e(route('user.referral.payout')); ?>"><?php echo e(__('My Payouts')); ?></a>
                        </div>
                        <div class="col-md-3 col-sm-12 referral-box special-shadow">
                            <div><i class="fa-solid fa-wallet fs-25"></i></div>
                            <a class="fs-12 font-weight-bold"
                                href="<?php echo e(route('user.referral.gateway')); ?>"><?php echo e(__('My Gateways')); ?></a>
                        </div>
                    </div>

                    <div class="row mt-7 ml-4 mr-4">
                        <div class="col-md-12 col-sm-12">
                            <div class="input-box">
                                <h6 class="fs-12 font-weight-bold poppins"><?php echo e(__('My Referral URL')); ?></h6>
                                <div class="form-group d-flex referral-social-icons">
                                    <input type="text" class="form-control" id="email" readonly
                                        value="<?php echo e(url('/register')); ?>/?ref=<?php echo e(auth()->user()->referral_id); ?>">
                                    <div class="ml-2">
                                        <a href="" class="btn create-project pb-2" id="actions-copy"
                                            data-link="<?php echo e(url('/register')); ?>/?ref=<?php echo e(auth()->user()->referral_id); ?>"
                                            data-tippy-content="Copy Referral Link"><i class="fa fa-link"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-5 ml-4 mr-4">
                        <div class="col-md-6 col-sm-12">
                            <div class="input-box">
                                <h6 class="fs-12 font-weight-bold poppins"><?php echo e(__('My Earned Commissions')); ?></h6>
                                <p class="fs-12">
                                    <?php echo config('payment.default_system_currency_symbol'); ?><?php echo e(number_format((float) $total_commission[0]['data'], 2, '.', '')); ?>

                                    <?php echo e(config('payment.default_currency')); ?></p>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="input-box">
                                <h6 class="fs-12 font-weight-bold poppins"><?php echo e(__('Referral Commission Rate')); ?></h6>
                                <p class="fs-12">
                                    <?php echo e(auth()->user()->afl_mark == 0? auth()->user()->afl()->afl_user: auth()->user()->afl_mark()); ?>%
                            </div>
                        </div>
                    </div>

                    <div class="row mt-5 ml-4 mr-4">
                        <div class="col-md-6 col-sm-12">
                            <div class="input-box">
                                <h6 class="fs-12 font-weight-bold poppins"><?php echo e(__('Referral Policy')); ?></h6>
                                <?php if(config('payment.referral.payment.policy') == 'first'): ?>
                                    <p class="fs-12"><?php echo e(__('First Successful Payment by Referred Person')); ?></p>
                                <?php else: ?>
                                    <p class="fs-12"><?php echo e(__('Every Successful Payment by Referred Person')); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-5 ml-4 mr-4">
                        <div class="col-md-12 col-sm-12">
                            <div class="input-box">
                                <h6 class="fs-12 font-weight-bold poppins mb-3"><?php echo e(__('Referral Guidelines')); ?></h6>
                                <pre class="fs-12 referral-guideline"><?php echo e($referral['referral_guideline']); ?></pre>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-12 col-xm-12">
            <div class="card overflow-hidden border-0">
                <div class="card-body pt-7 pb-6">
                    <h3 class="card-title fs-20 text-center"><?php echo e(__('How it Works')); ?></h3>

                    <div class="row text-center justify-content-md-center mt-7">
                        <div class="col-lg-3 col-md-3 col-sm-4">
                            <div class="referral-icon-user">
                                <i class="fa-solid fa-message-check"></i>
                                <h6 class="mt-3 fs-12 font-weight-bold"><?php echo e(__('Send Invitation')); ?></h6>
                                <p class="fs-12">
                                    <?php echo e(__('Send your referral link to your friends and tell them how cool is')); ?>

                                    <?php echo e(config('app.name')); ?>!</p>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-4">
                            <div class="referral-icon-user">
                                <i class="fa-solid fa-user-check"></i>
                                <h6 class="mt-2 fs-12 font-weight-bold"><?php echo e(__('Registration')); ?></h6>
                                <p class="fs-12"><?php echo e(__('Let them register using your referral link')); ?>.</p>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-4">
                            <div class="referral-icon-user">
                                <i class="fa-solid fa-badge-percent"></i>
                                <h6 class="mt-2 fs-12 font-weight-bold"><?php echo e(__('Get Commissions')); ?></h6>
                                <p class="fs-12"><?php echo e(__('Earn commission for their first subscription plan payments')); ?>!
                                </p>
                            </div>
                        </div>
                    </div>

                    <form id="" action="<?php echo e(route('user.referral.email')); ?>" method="post"
                        enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="row mt-6 ml-4 mr-4">
                            <div class="col-md-12">
                                <h6 class="fs-12 font-weight-bold"><?php echo e(__('Invite your friends')); ?></h6>
                                <div class="input-box">
                                    <h6><?php echo e(__('Insert your friends email address and send him an invitations to join')); ?>

                                        <?php echo e(config('app.name')); ?>!</h6>
                                    <div class="input-group file-browser">
                                        <input type="email"
                                            class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> border-right-0 browse-file"
                                            id="email" name="email" placeholder="Email address">
                                        <label class="input-group-btn">
                                            <button class="btn btn-primary special-btn" id="invite-friends-button">
                                                <?php echo e(__('Send')); ?>

                                            </button>
                                        </label>
                                    </div>
                                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="text-danger"><?php echo e($errors->first('email')); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <input type="text" name="subject"
                                    value="Introduction to join <?php echo e(config('app.name')); ?>" hidden>
                                <input type="text" name="message"
                                    value="I want to refer you to this awesome website that I'm using! You can register via this link: <?php echo e(url('/register')); ?>/?ref=<?php echo e(auth()->user()->referral_id); ?>"
                                    hidden>
                            </div>
                        </div>
                    </form>

                    <div class="row mt-6 ml-4 mr-4">
                        <h6 class="fs-12 ml-3 font-weight-bold"><?php echo e(__('Share the comunity referral link')); ?></h6>
                        <h6 class="fs-12 ml-3">
                            <?php echo e(__('You can also share your referral link by copying and sending it or sharing it on your social media profiles')); ?>.
                        </h6>
                        <?php if(!auth()->user()->is_am): ?>
                            <div class="col-md-8 col-sm-12">
                                <div class="input-box">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="email" readonly
                                            value="<?php echo e(url('/register')); ?>/?ref=<?php echo e(auth()->user()->referral_id); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12 referral-social-icons text-right">
                                <div class="actions-total">
                                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo e(url('/register')); ?>/?ref=<?php echo e(auth()->user()->referral_id); ?>&t=Registration Link"
                                        onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
                                        target="_blank" class="btn actions-total-buttons" id="actions-facebook"
                                        data-tippy-content="Share in Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                                    <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo e(url('/register')); ?>/?ref=<?php echo e(auth()->user()->referral_id); ?>&title=Registration Link"
                                        onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
                                        target="_blank" class="btn actions-total-buttons" id="actions-linkedin"
                                        data-tippy-content="Share in Linkedin"><i class="fa-brands fa-linkedin"></i></a>
                                    <a href="http://www.reddit.com/submit?url=<?php echo e(url('/register')); ?>/?ref=<?php echo e(auth()->user()->referral_id); ?>"
                                        onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
                                        target="_blank" class="btn actions-total-buttons" id="actions-reddit"
                                        data-tippy-content="Share in Reddit"><i class="fa-brands fa-reddit"></i></a>
                                    <a href="https://twitter.com/share?url=<?php echo e(url('/register')); ?>/?ref=<?php echo e(auth()->user()->referral_id); ?>&text=Registration Link"
                                        onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
                                        target="_blank" class="btn actions-total-buttons" id="actions-twitter"
                                        data-tippy-content="Share in Twitter"><i class="fa-brands fa-twitter"></i></a>
                                </div>
                            </div>
                        <?php else: ?>
                            <?php if($comunity->count() < 3): ?>
                                <div class="col-md-8 col-sm-12">
                                    <div class="input-box">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="email" readonly
                                                value="<?php echo e(url('/register')); ?>/?ref=<?php echo e(auth()->user()->referral_id); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 referral-social-icons text-right">
                                    <div class="actions-total">
                                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo e(url('/register')); ?>/?ref=<?php echo e(auth()->user()->referral_id); ?>&t=Registration Link"
                                            onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
                                            target="_blank" class="btn actions-total-buttons" id="actions-facebook"
                                            data-tippy-content="Share in Facebook"><i
                                                class="fa-brands fa-facebook-f"></i></a>
                                        <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo e(url('/register')); ?>/?ref=<?php echo e(auth()->user()->referral_id); ?>&title=Registration Link"
                                            onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
                                            target="_blank" class="btn actions-total-buttons" id="actions-linkedin"
                                            data-tippy-content="Share in Linkedin"><i
                                                class="fa-brands fa-linkedin"></i></a>
                                        <a href="http://www.reddit.com/submit?url=<?php echo e(url('/register')); ?>/?ref=<?php echo e(auth()->user()->referral_id); ?>"
                                            onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
                                            target="_blank" class="btn actions-total-buttons" id="actions-reddit"
                                            data-tippy-content="Share in Reddit"><i class="fa-brands fa-reddit"></i></a>
                                        <a href="https://twitter.com/share?url=<?php echo e(url('/register')); ?>/?ref=<?php echo e(auth()->user()->referral_id); ?>&text=Registration Link"
                                            onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
                                            target="_blank" class="btn actions-total-buttons" id="actions-twitter"
                                            data-tippy-content="Share in Twitter"><i class="fa-brands fa-twitter"></i></a>
                                    </div>
                                </div>
                                <div class="col-md-8 col-sm-12">
                                    <div class="input-box">
                                        <button class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal">add Comunity Link</button>
                                    </div>
                                </div>
                                
                                <div class="modal fade" id="exampleModal" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Comunity Link</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="<?php echo e(route('user.referral.comunity')); ?>" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <div class="modal-body">
                                                    <?php for($i = $comunity->count() + 1; $i < 4; $i++): ?>
                                                        <div class="form-group row mb-2">
                                                            <h6 class="fs-12  col-md-12">Link <?php echo e($i); ?></h6>
                                                            <div class="input-group col-md-12">
                                                                <input type="text" class="form-control sub_manag"
                                                                    name="name[]" placeholder="comunity name">
                                                            </div>

                                                        </div>
                                                    <?php endfor; ?>
                                                </div>
                                                <hr>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php $__currentLoopData = $comunity; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <hr>
                                <h5>Link <?php echo e($item->name); ?></h5>
                                <div class="col-md-8 col-sm-12">
                                    <div class="input-box">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="email" readonly
                                                value="<?php echo e(url('/register')); ?>/?ref=<?php echo e(auth()->user()->referral_id); ?>&com=<?php echo e($item->id); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 referral-social-icons text-right">
                                    <div class="actions-total">
                                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo e(url('/register')); ?>/?ref=<?php echo e(auth()->user()->referral_id); ?>&com=<?php echo e($item->id); ?>&t=Registration Link"
                                            onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
                                            target="_blank" class="btn actions-total-buttons" id="actions-facebook"
                                            data-tippy-content="Share in Facebook"><i
                                                class="fa-brands fa-facebook-f"></i></a>
                                        <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo e(url('/register')); ?>/?ref=<?php echo e(auth()->user()->referral_id); ?>&com=<?php echo e($item->id); ?>&title=Registration Link"
                                            onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
                                            target="_blank" class="btn actions-total-buttons" id="actions-linkedin"
                                            data-tippy-content="Share in Linkedin"><i
                                                class="fa-brands fa-linkedin"></i></a>
                                        <a href="http://www.reddit.com/submit?url=<?php echo e(url('/register')); ?>/?ref=<?php echo e(auth()->user()->referral_id); ?>&com=<?php echo e($item->id); ?>"
                                            onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
                                            target="_blank" class="btn actions-total-buttons" id="actions-reddit"
                                            data-tippy-content="Share in Reddit"><i class="fa-brands fa-reddit"></i></a>
                                        <a href="https://twitter.com/share?url=<?php echo e(url('/register')); ?>/?ref=<?php echo e(auth()->user()->referral_id); ?>&com=<?php echo e($item->id); ?>&text=Registration Link"
                                            onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
                                            target="_blank" class="btn actions-total-buttons" id="actions-twitter"
                                            data-tippy-content="Share in Twitter"><i class="fa-brands fa-twitter"></i></a>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>

                    </div>

                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <!-- Link Share JS -->
    <script src="<?php echo e(URL::asset('js/link-share.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/magic/resources/views/user/referrals/index.blade.php ENDPATH**/ ?>