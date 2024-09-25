// Password Checker
$.validator.addMethod("pwcheck", function(value) {
    return /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*#?&])[A-Za-z\d$@$!%*#?&]{8,}$/.test(value);
});

// Email Checker
$.validator.addMethod("emailcheck", function(value) {
    return /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/.test(value);
});

// Text Checker
var namesregex = new RegExp("^[a-zA-Z ]*$");
$.validator.addMethod("checkname", function(value) {
    return namesregex.test(value);
});

// Only numbers allowed
$(".number_only").keyup(function(e) {
    var regex = /^[0-9]+$/;
    if (regex.test(this.value) !== true)
    this.value = this.value.replace(/[^0-9]+/, '');
});

// Form Validation
$('.form-validation').validate();

if($('#login').length)
{
    $("#login").validate({
        rules: {
            email: {
                email: true,
                required: true,
                emailcheck: true
            },
            password: {
                required: true,
            }
        },
        messages: {
            email: {
                required: "Please enter your email",
                email: "Please enter a valid email address.",
                emailcheck: "Please enter a valid email"
            },
            password: {
                required: "The field is required"            
            }
        }
    });
    $('body').on('submit', '#login', function(){
        if($('#login').valid())
        {
            $("#login button[type='submit']").prepend('<i class="far fa-spin fa-spinner"></i> ').attr('disabled', true);
            return true;
        }
    });
}

// Recover Password
if($('#recover_password').length)
{
    $("#recover_password").validate({
        rules: {
            new_password: {
                required: true,
                pwcheck: true
            },
            confirm_password : {
                equalTo : "[name=new_password]"
            }
        },
        messages: {
            new_password: {
                pwcheck: 'Password must be a minimum of 8 characters long and contain at least one capital letter (A-Z), one small letter (a-z), one number (0-9) and one special character (!@#$%^&*)'
            },
            confirm_password: {
                equalTo: 'Password did not match.'
            }
        }
    });
    $('body').on('submit', '#recover_password', function(){
        if($('#recover_password').valid())
        {
            $("#recover_password button[type='submit']").prepend('<i class="far fa-spin fa-spinner"></i> ').attr('disabled', true);
            return true;
        }
    });
}

// Change Password
if($('#change_password').length)
{
    $("#change_password").validate({
        rules: {
        	old_password: {
                required: true
            },
            new_password: {
                required: true,
                pwcheck: true
            },
            confirm_password : {
                equalTo : "[name=new_password]"
            }
        },
        messages: {
            new_password: {
                pwcheck: 'Password must be a minimum of 8 characters long and contain at least one capital letter (A-Z), one small letter (a-z), one number (0-9) and one special character (!@#$%^&*)'
            },
            confirm_password: {
                equalTo: 'Password did not match.'
            }
        }
    });
    $('body').on('submit', '#change_password', function(){
        if($('#change_password').valid())
        {
            $("#change_password button[type='submit']").prepend('<i class="far fa-spin fa-spinner"></i> ').attr('disabled', true);
            return true;
        }
    });
}