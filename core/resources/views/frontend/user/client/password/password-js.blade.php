<script>
    (function($){
        "use strict";
        $(document).ready(function(){

            // check current password
            $('#current_password_match').hide();
            $(document).on('keyup','#current_password',function(){
                let current_password = $(this).val();
                $.ajax({
                    url: "{{ route('client.password.check') }}",
                    type: 'post',
                    data: {current_password: current_password},
                    success: function(res){
                        $('#current_password_match').show();
                        if(res.status == 'match'){
                            $("#current_password_match").html("<span style='color: green;'>"+ res.msg +"</span>");
                        }else{
                            $("#current_password_match").html("<span style='color: red;'>"+ res.msg +"</span>");
                        }
                    }
                });
            });

            // password match
            $(document).on('keyup','#confirm_new_password',function(){
                let new_password = $("#new_password").val();
                let confirm_new_password = $("#confirm_new_password").val();
                if (new_password != confirm_new_password) {
                    $("#new_password_match").html("New and confirm new password does not match !").css("color", "red");
                }else {
                    $("#new_password_match").html("Password match !").css("color", "green");
                }
            });

            // change password
            $('#password_change_form').on('submit',function(e){
               e.preventDefault();
               $.ajax({
                   url:"{{ route('client.password') }}",
                   method:'post',
                   data: new FormData(this),
                   processData: false,
                   contentType: false,
                   success:function(res){
                       $('.error_msg_container').html('');
                       if(res.status=='success'){
                           $('#password_change_form').load(location.href + " #password_change_form");
                           toastr_success_js("{{ __('Password successfully changed.') }}");
                       }
                       if(res.status=='not_match'){
                           toastr_warning_js("{{ __('Password and confirm password not match.') }}");
                       }
                       if(res.status=='current_pass_wrong'){
                           toastr_warning_js("{{ __('Current password is wrong.') }}");
                       }
                   },
                   error: function (err) {
                       let error = err.responseJSON;
                       $('.error_msg_container').html('');
                       $.each(error.errors, function (index, value) {
                           $('.error_msg_container').append('<p class="text-danger">'+value+'<p>');
                       });
                   }
               })
            })
              // password strength validation for new_password
            $(document).on('keyup', '#new_password', function() {
                let password = $(this).val();
                let validations = [
                    { regex: /.{6,}/, message: 'Password must be at least 6 characters', valid: false },
                    { regex: /[a-z]/, message: 'Password must include lowercase letters', valid: false },
                    { regex: /[A-Z]/, message: 'Password must include uppercase letters', valid: false },
                    { regex: /\d/, message: 'Password must include numbers', valid: false },
                    { regex: /[@$!%*#?&]/, message: 'Password must include special characters', valid: false },
                ];

                validations.forEach(function(validation) {
                    validation.valid = validation.regex.test(password);
                });

                let errorHtml = '<ul style="margin-top:10px;">';
                validations.forEach(function(validation) {
                    errorHtml += '<li style="color:' + (validation.valid ? 'green' : 'red') + ';">' + validation.message + '</li>';
                });
                errorHtml += '</ul>';

                $("#password_validation").html(errorHtml);
            });

        });
    }(jQuery));

</script>
