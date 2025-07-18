<script>
    (function ($) {
        "use strict";
        $(document).ready(function () {
            $('.country_select2').select2();
            $('#category').select2();
            $('#skill').select2();

            //talent filter
            $(document).on('change', '#country , #category , #level , #talent_badge, #skill', function() {
                profiles();
            });

            // pagination
            $(document).on('click', '.pagination a', function(e){
                e.preventDefault();
                let page = $(this).attr('href').split('page=')[1];
                profiles(page);
            });

            //get pro profile
            $(document).on('change', '#get_pro_profile', function(e){
                e.preventDefault();
                profiles();
            });

            // filter reset
            $(document).on('click', '#talent_filter_reset', function(e){
                e.preventDefault();
                $('#country, #talent_badge, #level, #category, #skill').val('').trigger('change');

                $.ajax({
                    url:"{{ route('talents.filter.reset')}}",
                    method:'GET',
                    success:function(res){
                        if(res.status=='nothing'){
                            $('.search_talent_result').html('<h3 class="text-center text-danger">'+"{{ __('Nothing Found') }}"+'</h3>');
                        }else{
                            $('.search_talent_result').html(res);
                        }
                    }

                });
            });

            //get all profiles
            function profiles(page=1){
                let country = $('#country').val();
                let talent_badge = $('#talent_badge').val();
                let category = $('#category').val();
                let level = $('#level').val();
                let skill = $('#skill').val();
                let get_pro_profiles;

                if($('#get_pro_profile').prop('checked')){
                    $('#get_pro_profile').val('1')
                    get_pro_profiles = $('#get_pro_profile').val()
                }else{
                    $('#get_pro_profile').val('0')
                    get_pro_profiles = $('#get_pro_profile').val()
                }

                $.ajax({
                    url:"{{ route('talents.pagination').'?page='}}" + page,
                    method:'GET',
                    data:{country:country,talent_badge:talent_badge,level:level,category:category,skill:skill,get_pro_profiles:get_pro_profiles},
                    success:function(res){
                        if(res.status=='nothing'){
                            $('.search_talent_result').html(
                                `<div class="congratulation-area section-bg-2 pat-100 pab-100">
                                    <div class="container">
                                        <div class="congratulation-wrapper">
                                            <div class="congratulation-contents center-text">
                                                <div class="congratulation-contents-icon bg-danger wow  zoomIn animated" data-wow-delay=".5s" style="visibility: visible; animation-delay: 0.5s; animation-name: zoomIn;">
                                                    <i class="fas fa-times"></i>
                                                </div>
                                                <h4 class="congratulation-contents-title"> {{ __('OPPS!') }} </h4>
                                                <p class="congratulation-contents-para">{{ __('Nothing') }} <strong>{{ __('Found') }}</strong> </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>`
                            );
                        }else{
                            $('.search_talent_result').html(res);
                        }
                        // Scroll to the talent list section after AJAX update
                        const talentSection = document.getElementById('talent-list-anchor');
                        if (talentSection) {
                            talentSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        }
                    }

                });
            }

        });
    }(jQuery));
</script>
