@php use plugins\PageBuilder\PageBuilderSetup; @endphp
@extends('frontend.layout.master')

@section('site_title', __('Partnership'))
@section('meta_title')
    {{ __('Partnership - Right Freelancer | Build Strong Collaborations') }}
@endsection

@section('meta_description')
    {{ __('Explore partnership opportunities with Right Freelancer. Join hands to grow together through trust, support, and innovation.') }}
@endsection

<style>
    .escrow-policy-banner {
        background-color: #309400;
        padding: 90px 0;
        text-align: center;
        color: white;
    }

    .escrow-policy-banner .escrow-title {
        font-size: 70px;
        font-weight: 700;
        margin-bottom: 20px;
        color: white;
    }

    .escrow-policy-banner .effective-date {
        display: inline-block;
        background-color: #2ED47A;
        color: white;
        padding: 10px 25px;
        border-radius: 30px;
        font-size: 16px;
        font-weight: 500;
    }
</style>

@section('content')
    <!-- Breadcrumb -->
    <div class="banner-inner-area border-top pat-20 pab-20">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="banner-inner-contents">
                        <ul class="inner-menu">
                            <li class="list"><a href="{{ url('/') }}">Home</a></li>
                            <li class="list">Partnership</li>
                        </ul>
                        <h2 class="banner-inner-title">Partnership</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="banner-inner-area border-top pat-20">
        <div class="container-fulid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="escrow-policy-banner">
                        <div class="container">
                            <div class="row align-items-center">
                                <!-- Left 6 columns: Heading + Paragraph -->
                                <div class="col-lg-6">
                                    <h2 class="escrow-title text-start">Partnership with Right Freelancer</h2>
                                    <p class="text-start" style="font-size: 16px; color: #fff;">
                                        Collaborate with Right Freelancer to grow your reach, expand your services, and
                                        create value together. Our partnership model is built on transparency and long-term
                                        success.
                                    </p>
                                </div>

                                <!-- Right 6 columns: Image -->
                                <div class="col-lg-6 text-center">
                                    <div class="img-fluid w-100">
                                        <img src="{{ asset('assets/uploads/partnerimage/Expand-Your-Talent-Pool.jpg') }}"
                                            alt="Partnership" style="height:100%; border-radius:10px">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="centered-section py-5 about-area section-bg-2 pat-100 pab-100" data-padding-top="100"
        data-padding-bottom="100" style="background-color:#F5F5F5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12 text-center">
                    <h2 class="section-title mb-4">
                        Partnership Opportunities
                    </h2>
                    <p class="section-text" style="font-size: 16px; color: #555;">
                        Discover how Right Freelancer is building strong relationships through strategic partnerships.
                        Whether you're a technology provider, agency, or educational platform, we welcome you to collaborate
                        with us. Our partnerships are grounded in trust, innovation, and mutual growth.
                    </p>
                </div>
            </div>
        </div>
        <div class="container mt-3">
            <div class="row align-items-center">
                <!-- Left Column: Text -->
                <div class="col-lg-6">
                    <h1>Partnership</h1>
                    <p class="partnership-description">
                        At Right Freelancer, we believe in the power of collaboration.
                    </p>
                    <p class="partnership-description">
                        Let's create innovative solutions and open new paths to success — together.
                    </p>
                </div>
                <!-- Right Column: Image -->
                <div class="col-lg-6 text-center">
                    <div class="img-fluid w-100">
                        <img src="{{ asset('assets/uploads/partnerimage/Expand-Your-Talent-Pool.jpg') }}" alt="Partnership"
                            style="height:100%; border-radius:10px">
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row align-items-center">
                <!-- Left Column: Text -->
                <div class="col-lg-6 text-center">
                    <img src="{{ asset('assets/uploads/partnerimage/Contribute-to-Economic-Empowerment.jpg') }}"
                        alt="Partnership" class="partnership-image">
                </div>
                <div class="col-lg-6">
                    <h1 class="">Partnership</h1>
                    <p class="partnership-description">
                        At Right Freelancer, we believe in the power of collaboration.
                    </p>
                    <p class="partnership-description">
                        Let's create innovative solutions and open new paths to success — together.
                    </p>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row align-items-center">
                <!-- Left Column: Text -->
                <div class="col-lg-6">
                    <h1 class="">Partnership</h1>
                    <p class="partnership-description">
                        At Right Freelancer, we believe in the power of collaboration.
                    </p>
                    <p class="partnership-description">
                        Let's create innovative solutions and open new paths to success — together.
                    </p>
                </div>

                <!-- Right Column: Image -->
                <div class="col-lg-6 text-center">
                    <img src="{{ asset('assets/uploads/partnerimage/Foster-Innovation-&-Growth.jpg') }}" alt="Partnership"
                        class="partnership-image">
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row align-items-center">
                <!-- Left Column: Text -->
                <div class="col-lg-6 text-center">
                    <img src="{{ asset('assets/uploads/partnerimage/Strengthen-Your-Market-Presence.jpg') }}"
                        alt="Partnership" class="partnership-image">
                </div>
                <div class="col-lg-6">
                    <h1 class="">Partnership</h1>
                    <p class="partnership-description">
                        At Right Freelancer, we believe in the power of collaboration.
                    </p>
                    <p class="partnership-description">
                        Let's create innovative solutions and open new paths to success — together.
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection