<?php $__env->startSection('css'); ?>
    <!-- Data Table CSS -->
    <link href="<?php echo e(URL::asset('plugins/datatable/datatables.min.css')); ?>" rel="stylesheet" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-header'); ?>
    <!-- PAGE HEADER -->
    <div class="page-header mt-5-7">
        <div class="page-leftheader">
            <h4 class="page-title mb-0"><?php echo e(__('Referral System')); ?></h4>
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>"><i
                            class="fa-solid fa-sack-dollar mr-2 fs-12"></i><?php echo e(__('Admin')); ?></a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="<?php echo e(route('admin.finance.dashboard')); ?>">
                        <?php echo e(__('Finance Management')); ?></a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="<?php echo e(url('#')); ?>">
                        <?php echo e(__('Referral System')); ?></a></li>
            </ol>
        </div>
    </div>
    <!-- END PAGE HEADER -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-lg-4 col-md-12 col-sm-12">
            <div class="card overflow-hidden border-0">
                <div class="card-body">
                    <i class="mdi mdi-account-multiple-plus text-primary fs-45 float-right"></i>
                    <p class=" mb-3 fs-12 font-weight-bold mt-1"><?php echo e(__('Total Referred Users')); ?> <span
                            class="text-muted">(<?php echo e(__('All Time')); ?>)</span></p>
                    <h2 class="mb-0"><span class="number-font-chars"><?php echo e(number_format($total_users[0]['data'])); ?></span>
                    </h2>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-12 col-sm-12">
            <div class="card border-0">
                <div class="card-body">
                    <i class="mdi mdi-basket-fill text-success fs-45 float-right"></i>
                    <p class=" mb-3 fs-12 font-weight-bold mt-1"><?php echo e(__('Total Referral Income')); ?> <span
                            class="text-muted">(<?php echo e(__('All Time')); ?>)</span></p>
                    <h2 class="mb-0"><span
                            class="number-font-chars"><?php echo config('payment.default_system_currency_symbol'); ?><?php echo e(number_format((float) $total_income[0]['data'], 2, '.', '')); ?></span>
                    </h2>

                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-12 col-sm-12">
            <div class="card border-0">
                <div class="card-body">
                    <i class="mdi mdi-basket-unfill fs-45 text-danger float-right"></i>
                    <p class=" mb-3 fs-12 font-weight-bold mt-1"><?php echo e(__('Total Referral Commission')); ?> <span
                            class="text-muted">(<?php echo e(__('All Time')); ?>)</span></p>
                    <h2 class="mb-0"><span
                            class="number-font-chars"><?php echo config('payment.default_system_currency_symbol'); ?><?php echo e(number_format((float) $total_commission[0]['data'], 2, '.', '')); ?></span>
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-xm-12">
            <div class="card overflow-hidden border-0">
                <div class="card-header">
                    <h3 class="card-title"><?php echo e(__('Setup Referral System')); ?></h3>
                </div>

                

                <div class="card-body pt-2">
                    <div class="border-0 text-right mb-2 mt-1">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#exampleModal"><i class="fas fa-plus"></i> <?php echo e(__('add New')); ?></button>
                    </div>
                    <table id='distributeRefferals' class='table' width='100%'>
                        <thead>
                            <tr>
                                <th width="10%" class="fs-10"><?php echo e(__('Name')); ?></th>
                                <th width="10%" class="fs-10"><?php echo e(__('Affiliate Management')); ?></th>
                                <th width="10%" class="fs-10"><?php echo e(__('Sub Affiliate Management')); ?></th>
                                <th width="10%" class="fs-10"><?php echo e(__('User Affiliate')); ?></th>
                                <th width="10%" class="fs-10"><?php echo e(__('Option ')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $distribute; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($data->name); ?> <?php if($data->as_default): ?>
                                            <span class="badge rounded-corner bg-success">default</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e($data->manag); ?>%</td>
                                    <td><?php echo e($data->sub_manag); ?>%</td>
                                    <td><?php echo e($data->afl_user); ?>%</td>
                                    <td>
                                        <button class="btn btn-sm btn-warning btnEdit" data-id="<?php echo e($data->id); ?>"
                                            data-name="<?php echo e($data->name); ?>" data-manag="<?php echo e($data->manag); ?>"
                                            data-sub_manag="<?php echo e($data->sub_manag); ?>" data-afl_user="<?php echo e($data->afl_user); ?>"
                                            data-as_default="<?php echo e($data->as_default); ?>" data-bs-toggle="modal"
                                            data-bs-target="#editModal">
                                            Edit
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td class="text-muted text-center" colspan="100%"><?php echo e(__('Empty Data')); ?></td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table> <!-- END SET DATATABLE -->
                </div>
            </div>

        </div>

        <div class="col-lg-12 col-md-12 col-sm-12 no-gutters">
            <div class="col-sm-12">
                <div class="card overflow-hidden border-0">
                    <div class="card-header">
                        <h3 class="card-title"><?php echo e(__('Payment Referrals')); ?> <span
                                class="text-muted">(<?php echo e(__('All Time')); ?>)</span></h3>
                    </div>
                    <div class="card-body pt-2">
                        <!-- SET DATATABLE -->
                        <table id='paymentsReferralTable' class='table' width='100%'>
                            <thead>
                                <tr>
                                    <th width="10%" class="fs-10"><?php echo e(__('Purchase Date')); ?></th>
                                    <th width="12%" class="fs-10"><?php echo e(__('Order ID')); ?></th>
                                    <th width="10%" class="fs-10"><?php echo e(__('Referrer')); ?></th>
                                    <th width="10%" class="fs-10"><?php echo e(__('Payment')); ?>

                                        (<?php echo e(config('payment.default_system_currency')); ?>)</th>
                                    <th width="7%" class="fs-10"><?php echo e(__('Commission')); ?>

                                        (<?php echo e(config('payment.default_system_currency')); ?>)</th>
                                    <th width="7%" class="fs-10"><?php echo e(__('Paid By')); ?></th>
                                    <th width="5%" class="fs-10"><?php echo e(__('Actions')); ?></th>
                                </tr>
                            </thead>
                        </table> <!-- END SET DATATABLE -->
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="card overflow-hidden border-0">
                    <div class="card-header">
                        <h3 class="card-title"><?php echo e(__('Top Referrers')); ?> <span
                                class="text-muted">(<?php echo e(__('All Time')); ?>)</span></h3>
                    </div>
                    <div class="card-body pt-2">
                        <!-- SET DATATABLE -->
                        <table id='topReferralTable' class='table' width='100%'>
                            <thead>
                                <tr>
                                    <th width="10%" class="fs-10"><?php echo e(__('Referrer Name')); ?></th>
                                    <th width="10%" class="fs-10"><?php echo e(__('Referrer Email')); ?></th>
                                    <th width="10%" class="fs-10"><?php echo e(__('Referral ID')); ?></th>
                                    <th width="5%" class="fs-10"><?php echo e(__('Group')); ?></th>
                                    <th width="5%" class="fs-10"><?php echo e(__('# of Users')); ?></th>
                                    <th width="10%" class="fs-10"><?php echo e(__('Total Commissions')); ?>

                                        (<?php echo e(config('payment.default_system_currency')); ?>)</th>
                                </tr>
                            </thead>
                        </table> <!-- END SET DATATABLE -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Distibute Affiliate</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <hr>

                <form method="POST" action="<?php echo e(route('admin.referral.settings.new')); ?>">
                    <div class="modal-body">
                        <?php echo csrf_field(); ?>
                        <div class="form-group row mb-2">
                            <h6 class="fs-12 col-md-4">Name</h6>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="name" placeholder="custom_afilliate"
                                    required>
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <h6 class="fs-12 col-md-6"><?php echo e('Affiliate Management'); ?></h6>
                            <div class="input-group col-md-6">
                                <input type="number" class="form-control" name="manag" placeholder="15" required>
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <h6 class="fs-12  col-md-6"><?php echo e('Sub Affiliate Management'); ?></h6>
                            <div class="input-group col-md-6">
                                <input type="number" class="form-control" name="sub_manag" placeholder="15" required>
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <h6 class="fs-12  col-md-6"><?php echo e('User Affiliate'); ?></h6>
                            <div class="input-group col-md-6">
                                <input type="number" class="form-control" name="afl_user" placeholder="20" required>
                                <span class="input-group-text">%</span>
                            </div>
                        </div>

                    </div>
                    <hr>
                    <div class="modal-footer">
                        <!--<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>-->
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Distibute Affiliate</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <hr>
                <form method="post" action="<?php echo e(route('admin.referral.settings.update')); ?>">
                    <div class="modal-body">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="id" class="id">
                        <div class="form-group row mb-2">
                            <h6 class="fs-12 col-md-4">Name</h6>
                            <div class="col-md-8">
                                <input type="text" class="form-control name" name="name"
                                    placeholder="custom_afilliate">
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <h6 class="fs-12 col-md-6">Affiliate Management</h6>
                            <div class="input-group col-md-6">
                                <input type="number" class="form-control manag" name="manag" placeholder="15">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <h6 class="fs-12  col-md-6">Sub Affiliate Management</h6>
                            <div class="input-group col-md-6">
                                <input type="number" class="form-control sub_manag" name="sub_manag" placeholder="15">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <h6 class="fs-12  col-md-6">User Affiliate</h6>
                            <div class="input-group col-md-6">
                                <input type="number" class="form-control afl_user" name="afl_user" placeholder="20">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                        <div class="form-group row mb-2 defaultSet">
                            <h6 class="fs-12  col-md-6">Set As Default</h6>
                            <div class="input-group col-md-6">
                                <label class="custom-switch">
                                    <input type="checkbox" name="as_default" class="custom-switch-input" value="1">
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description">Set Default</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="modal-footer">
                        <!--<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>-->
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <!-- Data Tables JS -->
    <script src="<?php echo e(URL::asset('plugins/datatable/datatables.min.js')); ?>"></script>
    <script type="text/javascript">
        $(function() {

            "use strict";

            // INITILIZE DATATABLE
            var table = $('#paymentsReferralTable').DataTable({
                "lengthMenu": [
                    [25, 50, 100, -1],
                    [25, 50, 100, "All"]
                ],
                responsive: true,
                colReorder: true,
                "order": [
                    [0, "desc"]
                ],
                language: {
                    search: "<i class='fa fa-search search-icon'></i>",
                    lengthMenu: '_MENU_ ',
                    paginate: {
                        first: '<i class="fa fa-angle-double-left"></i>',
                        last: '<i class="fa fa-angle-double-right"></i>',
                        previous: '<i class="fa fa-angle-left"></i>',
                        next: '<i class="fa fa-angle-right"></i>'
                    }
                },
                pagingType: 'full_numbers',
                processing: true,
                serverSide: true,
                ajax: "<?php echo e(route('admin.referral.settings')); ?>",
                columns: [{
                        data: 'created-on',
                        name: 'created-on',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'order_id',
                        name: 'order_id',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'referrer_email',
                        name: 'referrer_email',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'custom-payment',
                        name: 'custom-payment',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'custom-commission',
                        name: 'custom-commission',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'gateway',
                        name: 'gateway',
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


            // INITILIZE DATATABLE
            var table2 = $('#topReferralTable').DataTable({
                "lengthMenu": [
                    [25, 50, 100, -1],
                    [25, 50, 100, "All"]
                ],
                responsive: true,
                colReorder: true,
                "order": [
                    [4, "desc"]
                ],
                language: {
                    search: "<i class='fa fa-search search-icon'></i>",
                    lengthMenu: '_MENU_ ',
                    paginate: {
                        first: '<i class="fa fa-angle-double-left"></i>',
                        last: '<i class="fa fa-angle-double-right"></i>',
                        previous: '<i class="fa fa-angle-left"></i>',
                        next: '<i class="fa fa-angle-right"></i>'
                    }
                },
                pagingType: 'full_numbers',
                processing: true,
                serverSide: true,
                ajax: "<?php echo e(route('admin.referral.top')); ?>",
                columns: [{
                        data: 'name',
                        name: 'name',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'email',
                        name: 'email',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'referral_id',
                        name: 'referral_id',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'custom-group',
                        name: 'custom-group',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'total_referred',
                        name: 'total_referred',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'custom_total_commission',
                        name: 'custom_total_commission',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            $('.btnEdit').on('click', function() {
                const id = $(this).data('id');
                const name = $(this).data('name');
                const manag = $(this).data('manag');
                const sub_manag = $(this).data('sub_manag');
                const afl_user = $(this).data('afl_user');
                const as_default = $(this).data('as_default');

                if (as_default) {
                    $('.defaultSet').addClass('d-none');
                } else {
                    $('.defaultSet').removeClass('d-none');
                }
                $('.id').val(id);
                $('.name').val(name);
                $('.manag').val(manag);
                $('.sub_manag').val(sub_manag)
                $('.afl_user').val(afl_user)
                // alert('test');
            })
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ku52g0exgkyh/public_html/resources/views/admin/finance/referrals/index.blade.php ENDPATH**/ ?>