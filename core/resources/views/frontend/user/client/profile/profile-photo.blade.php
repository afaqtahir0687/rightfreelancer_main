
<style>
    .identity-verifying-flex {
    display: flex;
    flex-direction: row;
    flex-wrap: nowrap; 
    justify-content: center;
    gap: 100px;
}

.identity-verifying-list {
    flex: 0 0 auto;
    min-width: 200px;  
    max-width: 250px;
    padding: 10px;
    box-sizing: border-box;
    background: #f8f8f8;
    border: 1px solid #ccc;
    border-radius: 5px;
    cursor: default;
    pointer-events: none;
    margin: auto;
}
.identity-verifying-list-contents-details-title {
    font-size: 14px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.identity-verifying-list-contents-flex {
    align-items: center;
    display: flex;
    gap: 8px;
}
.identity-verifying-list.completed {
    pointer-events: none;
    background-color: #d4edda;
    border-color: #309400;
    color: #155724;
    cursor: default;
}

.identity-verifying-list.completed i {
    color: #309400;
}

</style>

<div class="single-profile-settings">
    <div class="single-profile-settings-header">
        <div class="single-profile-settings-header-flex">
            <x-form.form-title :title="__('Profile Info')" :class="'single-profile-settings-header-title'" />
            <div>
                @include('frontend.user.partials.profile_completed_progressbar')
            </div>
        </div>
        <p class="mt-2">{{ __(key: 'Please complete the following two steps to complete your profile setup. This will help us to better understand your skills and experience.') }}</p>
    </div>
    <div class="identity-verifying-form custom-form profile-border-top">
        <div class="identity-verifying-flex">
            <div class="identity-verifying-list custom-radio {{ $step1Complete ? 'completed disabled' : '' }}">
                <div class="identity-verifying-list-flex">
                    <div class="identity-verifying-list-contents">
                        <div class="identity-verifying-list-contents-flex">
                            <div class="identity-verifying-list-contents-icon">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            <div class="identity-verifying-list-contents-details">
                                <h5 class="identity-verifying-list-contents-details-title">{{ __('Personal Information') }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
             
            <div class="identity-verifying-list custom-radio {{ $step2Complete ? 'completed' : '' }}">
                <div class="identity-verifying-list-flex">
                    <div class="identity-verifying-list-contents">
                        <div class="identity-verifying-list-contents-flex">
                            <div class="identity-verifying-list-contents-icon">
                                <i class="fa-solid fa-fingerprint"></i>
                            </div>
                            <div class="identity-verifying-list-contents-details">
                                <h5 class="identity-verifying-list-contents-details-title">{{ __('Identity Verification') }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="single-profile-settings mt-4" id="display_client_profile_photo">
    <div class="single-profile-settings-flex">
        <div class="single-profile-settings-thumb">
            @if(!empty(Auth::guard('web')->user()->image))
                @if(cloudStorageExist() && in_array(Storage::getDefaultDriver(), ['s3', 'cloudFlareR2', 'wasabi']))
                    <img src="{{ render_frontend_cloud_image_if_module_exists( 'profile/'. Auth::guard('web')->user()->image, load_from: Auth::guard('web')->user()->load_from) }}" alt="{{ __('profile img') }}">
                @else
                    <img src="{{ asset('assets/uploads/profile/'.Auth::guard('web')->user()->image) ?? '' }}" alt="{{ __('profile img') }}">
                @endif
            @else
                <img src="{{ asset('assets/static/img/author/author.jpg') }}" alt="client-image">
            @endif
        </div>
        <div class="single-profile-settings-contents">
            <div class="single-profile-settings-contents-upload">
                <div class="single-profile-settings-contents-upload-btn">
                     <span>
                        <svg class="me-1" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <mask id="mask0_6531_8660" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="24" height="24">
                            <rect width="24" height="24" fill="#D9D9D9"/>
                            </mask>
                            <g mask="url(#mask0_6531_8660)">
                            <path d="M18.3415 21.5C18.1482 21.4975 17.9635 21.4197 17.8269 21.2832C17.6902 21.1467 17.6123 20.9623 17.6098 20.7692V18.5769H15.4146C15.2206 18.5769 15.0345 18.4999 14.8972 18.3629C14.76 18.2258 14.6829 18.04 14.6829 17.8462C14.6829 17.6523 14.76 17.4665 14.8972 17.3294C15.0345 17.1924 15.2206 17.1154 15.4146 17.1154H17.6098V14.9231C17.6098 14.7293 17.6868 14.5434 17.8241 14.4064C17.9613 14.2693 18.1474 14.1923 18.3415 14.1923C18.5355 14.1923 18.7216 14.2693 18.8589 14.4064C18.9961 14.5434 19.0732 14.7293 19.0732 14.9231V17.1154H21.2683C21.4624 17.1154 21.6485 17.1924 21.7857 17.3294C21.9229 17.4665 22 17.6523 22 17.8462C22 18.04 21.9229 18.2258 21.7857 18.3629C21.6485 18.4999 21.4624 18.5769 21.2683 18.5769H19.0732V20.7692C19.0706 20.9623 18.9927 21.1467 18.8561 21.2832C18.7194 21.4197 18.5347 21.4975 18.3415 21.5ZM11.5122 19.5513H4.68293C3.97295 19.5462 3.2935 19.2622 2.79146 18.7608C2.28941 18.2594 2.00511 17.5809 2 16.8718V8.10258C2.00511 7.39352 2.28941 6.71494 2.79146 6.21354C3.2935 5.71214 3.97295 5.4282 4.68293 5.4231H5.65854C5.98118 5.42055 6.28989 5.29142 6.51804 5.06356C6.7462 4.8357 6.8755 4.52739 6.87805 4.20515C6.87675 3.98087 6.92003 3.75856 7.00537 3.5511C7.09072 3.34364 7.21643 3.15516 7.37522 2.99657C7.53402 2.83797 7.72275 2.71242 7.93048 2.62719C8.1382 2.54196 8.3608 2.49874 8.58537 2.50003H14.439C14.6636 2.49874 14.8862 2.54196 15.0939 2.62719C15.3016 2.71242 15.4904 2.83797 15.6492 2.99657C15.808 3.15516 15.9337 3.34364 16.019 3.5511C16.1044 3.75856 16.1476 3.98087 16.1463 4.20515C16.1489 4.52739 16.2782 4.8357 16.5063 5.06356C16.7345 5.29142 17.0432 5.42055 17.3659 5.4231H18.3415C19.0514 5.4282 19.7309 5.71214 20.2329 6.21354C20.735 6.71494 21.0193 7.39352 21.0244 8.10258V11.5128C21.0244 11.7066 20.9473 11.8925 20.8101 12.0296C20.6729 12.1666 20.4867 12.2436 20.2927 12.2436C20.0986 12.2436 19.9125 12.1666 19.7753 12.0296C19.6381 11.8925 19.561 11.7066 19.561 11.5128V8.10258C19.5584 7.78035 19.4291 7.47204 19.201 7.24418C18.9728 7.01632 18.6641 6.88718 18.3415 6.88464H17.3659C16.6559 6.87954 15.9764 6.5956 15.4744 6.0942C14.9723 5.5928 14.688 4.91422 14.6829 4.20515C14.6843 4.1728 14.6789 4.14051 14.6672 4.11033C14.6554 4.08015 14.6375 4.05274 14.6146 4.02984C14.5916 4.00694 14.5642 3.98905 14.534 3.9773C14.5038 3.96554 14.4714 3.96019 14.439 3.96156H8.58537C8.55297 3.96019 8.52064 3.96554 8.49042 3.9773C8.4602 3.98905 8.43276 4.00694 8.40983 4.02984C8.3869 4.05274 8.36898 4.08015 8.35722 4.11033C8.34545 4.14051 8.34008 4.1728 8.34146 4.20515C8.33636 4.91422 8.05205 5.5928 7.55001 6.0942C7.04796 6.5956 6.36851 6.87954 5.65854 6.88464H4.68293C4.36028 6.88718 4.05157 7.01632 3.82342 7.24418C3.59527 7.47204 3.46597 7.78035 3.46341 8.10258V16.8718C3.46597 17.194 3.59527 17.5023 3.82342 17.7302C4.05157 17.9581 4.36028 18.0872 4.68293 18.0897H11.5122C11.7063 18.0897 11.8924 18.1667 12.0296 18.3038C12.1668 18.4408 12.2439 18.6267 12.2439 18.8205C12.2439 19.0143 12.1668 19.2002 12.0296 19.3372C11.8924 19.4743 11.7063 19.5513 11.5122 19.5513ZM11.5122 15.6539C10.7891 15.6532 10.0824 15.4386 9.48131 15.037C8.88025 14.6355 8.41183 14.0651 8.13519 13.3978C7.85854 12.7306 7.7861 11.9964 7.927 11.2881C8.0679 10.5797 8.41582 9.92895 8.92683 9.41797C9.62246 8.75218 10.5487 8.38048 11.5122 8.38048C12.4757 8.38048 13.4019 8.75218 14.0976 9.41797C14.6086 9.92895 14.9565 10.5797 15.0974 11.2881C15.2383 11.9964 15.1658 12.7306 14.8892 13.3978C14.6126 14.0651 14.1441 14.6355 13.5431 15.037C12.942 15.4386 12.2353 15.6532 11.5122 15.6539ZM11.5122 9.80771C11.0783 9.80809 10.6543 9.93687 10.2937 10.1778C9.93303 10.4187 9.65197 10.761 9.48599 11.1613C9.32 11.5617 9.27654 12.0022 9.36108 12.4272C9.44562 12.8522 9.65437 13.2427 9.96098 13.5492C10.3808 13.9439 10.9356 14.1636 11.5122 14.1636C12.0887 14.1636 12.6436 13.9439 13.0634 13.5492C13.2691 13.3472 13.432 13.1059 13.5426 12.8398C13.6532 12.5737 13.7092 12.2881 13.7073 12C13.7047 11.4192 13.4734 10.8627 13.0634 10.4508C12.8611 10.2454 12.6195 10.0827 12.3531 9.97219C12.0866 9.86173 11.8007 9.8058 11.5122 9.80771Z" fill="#fff"/>
                            </g>
                        </svg>
                        {{ __('Change Photo') }}
                    </span>
                    <input type="file" name="image" id="profile_photo" class="upload-file">
                </div>
            </div>
            <p class="single-profile-settings-contents-para mt-2">{{ __('Profile photo recomended size 80x80 pixels') }}</p>
        </div>
    </div>
</div>
