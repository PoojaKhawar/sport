if($('#contactUsForm').length)
{
    $("#contactUsForm").validate({
        rules: {
            first_name: {
                required: true,
            },
            last_name: {
                required: true,
            },
            company_name: {
                required: true,
            },
            country: {
                required: true,
            },
            phonenumber: {
                required: true,
                digits: true,
                minlength: 10,
                maxlength: 14,
            },
            email: {
                email: true,
                required: true,
                pattern: /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/,
            },
            subject : {
                required: true,
                maxlength: 150,
            },
            message : {
                required : true,
                maxlength: 300,
            },
        },
        messages: {
            first_name: {
                required: "Please enter your First Name.",
            },
            last_name: {
                required: "Please enter your Last Name.",
            },
            company_name: {
                required: "Please enter your Company Name.",
            },
            country: {
                required: "Please enter your Country Name.",
            },
            phonenumber: {
                required: "Phone number is required",
                minlength: "Phone number must be at least 10 digits",
                maxlength: "Phone number not more than 14 digits",
            },
            email: {
                required: "Please enter your email.",
                email: "Please enter a valid email address.",
                pattern:"Please enter a valid email address.",
            },
            subject : {
                maxlength: "subject not more than 150 character",
            },
            messages : {
                maxlength: "subject not more than 300 character",
            }
        },
    });

    $('body').on('submit', '#contactUsForm', function (e) {
        e.preventDefault()

        $('#loading-image').show();
        that = $(this);
        data = that.serialize();
        url  = that.attr('action');

        that.find("button[type='submit']").prop("disabled", true);
        that.find("button[type='submit']").html(`<div class="spinner-border spinner-border-sm" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>`);

        $.ajax({
            url: url,
            type: 'post',
            data: data,
            success: function(resp)
            {
                $('#contactUsForm')[0].reset();
                if(resp.status == 'success')
                {
                    $.toaster({
                        priority : 'success',
                        message : resp.message
                    });
                }

                if(resp.status == 'error')
                {
                    $.toaster({
                        priority : 'danger',
                        message : resp.message
                    });
                }
            },
            complete: function()
            {
                if (typeof reCaptchaLoad === 'function') {
                    reCaptchaLoad();
                }
                
                $('#loading-image').hide();
                that.find("button[type='submit']").prop("disabled", false);
                that.find("button[type='submit']").html('Submit');
            }
        });   
    });
}