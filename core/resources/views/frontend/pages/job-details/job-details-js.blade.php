<script>
    (function ($) {
        "use strict";
        $(document).ready(function () {

            //prevent multiple submit
            $('#job_proposal_form').on('submit', function () {
                $('.send_job_proposal').attr('disabled', 'true');
            });

            // proposal validate
            $(document).on('click', '.send_job_proposal', function(e){
                let amount = $('#job_proposal_form #amount').val();
                let duration = $('#job_proposal_form #duration').val();
                let revision = $('#job_proposal_form #revision').val();
                let cover_letter = $('#job_proposal_form #cover_letter').val();

                if(amount == '' || duration == '' || cover_letter == '' || revision == ''){
                    toastr_warning_js("{{ __('Except attachment all fields required!') }}")
                    return false;
                }else if(amount<1){
                    toastr_warning_js("{{ __('Amount must be greater than 1.') }}")
                    return false;
                }else if(cover_letter.length<10){
                    toastr_warning_js("{{ __('Cover letter must be greater than 10 characters.') }}")
                    return false;
                }else{
                    $('#send_proposal_load_spinner').html('<i class="fas fa-spinner fa-pulse"></i>')

                }

            });

            //tooltip
            $("body").tooltip({ selector: '[data-toggle=tooltip]' });

            function updateFeeAndReceive() {
                let amount = parseFloat($('#job_proposal_form #amount').val());
                let commissionType = '{{ get_static_option('admin_commission_type') }}';
                let commissionCharge = parseFloat('{{ get_static_option('admin_commission_charge') }}');

                if (!isNaN(amount) && amount > 0) {
                    let fee = 0;
                    if (commissionType === 'percentage') {
                        fee = (amount * commissionCharge / 100).toFixed(2);
                    } else if (commissionType === 'fixed') {
                        fee = commissionCharge.toFixed(2);
                    }
                    let receive = (amount - fee).toFixed(2);
                    $('#service_fee').val(fee);
                    $('#you_receive').val(receive);
                } else {
                    $('#service_fee').val('');
                    $('#you_receive').val('');
                }
            }
            $('#job_proposal_form #amount').on('input', updateFeeAndReceive);
            // Run on page load
            updateFeeAndReceive();

        });
    }(jQuery));
</script>
