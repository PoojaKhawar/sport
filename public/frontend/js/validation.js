// Show/Hide Password
let showPasswordHide = {
    body: null,
    passwordEyes: null,

    init: function(){
        this.body = $('body');
        this.passwordEyes = '.pass_view';

        this.body.on('click', this.passwordEyes, this.passwordAction);
    },
    passwordAction: function(){
        let that = $(this);
        that.find('i').toggleClass("fa-eye fa-eye-slash");

        let input = that.parent().find(".toggle-password");
        if(input.attr("type") === "password")
        {
            //that.find('img').attr('src', site_url+'/frontend/images/eye-open.png');
            input.attr("type", "text");
        }
        else
        {
            //that.find('img').attr('src', site_url+'/frontend/images/eye.png');
            input.attr("type", "password");
        }
    }
}
showPasswordHide.init();

// Sign Up Validation
if($('#signUpUser').length)
{
    $("#signUpUser").validate({
        ignore: [],
        rules: {
            name: {
                required: true
            },
            email: {
                email: true,
                required: true,
                emailcheck: true
            },
            phonenumber: {
                required: true
            },
            password: {
                required: true,
                pwcheck: true
            },
            confirm_password: {
                required: true,
                equalTo: "#signup_password"
            },
        },
        messages: {
            name: {
                required: "This field is required.",
            },
            email: {
                required: "This field is required.",
                email: "Please enter a valid email address",
                emailcheck: "Please enter a valid email address"
            },
            phonenumber: {
                required: "This field is required.",
            },
            password : {
                required: "This field is required.",
                pwcheck: 'Password must be a minimum of 8 characters long and contain at least one capital letter (A-Z), one small letter (a-z), one number (0-9) and one special character (!@#$%^&*)'
            },
            confirm_password: {
                required: "This field is required.",
                equalTo: 'Password did not match.'
            },
        }
    });

    $('body').on('submit', '#signUpUser', function(){
        if($('#signUpUser').valid())
        {
            $("#signUpUser button[type='submit']").prepend('<i class="far fa-spin fa-spinner"></i> ').attr('disabled', true);
            return true;
        }
    });
}

// OTP
if($('.otp_validate').length){
    $('.passcode-wrapper input').on('keyup', function(e){
        let that = $(this);
        if(e.keyCode === 8 || e.keyCode === 37)
        {
            var prev = $(that).prev();
            if(prev.length)
            {
                prev.select();
            }
        }
        else if($(this).val() && ((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode === 39))
        {
            var next = $(that).next();    
            if(next.length)
            {
                next.select();
            }
        }
    });
    $('.passcode-wrapper input').on("paste", function(e){
        // access the clipboard using the api
        var pastedData = e.originalEvent.clipboardData.getData('text');
        if(pastedData * 1  > 0)
        {
            let i = 0;
            let parent = $(this).parent('.passcode-wrapper').find('input[type=text]');
            parent.each(function() {
                //console.log(pastedData[i]);
                $(this).val(pastedData[i]);
                i++;
            })
        }
    });

    $('body').on('click', '.otp_validate button[type=button]', function(){
        if(!$('.otp_validate button[type=button] i').length && $('.otp_validate input[name="otp1"]').val() && $('.otp_validate input[name="otp2"]').val() && $('.otp_validate input[name="otp3"]').val() && $('.otp_validate input[name="otp4"]').val() && $('.otp_validate input[name="otp5"]').val() && $('.otp_validate input[name="otp6"]').val())
        {
            $('.otp_validate .otp_error').addClass('d-none').empty();
            $('.otp_validate button[type=button]').prepend('<i class="far fa-spin fa-spinner"></i> ').attr('disabled', true);;
            $(".otp_validate").submit();
        }
        else
        {
            $('.otp_validate .otp_error').removeClass('d-none').html('All fields are required.');
        }
    });
}

// Resend Email OTP
if($('.resend_email_otp').length){
    $('body').on('click', '.resend_email_otp', function(){
        if(!$(this).find('i').length)
        {
            token = $(this).attr('data-token');
            url = $(this).attr('data-url');
            $('.resend_email_otp').prepend('<i class="far fa-spin fa-spinner"></i> ');
            $.ajax({
                url: url,
                type: 'post',
                data: {
                    _token: csrf_token(),
                    token: token
                },
                success: function(resp)
                {
                    if(resp)
                    {
                        $('.resend_email_otp .fa-spinner').replaceWith('<i class="fas fa-check"></i> ');
                        setTimeout(function(){
                            $('.resend_email_otp i').remove();
                        }, 1000)
                    }
                }
            });
        }
    });
}

// Login Validation
if($('#loginUser').length)
{
    $("#loginUser").validate({
        ignore: [],
        rules: {
            email: {
                required : true
            },
            password: {
                required : true
            }
        },
        messages: {
            email: {
                required: "The field is required."
            },
            password: {
                required: "The field is required."
            }
        }
    });

    $('body').on('submit', '#loginUser', function(){
        if($('#loginUser').valid())
        {
            $("#loginUser button[type='submit']").prepend('<i class="far fa-spin fa-spinner"></i> ').attr('disabled', true);
            return true;
        }
    });
}

// Resend Email OTP
if($('.resend_phone_otp').length){
    $('body').on('click', '.resend_phone_otp', function(){
        if(!$(this).find('i').length)
        {
            token = $(this).attr('data-token');
            url = $(this).attr('data-url');
            $('.resend_phone_otp').prepend('<i class="far fa-spin fa-spinner"></i> ');
            $.ajax({
                url: url,
                type: 'post',
                data: {
                    _token: csrf_token(),
                    token: token
                },
                success: function(resp)
                {
                    if(resp)
                    {
                        $('.resend_phone_otp .fa-spinner').replaceWith('<i class="fas fa-check"></i> ');
                        setTimeout(function(){
                            $('.resend_phone_otp i').remove();
                        }, 1000)
                    }
                }
            });
        }
    });
}

// Forgot Password Validation
if($('#forgotUser').length)
{
    $("#forgotUser").validate({
        ignore: [],
        rules: {
            email: {
                email: true,
                required: true,
                emailcheck: true
            }
        },
        messages: {
            email: {
                required: "This field is required.",
                email: "Please enter a valid email address",
                emailcheck: "Please enter a valid email address"
            }
        }
    });
    $('body').on('submit', '#forgotUser', function(){
        if($('#forgotUser').valid())
        {
            $("#forgotUser button[type='submit']").prepend('<i class="far fa-spin fa-spinner"></i> ').attr('disabled', true);
            return true;
        }
    });
}

// Recover Password
if($('#resetUser').length){
    $("#resetUser").validate({
        rules: {
            new_password: {
                required: true,
                pwcheck: true
            },
            confirm_password: {
                equalTo : "input[name='new_password']"
            }
        },
        messages: {
            new_password: {
                required: 'This field is required.',
                pwcheck: 'Password must be a minimum of 8 characters long and contain at least one capital letter (A-Z), one small letter (a-z), one number (0-9) and one special character (!@#$%^&*)'
            },
            confirm_password: {
                equalTo: 'Password did not match.'
            }
        }
    });
    $('body').on('submit', '#resetUser', function(){
        if($('#resetUser').valid())
        {
            $("#resetUser button[type='submit']").prepend('<i class="far fa-spin fa-spinner"></i> ').attr('disabled', true);
            return true;
        }
    });
}

// Edit Profile
if($('#editProfileUser').length)
{
    $("#editProfileUser").validate({
        ignore: [],
        rules: {
            email: {
                email: true,
                required: true,
                emailcheck:true
            }
        },
        messages: {
            email: {
                required: "This field is required.",
                email: "Please enter a valid email address",
                emailcheck: "Please enter valid email address."
            }
        }
    });

    $('body').on('submit', '#editProfileUser', function(){
        if($('#editProfileUser').valid())
        {
            $("#editProfileUser button[type='submit']").prepend('<i class="far fa-spin fa-spinner"></i> ').attr('disabled', true);
            return true;
        }
    });
}

// Update Profile Image
if($('.gz_profile_section').length)
{
    let editProfile = {
        body: null,
        profilePic: null,

        init: function(){
            this.body = $('body');
            this.profilePic = '#profile_pic';

            this.body.on('change', this.profilePic, this.updateProfilePic);
        },
        updateProfilePic: function(){
            let that = $(this);
            if(that.attr('data-url'))
            {
                let url = that.attr('data-url')
                let fd = new FormData();
                let files = $(editProfile.profilePic)[0].files;
                fd.append('image',files[0]);
                fd.append('_token', csrf_token());
                $.ajax({
                    url: url,
                    type: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    success: function(resp){
                        window.scrollTo(0,0);
                        $(editProfile.responseMessage).html('');

                        if(resp.status)
                        {
                            that.parents('.profileUpdateImage').find('.profile-user-img').attr('src', resp.image);
                            $('.dashboard_section .dashboard_inner .box_area .image_area .user-img-warp .user_img img').attr('src', resp.image);

                            $.toaster({
                                priority : 'success',
                                message : resp.message
                            });
                        }
                        else
                        {
                            $.toaster({
                                priority : 'error',
                                message : resp.message
                            });
                        }

                        setTimeout(function(){
                            $(editProfile.responseMessage).html(''); 
                        }, messageHideInterval);
                    },
                    complete: function(){
                        $(editProfile.profilePic).val('');
                    }
                })
            }
        }
    }
    editProfile.init();
}

// Change Password
if($('#changePassword').length){
    $("#changePassword").validate({
        rules: {
            old_password: {
                required: true
            },
            new_password: {
                required: true,
                pwcheck: true
            },
            confirm_password: {
                equalTo : "input[name='new_password']"
            }
        },
        messages: {
            old_password: {
                required: 'This field is required..'
            },
            new_password: {
                required: 'This field is required.',
                pwcheck: 'Password must be a minimum of 8 characters long and contain at least one capital letter (A-Z), one small letter (a-z), one number (0-9) and one special character (!@#$%^&*)'
            },
            confirm_password: {
                equalTo: 'Password did not match.'
            }
        }
    });
    $('body').on('submit', '#changePassword', function(){
        if($('#changePassword').valid())
        {
            $("#changePassword button[type='submit']").prepend('<i class="far fa-spin fa-spinner"></i> ').attr('disabled', true);
            return true;
        }
    });
}