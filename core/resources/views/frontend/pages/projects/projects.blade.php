@php use App\Models\Project; @endphp
@extends('frontend.layout.master')
@section('site_title', __('Browse Projects - Find Freelance Work | Right Freelancer'))
@section('meta_description'){{ __('Discover a wide range of freelance projects from global clients. Bid on projects that match your skills and start earning today on Right Freelancer.') }}@endsection
@section('meta_keywords'){{ __('freelance projects, online jobs, bid on freelance work, remote freelance jobs, web development projects, writing projects, design jobs, Right Freelancer') }}@endsection

@section('style')
    <x-select2.select2-css />
    <style>
        .pro-profile-badge {
            position: absolute;
            right: -10px;
            top: -10px;
            border-radius:20px;
            background: #FAF5FF;
            color: #9e4cf4;
            font-weight: 600;
        }
        .pro-icon-background {
            display: flex;
            justify-content: center;
            align-items: center;
            background: #9e4cf4;
            padding: 3px;
            border-radius: 50%;
            color: #fff;
            font-size: 12px;
        }
        .project-category-item .single-project {
            position: relative;
        }
        .disabled-link {
            background-color: #ccc !important;
            pointer-events: none;
            cursor: default;
            border:none;
        }
    </style>
@endsection
@section('content')
    <main>

        @if(moduleExists('CoinPaymentGateway'))@else<x-frontend.category.category/>@endif

        <x-breadcrumb.user-profile-breadcrumb :title=" __('All Projects')" :innerTitle=" __('All Projects') ?? '' "/>
        <!-- Project preview area Starts -->
        <div class="preview-area section-bg-2 pat-100 pab-100">
            <div class="container">
                <div class="row g-4">

                    @if(moduleExists('PromoteFreelancer'))
                        <div class="profile-wrapper-right-flex flex-btn text-right">
                            <span class="profile-wrapper-switch-title">{{ __('Pro Projects') }}</span>
                            <div class="profile-wrapper-switch-custom display_work_availability">
                                <label class="custom_switch">
                                    <input type="checkbox" id="get_pro_projects" value="0">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                    @endif
                    <div class="col-lg-12">
                        <div class="categoryWrap-wrapper">
                            <div class="shop-contents-wrapper responsive-lg">
                                <div class="shop-icon">
                                    <div class="shop-icon-sidebar">
                                        <i class="fas fa-bars"></i>
                                    </div>
                                </div>

                                @include('frontend.pages.projects.sidebar')
                                <div class="shop-contents-wrapper-right search_result">
                                    @include('frontend.pages.projects.search-result')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Project preview area end -->
    </main>

@endsection

@section('script')
    @include('frontend.pages.projects.project-filter-js')
    <x-select2.select2-js />
@endsection
