<style>
    .modal-content.radius-10 {
    border-radius: 10px;
    }

    .btn-sm {
        padding: 3px 10px;
        font-size: 13px;
    }

    .btn-icon {
        width: 40px;
        height: 40px;
        padding: 0;
        font-size: 18px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

</style>

<div class="profile-wrapper-item radius-10 display_profile_info">
    <div class="profile-wrapper-flex flex-between">
        <div class="profile-wrapper-author">
            <div class="profile-wrapper-author-flex d-flex gap-3">
                <div class="profile-wrapper-author-thumb position-relative">
                @if($user->image)
                    <a href="#/">
                        @if(cloudStorageExist() && in_array(Storage::getDefaultDriver(), ['s3', 'cloudFlareR2', 'wasabi']))
                            <img src="{{ render_frontend_cloud_image_if_module_exists( 'profile/'. $user->image, load_from: $user->load_from) }}" alt="{{ __('profile img') }}">
                        @else
                            <img src="{{ asset('assets/uploads/profile/'.$user->image) }}" alt="{{ __('profile img') }}">
                        @endif
                    </a>

                    @if(moduleExists('FreelancerLevel'))
                        @if(get_static_option('profile_page_badge_settings') == 'enable')
                            <div class="freelancer-level-badge position-absolute">
                                {!! freelancer_level($user->id,'talent') ?? '' !!}
                            </div>
                        @endif
                    @endif

                    {{-- Rated Plus only when custom image exists --}}
                    @php
                        $averageRating = round(optional($user->freelancer_ratings)->avg('rating'), 1);
                    @endphp

                    @if ($averageRating >= 4.5)
                        <div style="position: absolute; bottom: 0px; right: 0px; width: 50px; height: 50px; left: 58px; top: 30px;">
                            <img src="{{ asset('assets/uploads/profile/517042825771742805481.png') }}"
                                alt="Rated Plus Badge"
                                style="width: 100%; height: 100%;">
                            <span class="badge-title">Rated Plus</span>
                        </div>
                    @endif

                    @else
                        <a href="#/"><img src="{{ asset('assets/static/img/author/author.jpg') }}" alt="{{ __('AuthorImg') }}"></a>

                        @if(moduleExists('FreelancerLevel'))
                            @if(get_static_option('profile_page_badge_settings') == 'enable')
                                <div class="freelancer-level-badge position-absolute">
                                    {!! freelancer_level($user->id,'talent') ?? '' !!}
                                </div>
                            @endif
                        @endif
                    @endif
                </div>
                <div class="profile-wrapper-author-cotents">
                  <h4 class="single-freelancer-author-name">
                        <a href="#/" tabindex="0">
                            {{ $user->first_name . ' ' . $user->last_name }}
                            @if(moduleExists('FreelancerLevel'))
                                <small>{{ freelancer_level($user->id) }}</small>
                            @endif
                        </a>

                        @if(Cache::has('user_is_online_' . $user->id))
                            <span class="single-freelancer-author-status"> {{ __('Online') }} </span>

                            @if(auth()->check())
                                <!-- Show Share Button only if logged in AND user is online -->
                                <button type="button" class="btn-profile btn-bg-1 btn-sm ms-2" data-bs-toggle="modal" data-bs-target="#shareProfileModal">
                                    <i class="fas fa-share-alt me-1"></i> {{ __('Share Profile') }}
                                </button>
                            @endif

                        @else
                            <span class="single-freelancer-author-status-ofline"> {{ __('Offline') }} </span>
                        @endif
                    </h4>

                    <span class="single-freelancer-author-para mt-2">
                        {{ optional($user->user_introduction)->title ?? '' }} @if($user->user_verified_status == 1) <i class="fas fa-circle-check"></i>@endif
                    </span>
                    {!! freelancer_rating_for_profile_details_page($user->id) !!}
                </div>
            </div>
        </div>
        <div class="profile-wrapper-right">
            <div class="profile-wrapper-right-flex flex-btn">
                @if($user->check_work_availability == 1)
                <span class="profile-wrapper-switch-title"> {{ __('Available for Work') }}</span>
                @endif
                    @if(Auth::guard('web')->check() && Auth::guard('web')->user()->user_type == 2 && Auth::guard('web')->user()->username==$username)

                <div class="profile-wrapper-switch-custom display_work_availability">
                    <label class="custom_switch">
                            <input type="checkbox" id="check_work_availability" data-user_id="{{ $user->id }}" data-check_work_availability="{{ $user->check_work_availability }}" @if($user->check_work_availability == 1)checked @endif>
                            <span class="slider round"></span>

                    </label>
                </div>
                    @endif
            </div>
        </div>

    </div>
      


    @if($user?->user_country?->country)
        <div class="profile-wrapper-details profile-border-top">
        @if(moduleExists('HourlyJob'))
            @if($user->hourly_rate >= 1)
            <div class="profile-wrapper-details-single">
                <div class="profile-wrapper-details-single-flex">
                    <h4 class="profile-wrapper-details-single-price display_hourly_rate"> {{ amount_with_currency_symbol($user->hourly_rate ?? '') }} <sub>{{ __('hour') }}</sub></h4>
                    @if(Auth::guard('web')->check() && Auth::guard('web')->user()->user_type == 2 && Auth::guard('web')->user()->username==$username)
                        <span class="profile-wrapper-details-edit price_edit_show_hide" data-bs-toggle="modal" data-bs-target="#priceModal"><i class="fas fa-edit"></i></span>
                    @endif
                </div>
            </div>
            @endif
        @endif

        <div class="profile-wrapper-details-single">
            <div class="profile-wrapper-details-single-flex">
                <div class="profile-wrapper-details-single-flag">
                    <i class="flag flag-{{strtolower(optional($user->user_country)->country)}}"></i>
                </div>
                <!-- <span class="profile-wrapper-details-para"> @if($user?->user_state?->state != null) {{ optional($user->user_state)->state }}, @endif {{ optional($user->user_country)->country }} </span> -->
                <span class="profile-wrapper-details-para">
                    @if($user?->user_city?->city)
                        {{ $user->user_city->city }},
                    @endif
                    @if($user?->user_state?->state)
                        {{ $user->user_state->state }},
                    @endif
                        {{ $user->user_country->country ?? '' }}
                </span>
            </div>
        </div>

        @if(!empty($user->user_state->timezone))
        <div class="profile-wrapper-details-single">
            <div class="profile-wrapper-details-single-flex">
                <span class="profile-wrapper-details-single-icon"><i class="fa-regular fa-clock"></i></span>
                <span class="profile-wrapper-details-para">
                    @php
                    if(!empty($user->user_state->timezone)){
                        date_default_timezone_set(optional($user->user_state)->timezone ?? '');
                        echo date('h:i:a');
                    }
                    @endphp
                </span>
                    <span>({{ __('Local Time') }})</span>
            </div>
        </div>
        @endif

    </div>
    @endif

    @if($user?->user_introduction?->description)
    <div class="profile-wrapper-about profile-border-top">
        <h4 class="profile-wrapper-about-title"> {{ __('About Me') }} </h4>
        <p class="profile-wrapper-about-para mt-2">{{ optional($user->user_introduction)->description ?? '' }}</p>
    </div>
   @endif
    @if(Auth::guard('web')->check() && Auth::guard('web')->user()->user_type == 2 && Auth::guard('web')->user()->username==$username)
        <div class="d-flex">
            <div class="profile-wrapper-item-btn flex-btn profile-border-top">
                <div class="change_client_view">
                    <a href="javascript:void(0)" class="btn-profile btn-outline-gray view_as_a_client"> {{ __('View as Client') }} </a>
                </div>
                <a href="javascript:void(0)" class="btn-profile btn-bg-1 edit_info_show_hide" data-bs-toggle="modal" data-bs-target="#profileModal"> {{ __('Edit info') }} </a>
            </div>
            <div class="promote_profile profile-border-top">

                @if(moduleExists('PromoteFreelancer'))
                    @php
                        $current_date = \Carbon\Carbon::now()->toDateTimeString();
                        $is_promoted = \Modules\PromoteFreelancer\Entities\PromotionProjectList::where('identity',auth()->user()->id)
                        ->where('type','profile')
                        ->where('expire_date','>',$current_date)
                        ->where('payment_status','complete')
                        ->first();
                    @endphp

                    @if(!empty($is_promoted))
                        <button type="button" class="btn btn-outline-primary" disabled>{{ __('Profile Promoted') }}</button>
                    @else
                        <a href="javascript:void(0)"
                           class="btn-profile btn-bg-1 open_project_promote_modal"
                           data-bs-target="#openProjectPromoteModal"
                           data-bs-toggle="modal"
                           data-project-id="0">
                            {{ __('Promote Profile') }}
                        </a>
                    @endif

                @endif

            </div>
        </div>
    @endif
</div>

<!--price update modal-->
<div class="modal fade" id="priceModal" tabindex="-1" aria-labelledby="PriceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="PriceModalLabel">{{ __('Edit Price') }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="single-profile-settings-form custom-form">
                    <div class="error_msg_container"></div>
                    <x-form.text :type="'number'"  min="1" max="300" :title="__('Enter Price')" :id="'hourly_rate'" :class="'form-control'" value="{{ $user->hourly_rate ?? '' }}" />
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('Close')}}</button>
                <button type="button" class="btn btn-primary edit_public_hourly_rate">{{ __('Save') }}</button>
            </div>
        </div>
    </div>
</div>

<!--Update info Modal -->
<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="profileModalLabel">{{ __('Edit Profile Info') }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="single-profile-settings-form custom-form">
                    <div class="error_msg_container"></div>
                    <div class="single-flex-input">
                        <x-form.text :type="'text'" :title="__('First Name')" :id="'first_name'" :class="'form-control'" value="{{ $user->first_name }}" />
                        <x-form.text :type="'text'" :title="__('Last Name')" :id="'last_name'" :class="'form-control'" value="{{ $user->last_name }}" />
                    </div>
                    <x-form.text :type="'text'" :title="__('Professional Title')" :id="'professional_title'" :class="'form-control'" value="{{ optional($user->user_introduction)->title }}" />
                    <span id="professional_title_char_length_check"></span>
                    <x-form.textarea :type="'text'" :title="__('Intro About Yourself')" :id="'professional_description'" :class="'form-control'" value="{{ optional($user->user_introduction)->description }}" />
                    <span id="professional_description_char_length_check"></span>
                  <div class="form-group">
                    <label for="country_id">{{ __('ID issuing country') }}</label>
                    <select name="country" id="country_id" class="form--control country_select2">
                        <option value="">{{ __('Select Country') }}</option>
                        @foreach($countries as $country)
                            <option value="{{ $country->id }}" {{ old('country', $user_identity->country_id ?? '') == $country->id ? 'selected' : '' }}>
                                {{ $country->country }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="state_id">{{ __('State') }}</label>
                    <select name="state" id="state_id" class="form--control state_select2 get_country_state">
                        <option value="">{{ __('Select State') }}</option>
                        {{-- You can optionally pre-load state options here based on old values --}}
                    </select>
                </div>

                <div class="form-group">
                    <label for="city_id">{{ __('City (optional)') }}</label>
                    <select name="city" id="city_id" class="form--control city_select2 get_state_city">
                        @foreach($cities as $city)
                            <option value="{{ $city->id }}" {{ old('city', $user->city_id) == $city->id ? 'selected' : '' }}>
                                {{ $city->city }}
                            </option>
                        @endforeach
                    </select>
                </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('Close')}}</button>
                <button type="button" class="btn btn-primary edit_public_profile_info">{{ __('Save') }}</button>
            </div>
        </div>
    </div>
</div>
@php
    $profileUrl = route('freelancer.profile.details', ['username' => $user->username]);
@endphp

<!-- Share Profile Modal -->
<div class="modal fade" id="shareProfileModal" tabindex="-1" aria-labelledby="shareProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content radius-10">
            <div class="modal-header">
                <h5 class="modal-title" id="shareProfileModalLabel">{{ __('Share Profile') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('Close') }}"></button>
            </div>
            <div class="modal-body text-center">
                <!-- Profile Image -->
                <div class="mb-3">
                    @if($user->image)
                        <img src="{{ cloudStorageExist() && in_array(Storage::getDefaultDriver(), ['s3', 'cloudFlareR2', 'wasabi']) 
                                ? render_frontend_cloud_image_if_module_exists('profile/'.$user->image, load_from: $user->load_from)
                                : asset('assets/uploads/profile/'.$user->image) }}"
                             alt="{{ __('Profile Image') }}" 
                             class="rounded-circle" width="100">
                    @endif
                </div>

                <h5>{{ $user->first_name . ' ' . $user->last_name }}</h5>
                <p class="text-muted">{{ optional($user->user_introduction)->title }}</p>

                <div class="d-flex justify-content-center gap-3 mt-4">
                    <!-- WhatsApp -->
                    <a href="https://wa.me/?text={{ urlencode('Check out this profile: ' . $profileUrl) }}" 
                       target="_blank" class="btn btn-success btn-icon" title="WhatsApp">
                        <i class="fab fa-whatsapp"></i>
                    </a>

                    <!-- Twitter -->
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode($profileUrl) }}" 
                       target="_blank" class="btn btn-primary btn-icon" title="Twitter" style="background-color: #1DA1F2; border-color: #1DA1F2;">
                        <i class="fab fa-twitter"></i>
                    </a>

                    <!-- LinkedIn -->
                    <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode($profileUrl) }}" 
                       target="_blank" class="btn btn-primary btn-icon" title="LinkedIn" style="background-color: #0077B5; border-color: #0077B5;">
                        <i class="fab fa-linkedin-in"></i>
                    </a>

                    <!-- Facebook -->
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($profileUrl) }}" 
                       target="_blank" class="btn btn-primary btn-icon" title="Facebook" style="background-color: #1877F2; border-color: #1877F2;">
                        <i class="fab fa-facebook-f"></i>
                    </a>

                    <!-- Copy Link -->
                    <a href="javascript:void(0);" class="btn btn-dark btn-icon copy-profile-link" title="Copy Link" data-link="{{ $profileUrl }}">
                        <i class="fas fa-link"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Bootstrap tooltip initialization
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

     document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.copy-profile-link').forEach(function (btn) {
            btn.addEventListener('click', function () {
                const profileLink = this.getAttribute('data-link');
                navigator.clipboard.writeText(profileLink).then(() => {
                    toastr.success("Profile link copied to clipboard!");
                }).catch(() => {
                    toastr.error("Failed to copy profile link.");
                });
            });
        });
    });
</script>
@if(moduleExists('PromoteFreelancer'))
    @include('frontend.profile-details.promotion.project-promote-modal')
@endif
