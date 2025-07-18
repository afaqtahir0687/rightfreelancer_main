@php use plugins\PageBuilder\PageBuilderSetup; @endphp
@extends('frontend.layout.master')
@section('site_title', __('Win Work With Reward'))
@section('meta_title') {{ __('Win Work With Reward - Earn Bonus Opportunities on Right Freelancer') }}@endsection
@section('meta_description')
{{ __('Participate in rewarding activities and challenges on Right Freelancer to win extra work opportunities, bonuses, and exclusive recognition.') }}@endsection

<style>
    .gtm-ads-goals-image-wrapper {
        aspect-ratio: 1.978;
        background-color: #f2f2f2;
        border-radius: .5rem;
        flex-flow: column;
        justify-content: space-between;
        align-items: flex-start;
        width: 100%;
        padding: 1rem;
        display: flex;
        position: relative;
    }

    .read-more {
        color: #309400
    }

    .title {
        font-size: 30px;
    }
</style>

@section('content')
    <div class="banner-inner-area border-top pat-20 pab-20">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="banner-inner-contents">
                        <ul class="inner-menu">
                            <li class="list"><a href="https://www.rightfreelancer.com">Home </a></li>
                            <li class="list"> Win Works and Rewards </li>
                        </ul>
                        <h2 class="banner-inner-title"> Win Works and Rewards </h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- About area starts -->
    <section class="about-area section-bg-2 pat-100 pab-100" data-padding-top="100" data-padding-bottom="100"
        style="background-color:#F5F5F5">
        <div class="container">
            <div class="row g-4 justify-content-between">
                <div class="col-xxl-6 col-lg-6">
                    <div class="about-wrapper-left">
                        <div class="section-title text-left">
                            <h2 class="fw-bold title mt-1">Maximize Your Exposure with Ads</h2>
                            <p class="mt-3">
                                <span style="font-weight:normal;">Increase your profile visibility and secure more job
                                    opportunities with our powerful ad solutions.
                                    Whether you're looking for more invites or closing more deals, we have the right tools
                                    to help you succeed.
                                    Get started today!
                                </span>
                            </p>
                        </div>
                        <div class="about-counter mt-5">
                            <div class="about-counter-item">
                                <h3 class="about-counter-item-title">
                                    <span class="about-counter-item-title-heading">39K</span>
                                </h3>
                                <p class="about-counter-item-para">Clients working with us</p>
                            </div>
                            <div class="about-counter-item">
                                <h3 class="about-counter-item-title">
                                    <span class="about-counter-item-title-heading">60K</span>
                                </h3>
                                <p class="about-counter-item-para">Freelancers working with us</p>
                            </div>
                            <div class="about-counter-item">
                                <h3 class="about-counter-item-title">
                                    <span class="about-counter-item-title-heading">50K</span>
                                </h3>
                                <p class="about-counter-item-para">Orders processed</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-6 col-lg-6">
                    <div class="about-wrapper-right">
                        <div class="about-wrapper-thumb">
                            <div class="about-wrapper-thumb-item">
                                <img src="assets/frontend/img/boosted.png" alt="Boosted Image">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- About area end -->
        <div class="container mt-5">
            <div class="row">
                <div class="col-lg-12">
                    <h2 class="fw-bold title mb-3 mt-3">Discover Our Ad Solutions</h2>
                    <p>
                        <span style="font-weight:normal;">Explore three effective ways to reach your career goals with our
                            ad products.</span>
                    </p>
                </div>
            </div>
            <div class="row g-4">
                <!-- Boosted Profile -->
                <div class="col-lg-4 col-md-6">
                    <div class="single-feature p-4 h-100"
                        style="background-color:#f9f9f9; border-radius:20px; box-shadow:0 4px 15px rgba(0,0,0,0.08);">
                        <h6 class="mb-2" style="font-size:16px;">Spotlight Your Profile</h6>
                        <h4 class="mb-3" style="font-size:30px;">Boosted Pro Profile</h4>
                        <div class="gtm-ads-goals-image-wrapper">
                            <p style="font-size:15px;">Investing in Connects can enhance your likelihood of being hired by
                                up to
                                <strong>2x <sup>1</sup></strong>
                            </p>
                            <img src="{{ asset('assets/frontend/img/boosted-1.jpg') }}" alt="Boosted Profile"
                                class="img-fluid mb-3" style="width:100%; max-height:180px; object-fit:contain;" />
                        </div>

                        <!-- <a href="#" class="fw-semibold d-inline-block Read-more"><b>Read more →</b></a> -->
                    </div>
                </div>

                <!-- Availability Badge -->
                <div class="col-lg-4 col-md-6">
                    <div class="single-feature p-4 h-100"
                        style="background-color:#f9f9f9; border-radius:20px; box-shadow:0 4px 15px rgba(0,0,0,0.08);">
                        <h6 class="mb-2" style="font-size:16px;">Show Your Availability</h6>
                        <h4 class="mb-3" style="font-size:30px;">Availability Badge</h4>
                        <div class="gtm-ads-goals-image-wrapper">
                            <p style="font-size:15px;">Freelancers with this badge receive
                                <strong> up to 75% more job invitations.</strong>
                            </p>
                            <img src="{{ asset('assets/frontend/img/boosted-2.jpg') }}" alt="Availability Profile"
                                class="img-fluid mb-3" style="width:100%; max-height:180px; object-fit:contain;" />
                        </div>

                        <!-- <a href="#" class="fw-semibold d-inline-block Read-more"><b>Read more →</b></a> -->
                    </div>
                </div>

                <!-- Boosted Proposals -->
                <div class="col-lg-4 col-md-6">
                    <div class="single-feature p-4 h-100"
                        style="background-color:#f9f9f9; border-radius:20px; box-shadow:0 4px 15px rgba(0,0,0,0.08);">
                        <h6 class="mb-2" style="font-size:16px;">Reach New Heights</h6>
                        <h4 class="mb-3" style="font-size:30px;">Enhanced Proposals</h4>
                        <div class="gtm-ads-goals-image-wrapper">
                            <p style="font-size:15px;">Generates 10x greater returns on ad spend
                                <strong><sup>3</sup></strong>
                            </p>
                            <br>
                            <img src="{{ asset('assets/frontend/img/boosted-3.jpg') }}" alt="Boosted Proposals"
                                class="img-fluid mb-3" style="width:100%; max-height:180px; object-fit:contain;" />
                        </div>

                        <!-- <a href="#" class="fw-semibold d-inline-block Read-more"><b>Read more →</b></a> -->
                    </div>
                </div>
            </div>
        </div>
        <!-- Work Goal Boost Section End -->
        @php
            $promotionProfile = \App\Models\PageBuilder::where('addon_name', 'ProfilePromotion')->first();
        @endphp
        {!! plugins\PageBuilder\PageBuilderSetup::render_widgets_by_name_for_frontend(plugins\PageBuilder\PageBuilderSetup::getWidgetArgs($promotionProfile)) !!}

        <!-- Resources Section Start -->
        <div class="container">
            <div class="row mb-4">
                <div class="col-lg-12">
                    <h2 class="fw-bold title mb-2">What’s the payment process for ads?</h2>
                    <h5 class="title mb-3">Ad Payment with Connects</h5>
                    <p>On RightFreelancer, ads are purchased using <strong>Connects</strong>, a virtual currency. You can
                        also select a custom amount to match your specific needs and budget. Each Connect is priced at
                        <strong>$0.15 (USD)</strong>. Freelancers use Connects to submit proposals and bid on ad products
                        such as <strong>Boosted Proposals, Boosted Profiles</strong>, and the <strong>Availability
                            Badge</strong>.
                    </p>
                    <!-- <a href="#" class="fw-semibold d-inline-block Read-more"><b>Read more →</b></a> -->


                    <h5 class="title mb-3 mt-3">Why Use Ads?</h5>
                    <p>Using ads is completely optional—you choose when and if you want to use them. While ads aren’t
                        necessary to submit proposals, they help increase your visibility, land the projects you care about
                        most, and streamline your workflow to boost your earnings on high-quality jobs.</p>
                    <!-- <a href="#" class="fw-semibold d-inline-block Read-more"><b>Read more →</b></a> -->
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-lg-12">
                    <h5 class="title mb-3">How to Get Started</h5>
                    <p>
                        Getting started is simple and low-risk. Select an ad product that aligns with your goals, then place
                        a bid to enter the auction. If you win the auction, you’ll gain increased visibility, engage more
                        clients, and have a better chance of securing the projects you’re most interested in.
                    </p>

                    <h5 class="title mb-3 mt-3">Where Do I Place a Bid for an Ad?</h5>
                    <p class="mb-1">
                        After choosing the ad product that fits your needs, placing a bid is quick and easy. Follow a few
                        simple steps to submit your bid and find out if you’ve won the auction. These articles offer
                        structured walkthroughs for setting up and managing essential features.
                    </p>

                    <h5 class="title mb-3">Advertising Options</h5>
                    <ul class="fw-bold" style="color: #309400; font-size:20px">
                        <li>Enhanced Proposals</li>
                        <li>Availability Indicator</li>
                        <li>Profile Promotion</li>
                    </ul>

                    <h5 class="title mb-3 mt-3">Helpful Resources</h5>
                    <p class="mb-1">
                        Find out how advertising can increase your visibility and help you secure the best opportunities.
                    </p>
                    <!-- <a href="#" class="Read-more d-inline-block"><b>Read more →</b></a> -->

                    <h5 class="title mb-3 mt-3">Ads Guide</h5>
                    <p class="mb-1"><strong>Build, manage, and optimize your campaigns.</strong></p>
                    <!-- <a href="#" class="Read-more d-inline-block"><b>Learn more →</b></a> -->

                    <p class="mb-1">
                        Build customized ad campaigns tailored to your specific audience segments.
                    </p>
                    <!-- <a href="#" class="Read-more d-inline-block"><b>Discover more →</b></a> -->

                    <h5 class="title mb-3 mt-3">Master your ads</h5>
                    <p class="mb-1"><strong>Build, manage, and optimize.</strong></p>
                    <!-- <a href="#" class="Read-more d-inline-block"><b>Learn more →</b></a> -->

                    <p class="mb-1"><strong>Effortlessly create and optimize ad campaigns.</strong></p>
                    <!-- <a href="#" class="Read-more d-inline-block"><b>Explore more →</b></a> -->

                    <p class="mb-1"><strong>Design, manage, and enhance ad campaigns with rightfreelancer.</strong></p>
                </div>

            </div>
        </div>
    </section>
    <!-- Resources Section End -->
    <!-- <p class="mt-3 mb-2 text-center">
        <sup>1</sup> Boosted Profile, RightFreelancer data, Oct-Nov 2025.
        <sup>2</sup> Availability Badge, RightFreelancer data, Dec 2025.
        <sup>3</sup> Boosted Proposals, RightFreelancer data, Aug-Dec 2025.
    </p> -->

    <!-- Get Started With Ads Section Start -->
    <div class="container mt-3 mb-5">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8 col-md-10 col-12">
                <h2 class="fw-bold title">Use ads to win work.</h2>
                <div class="btn-wrapper d-flex justify-content-center mt-1 mb-2">
                    <a href="{{ route('freelancer.ad.manage') }}" class="cmn-btn btn-bg-1">Add now</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Get Started With Ads Section End -->
@endsection