@extends('layouts.app')

@section('page-header')
    <!-- PAGE HEADER -->
    <div class="page-header mt-5-7">
        <div class="page-leftheader">
            <h4 class="page-title mb-0">{{ __('Affiliate Program') }}</h4>
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}"><i
                            class="fa-solid fa-badge-dollar mr-2 fs-12"></i>{{ __('User') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('user.referral') }}">
                        {{ __('Affiliate Program') }}</a></li>
            </ol>
        </div>
    </div>
    <!-- END PAGE HEADER -->
@endsection

@section('content')
    {{-- <h5>Lorem ipsum dolor sit amet consectetur adipisicing elit. Possimus, assumenda.</h5> --}}
    <div class="row">
        <div class="col-lg-6 col-md-12 col-xm-12">
            <div class="card overflow-hidden border-0">
                <div class="card-body pt-7 pb-6">
                    <h3 class="card-title fs-20 text-center">{{ __('Affiliate Program') }}</h3>
                    <p class="fs-12 text-center pl-6 pr-6 mb-6">{{ $referral['referral_headline'] }}</p>

                    <div class="row text-center justify-content-md-center">
                        <div class="col-md-3 col-sm-12 referral-box special-shadow">
                            <div><i class="fa-solid fa-user-group fs-25"></i></div>
                            <a class="fs-12 font-weight-bold"
                                href="{{ route('user.referral.referrals') }}">{{ __('My Referrals') }}</a>
                        </div>
                        <div class="col-md-3 col-sm-12 referral-box special-shadow">
                            <div><i class="fa-solid fa-money-check-dollar-pen fs-25"></i></div>
                            <a class="fs-12 font-weight-bold"
                                href="{{ route('user.referral.payout') }}">{{ __('My Payouts') }}</a>
                        </div>
                        <div class="col-md-3 col-sm-12 referral-box special-shadow">
                            <div><i class="fa-solid fa-wallet fs-25"></i></div>
                            <a class="fs-12 font-weight-bold"
                                href="{{ route('user.referral.gateway') }}">{{ __('My Gateways') }}</a>
                        </div>
                    </div>

                    <div class="row mt-7 ml-4 mr-4">
                        <div class="col-md-12 col-sm-12">
                            <div class="input-box">
                                <h6 class="fs-12 font-weight-bold poppins">{{ __('My Referral URL') }}</h6>
                                <div class="form-group d-flex referral-social-icons">
                                    <input type="text" class="form-control" id="email" readonly
                                        value="{{ url('/register') }}/?ref={{ auth()->user()->referral_id }}">
                                    <div class="ml-2">
                                        <a href="" class="btn create-project pb-2" id="actions-copy"
                                            data-link="{{ url('/register') }}/?ref={{ auth()->user()->referral_id }}"
                                            data-tippy-content="Copy Referral Link"><i class="fa fa-link"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-5 ml-4 mr-4">
                        <div class="col-md-6 col-sm-12">
                            <div class="input-box">
                                <h6 class="fs-12 font-weight-bold poppins">{{ __('My Earned Commissions') }}</h6>
                                <p class="fs-12">
                                    {!! config('payment.default_system_currency_symbol') !!}{{ number_format((float) $total_commission[0]['data'], 2, '.', '') }}
                                    {{ config('payment.default_currency') }}</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="input-box">
                                <h6 class="fs-12 font-weight-bold poppins">{{ __('Referral Commission Rate') }}</h6>
                                <p class="fs-12">
                                    {{ auth()->user()->afl_mark == 0? auth()->user()->afl()->afl_user: auth()->user()->afl_mark() }}%
                            </div>
                        </div>
                    </div>

                    <div class="row mt-5 ml-4 mr-4">
                        <div class="col-md-6 col-sm-12">
                            <div class="input-box">
                                <h6 class="fs-12 font-weight-bold poppins">{{ __('Referral Policy') }}</h6>
                                @if (config('payment.referral.payment.policy') == 'first')
                                    <p class="fs-12">{{ __('First Successful Payment by Referred Person') }}</p>
                                @else
                                    <p class="fs-12">{{ __('Every Successful Payment by Referred Person') }}</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row mt-5 ml-4 mr-4">
                        <div class="col-md-12 col-sm-12">
                            <div class="input-box">
                                <h6 class="fs-12 font-weight-bold poppins mb-3">{{ __('Referral Guidelines') }}</h6>
                                <pre class="fs-12 referral-guideline">{{ $referral['referral_guideline'] }}</pre>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-12 col-xm-12">
            <div class="card overflow-hidden border-0">
                <div class="card-body pt-7 pb-6">
                    <h3 class="card-title fs-20 text-center">{{ __('How it Works') }}</h3>

                    <div class="row text-center justify-content-md-center mt-7">
                        <div class="col-lg-3 col-md-3 col-sm-4">
                            <div class="referral-icon-user">
                                <i class="fa-solid fa-message-check"></i>
                                <h6 class="mt-3 fs-12 font-weight-bold">{{ __('Send Invitation') }}</h6>
                                <p class="fs-12">
                                    {{ __('Send your referral link to your friends and tell them how cool is') }}
                                    {{ config('app.name') }}!</p>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-4">
                            <div class="referral-icon-user">
                                <i class="fa-solid fa-user-check"></i>
                                <h6 class="mt-2 fs-12 font-weight-bold">{{ __('Registration') }}</h6>
                                <p class="fs-12">{{ __('Let them register using your referral link') }}.</p>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-4">
                            <div class="referral-icon-user">
                                <i class="fa-solid fa-badge-percent"></i>
                                <h6 class="mt-2 fs-12 font-weight-bold">{{ __('Get Commissions') }}</h6>
                                <p class="fs-12">{{ __('Earn commission for their first subscription plan payments') }}!
                                </p>
                            </div>
                        </div>
                    </div>

                    <form id="" action="{{ route('user.referral.email') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row mt-6 ml-4 mr-4">
                            <div class="col-md-12">
                                <h6 class="fs-12 font-weight-bold">{{ __('Invite your friends') }}</h6>
                                <div class="input-box">
                                    <h6>{{ __('Insert your friends email address and send him an invitations to join') }}
                                        {{ config('app.name') }}!</h6>
                                    <div class="input-group file-browser">
                                        <input type="email"
                                            class="form-control @error('email') is-danger @enderror border-right-0 browse-file"
                                            id="email" name="email" placeholder="Email address">
                                        <label class="input-group-btn">
                                            <button class="btn btn-primary special-btn" id="invite-friends-button">
                                                {{ __('Send') }}
                                            </button>
                                        </label>
                                    </div>
                                    @error('email')
                                        <p class="text-danger">{{ $errors->first('email') }}</p>
                                    @enderror
                                </div>

                                <input type="text" name="subject"
                                    value="Introduction to join {{ config('app.name') }}" hidden>
                                <input type="text" name="message"
                                    value="I want to refer you to this awesome website that I'm using! You can register via this link: {{ url('/register') }}/?ref={{ auth()->user()->referral_id }}"
                                    hidden>
                            </div>
                        </div>
                    </form>

                    <div class="row mt-6 ml-4 mr-4">
                        <h6 class="fs-12 ml-3 font-weight-bold">{{ __('Share the comunity referral link') }}</h6>
                        <h6 class="fs-12 ml-3">
                            {{ __('You can also share your referral link by copying and sending it or sharing it on your social media profiles') }}.
                        </h6>
                        @if (!auth()->user()->is_am)
                            <div class="col-md-8 col-sm-12">
                                <div class="input-box">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="email" readonly
                                            value="{{ url('/register') }}/?ref={{ auth()->user()->referral_id }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12 referral-social-icons text-right">
                                <div class="actions-total">
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ url('/register') }}/?ref={{ auth()->user()->referral_id }}&t=Registration Link"
                                        onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
                                        target="_blank" class="btn actions-total-buttons" id="actions-facebook"
                                        data-tippy-content="Share in Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                                    <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ url('/register') }}/?ref={{ auth()->user()->referral_id }}&title=Registration Link"
                                        onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
                                        target="_blank" class="btn actions-total-buttons" id="actions-linkedin"
                                        data-tippy-content="Share in Linkedin"><i class="fa-brands fa-linkedin"></i></a>
                                    <a href="http://www.reddit.com/submit?url={{ url('/register') }}/?ref={{ auth()->user()->referral_id }}"
                                        onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
                                        target="_blank" class="btn actions-total-buttons" id="actions-reddit"
                                        data-tippy-content="Share in Reddit"><i class="fa-brands fa-reddit"></i></a>
                                    <a href="https://twitter.com/share?url={{ url('/register') }}/?ref={{ auth()->user()->referral_id }}&text=Registration Link"
                                        onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
                                        target="_blank" class="btn actions-total-buttons" id="actions-twitter"
                                        data-tippy-content="Share in Twitter"><i class="fa-brands fa-twitter"></i></a>
                                </div>
                            </div>
                        @else
                            @if ($comunity->count() < 3)
                                <div class="col-md-8 col-sm-12">
                                    <div class="input-box">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="email" readonly
                                                value="{{ url('/register') }}/?ref={{ auth()->user()->referral_id }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 referral-social-icons text-right">
                                    <div class="actions-total">
                                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ url('/register') }}/?ref={{ auth()->user()->referral_id }}&t=Registration Link"
                                            onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
                                            target="_blank" class="btn actions-total-buttons" id="actions-facebook"
                                            data-tippy-content="Share in Facebook"><i
                                                class="fa-brands fa-facebook-f"></i></a>
                                        <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ url('/register') }}/?ref={{ auth()->user()->referral_id }}&title=Registration Link"
                                            onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
                                            target="_blank" class="btn actions-total-buttons" id="actions-linkedin"
                                            data-tippy-content="Share in Linkedin"><i
                                                class="fa-brands fa-linkedin"></i></a>
                                        <a href="http://www.reddit.com/submit?url={{ url('/register') }}/?ref={{ auth()->user()->referral_id }}"
                                            onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
                                            target="_blank" class="btn actions-total-buttons" id="actions-reddit"
                                            data-tippy-content="Share in Reddit"><i class="fa-brands fa-reddit"></i></a>
                                        <a href="https://twitter.com/share?url={{ url('/register') }}/?ref={{ auth()->user()->referral_id }}&text=Registration Link"
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
                                {{-- modal add link comunity --}}
                                <div class="modal fade" id="exampleModal" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Comunity Link</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('user.referral.comunity') }}" method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    @for ($i = $comunity->count() + 1; $i < 4; $i++)
                                                        <div class="form-group row mb-2">
                                                            <h6 class="fs-12  col-md-12">Link {{ $i }}</h6>
                                                            <div class="input-group col-md-12">
                                                                <input type="text" class="form-control sub_manag"
                                                                    name="name[]" placeholder="comunity name">
                                                            </div>

                                                        </div>
                                                    @endfor
                                                </div>
                                                <hr>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            @endif
                            @foreach ($comunity as $item)
                                <hr>
                                <h5>Link {{ $item->name }}</h5>
                                <div class="col-md-8 col-sm-12">
                                    <div class="input-box">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="email" readonly
                                                value="{{ url('/register') }}/?ref={{ auth()->user()->referral_id }}&com={{ $item->id }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 referral-social-icons text-right">
                                    <div class="actions-total">
                                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ url('/register') }}/?ref={{ auth()->user()->referral_id }}&com={{ $item->id }}&t=Registration Link"
                                            onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
                                            target="_blank" class="btn actions-total-buttons" id="actions-facebook"
                                            data-tippy-content="Share in Facebook"><i
                                                class="fa-brands fa-facebook-f"></i></a>
                                        <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ url('/register') }}/?ref={{ auth()->user()->referral_id }}&com={{ $item->id }}&title=Registration Link"
                                            onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
                                            target="_blank" class="btn actions-total-buttons" id="actions-linkedin"
                                            data-tippy-content="Share in Linkedin"><i
                                                class="fa-brands fa-linkedin"></i></a>
                                        <a href="http://www.reddit.com/submit?url={{ url('/register') }}/?ref={{ auth()->user()->referral_id }}&com={{ $item->id }}"
                                            onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
                                            target="_blank" class="btn actions-total-buttons" id="actions-reddit"
                                            data-tippy-content="Share in Reddit"><i class="fa-brands fa-reddit"></i></a>
                                        <a href="https://twitter.com/share?url={{ url('/register') }}/?ref={{ auth()->user()->referral_id }}&com={{ $item->id }}&text=Registration Link"
                                            onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
                                            target="_blank" class="btn actions-total-buttons" id="actions-twitter"
                                            data-tippy-content="Share in Twitter"><i class="fa-brands fa-twitter"></i></a>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <!-- Link Share JS -->
    <script src="{{ URL::asset('js/link-share.js') }}"></script>
@endsection
