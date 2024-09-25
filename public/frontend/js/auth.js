var messageHideInterval = 1500;

// User Auth
let userAuth = {
    body: null,

    signUpUser: null,
    signUpModalId: null,
    openSignupModal: null,

    loginUser: null,
    loginModalId: null,
    openLoginModal: null,

    forgotUser: null,
    forgotModalId: null,
    forgotOpenmodalId: null,
    forgotCancel: null,

    otpUser: null,
    otpUserSend: null,
    otpModalId: null,

    resetPasswordUser: null,
    resetPasswordModalId: null,
    resetPasswordCancel: null,

    resendOtp: null,

    responseMessage: null,

    googleLogin: null,
    
    init: function(){
        this.body = $('body');

        this.signUpUser = '#signUpUser';

        this.loginUser = '#loginUser';
        this.loginModalId = '#login';
        this.openLoginModal = '#login_modal';

        this.forgotUser = '#forgotUser';
        this.forgotModalId = '#forgot_password';
        this.forgotOpenmodalId = '#forgot_password_modal';
        this.forgotCancel = '.cancel_forgot';

        this.otpUser = '#otpUser';
        this.otpUserSend = '#otp_verify_btn';
        this.otpModalId = '#otp';

        this.resetPasswordUser = '#resetUser';
        this.resetPasswordModalId = '#reset_password';
        this.resetPasswordCancel = '.cancel_reset';

        this.resendOtp = '.auth_resend_otp';

        this.responseMessage = '.response_message';

        this.googleLogin = '.google_login';

        // login
        this.body.on('submit', this.loginUser, this.login);
        this.body.on('click', this.openLoginModal, this.loginModal);

        // Forgot Password
        this.body.on('click', this.forgotOpenmodalId, this.forgotPasswordModal);
        this.body.on('click', this.forgotCancel, this.forgotModalHide);
        this.body.on('submit', this.forgotUser, this.forgotPassword);

        // Signup
        this.body.on('submit', this.signUpUser, this.signup);

        // OTP
        this.body.on('click', this.otpUserSend, this.verifyPhonenumber);

        // Resend OTP
        this.body.on('click', this.resendOtp, this.resendOtpUser);

        // Recover Password
        this.body.on('submit', this.resetPasswordUser, this.recoverPassword);
        this.body.on('click', this.resetPasswordCancel, this.recoverPasswordModalHide);
        
        // Recover Password
        if(recoverToken)
        {
            setTimeout(function(){
                userAuth.recoverPasswordModal();
            }, 500);
        } 

        // Google Login       
        this.body.on('click', this.googleLogin, this.googleWithLogin);
    },
    login: function(){
        if($(userAuth.loginUser).valid() && !$(userAuth.loginUser + ' .button_row button[type="submit"] i').length)
        {
            let that = $(this);
            let url = that.attr('action');
            let data = $(userAuth.loginUser).serialize();

            that.find('.button_row button[type="submit"]').prepend('<i class="far fa-spin fa-spinner"></i> ');

            let authReq;
            if(authReq && authReq.readyState != 4)
            {
                authReq.abort();
            }
            authReq = $.ajax({
                url: url,
                type: "post",
                data: data,
                success: function (resp)
                {
                    $(userAuth.responseMessage).html('');
                    if(resp.status == 'auth')
                    {
                        window.location.href = resp.redirect_url;
                    }
                    else if(resp.status == 'success')
                    {
                        $(userAuth.responseMessage).html('<div class="alert alert-success"><p>'+resp.message+'</p></div>');
                        window.location.href = resp.redirect_url;
                    }
                    else if(resp.status == 'error')
                    {
                        $(userAuth.responseMessage).html('<div class="alert alert-danger"><p>'+resp.message+'</p></div>');
                    }
                    else if(resp.status == 'phonenumber')
                    {
                        $(userAuth.loginModalId).modal('hide');
                        $(userAuth.loginModalId+' form')[0].reset();
                        
                        $(userAuth.otpModalId).modal('show');
                        $(userAuth.otpModalId).find('form').attr('action', resp.redirect_url);
                        $(userAuth.resendOtp).attr('data-token', resp.token);
                    }
                    that.find('.button_row button[type="submit"] i').remove();
                    setTimeout(function(){
                        $(userAuth.responseMessage).html(''); 
                    }, messageHideInterval);
                },
            });
        }
        return false;
    },
    loginModal: function() {
        $(userAuth.signUpModalId+' form')[0].reset();
        $(userAuth.signUpModalId).resetForm();
        $(userAuth.signUpModalId).modal('hide');

        $(userAuth.loginModalId).modal('show');
    },
    forgotPassword: function(){
        if($(userAuth.forgotUser).valid() && !$(userAuth.forgotUser + ' .submit_button button[type="submit"] i').length)
        {
            let that = $(this);
            let url = that.attr('action');
            let data = $(userAuth.forgotUser).serialize();
            that.find('.submit_button button[type="submit"]').prepend('<i class="far fa-spin fa-spinner"></i> ');

            let authReq;
            if(authReq && authReq.readyState != 4)
            {
                authReq.abort();
            }
            authReq = $.ajax({
                url: url,
                type: "post",
                data: data,
                success: function (resp)
                {
                    $(userAuth.responseMessage).html(''); 

                    if(resp.status == 'auth')
                    {
                        window.location.href = resp.redirect_url;
                    }
                    else if(resp.status == 'success')
                    {
                        $(userAuth.responseMessage).html('<div class="alert alert-success"><p>'+resp.message+'</p></div>');
                    }
                    else if(resp.status == 'error')
                    {
                        $(userAuth.responseMessage).html('<div class="alert alert-danger"><p>'+resp.message+'</p></div>');
                    }
                    $(userAuth.forgotModalId+' form')[0].reset();
                    that.find('.submit_button button[type="submit"] i').remove();

                    setTimeout(function(){
                        $(userAuth.responseMessage).html(''); 
                    }, 2000);
                },
            });
        }
        return false;
    },
    forgotPasswordModal: function(){
        $(userAuth.loginModalId).modal('hide');
        $(userAuth.loginModalId+' form')[0].reset();

        $(userAuth.forgotModalId).modal('show');
    },
    forgotModalHide: function(){
        $(userAuth.forgotModalId+' form')[0].reset();
        $(userAuth.forgotModalId).resetForm();
        $(userAuth.forgotModalId).modal('hide');
    },
    signup: function(){
        if($(userAuth.signUpUser).valid() && !$(userAuth.signUpUser + ' .button_row button[type="submit"] i').length)
        {
            let that = $(this);
            let url = that.attr('action');
            let data = $(userAuth.signUpUser).serialize();

            that.find('.button_row button[type="submit"]').prepend('<i class="far fa-spin fa-spinner"></i> ');

            let authReq;
            if(authReq && authReq.readyState != 4)
            {
                authReq.abort();
            }
            authReq = $.ajax({
                url: url,
                type: "post",
                data: data,
                success: function (resp)
                {
                    $(userAuth.responseMessage).html('');
                    if(resp.status == 'auth')
                    {
                        window.location.href = resp.redirect_url;
                    }
                    else if(resp.status == 'success')
                    {
                        $(userAuth.responseMessage).html('<div class="alert alert-success"><p>'+resp.message+'</p></div>');
                        $(userAuth.signUpModalId+' form')[0].reset();
                        $(userAuth.signUpModalId).resetForm();

                        setTimeout(function(){
                            $(userAuth.signUpModalId).modal('hide');
                            $(userAuth.loginModalId).modal('show');
                        }, (messageHideInterval+1000));
                    }
                    else if(resp.status == 'error')
                    {
                        $(userAuth.responseMessage).html('<div class="alert alert-danger"><p>'+resp.message+'</p></div>');
                    }
                    that.find('.button_row button[type="submit"] i').remove();
                    setTimeout(function(){
                        $(userAuth.responseMessage).html(''); 
                    }, messageHideInterval);
                },
            });
        }
        return false;
    },
    verifyPhonenumber: function(){
        if(!$('.otp_validate button[type=button] i').length && $('.otp_validate input[name="otp1"]').val() && $('.otp_validate input[name="otp2"]').val() && $('.otp_validate input[name="otp3"]').val() && $('.otp_validate input[name="otp4"]').val() && $('.otp_validate input[name="otp5"]').val() && $('.otp_validate input[name="otp6"]').val())
        {
            $('.otp_validate .otp_error').addClass('d-none').empty();
            $('.otp_validate button[type=button]').prepend('<i class="far fa-spin fa-spinner"></i> ').attr('disabled', true);

            let that = $(this);
            let url = that.parents('form').attr('action');
            let data = $(userAuth.otpUser).serialize();

            let authReq;
            if(authReq && authReq.readyState != 4)
            {
                authReq.abort();
            }

            authReq = $.ajax({
                url: url,
                type: "post",
                data: data,
                success: function (resp)
                {
                    $(userAuth.responseMessage).html('');
                    if(resp.status == 'success')
                    {
                        $(userAuth.responseMessage).html('<div class="alert alert-success"><p>'+resp.message+'</p></div>');
                        window.location.href = resp.redirect_url;
                    }
                    if(resp.status == 'error')
                    {
                        $(userAuth.responseMessage).html('<div class="alert alert-danger"><p>'+resp.message+'</p></div>');
                    }
                    $('.otp_validate button[type=button] i').remove();
                    $('.otp_validate button[type=button]').attr('disabled', false);
                    setTimeout(function(){
                        $(userAuth.responseMessage).html(''); 
                    }, messageHideInterval);
                },
            });
        }
        else
        {
            $('.otp_validate .otp_error').removeClass('d-none').html('All fields are required.');
        }
        return false;
    },
    resendOtpUser: function(){
        let that = $(this);
        if(!that.find('i').length)
        {
            token = $(this).attr('data-token');
            url = $(this).attr('data-url');
            $(userAuth.resendOtp).prepend('<i class="far fa-spin fa-spinner"></i> ');
            $.ajax({
                url: url,
                type: 'post',
                data: {
                    _token: csrf_token(),
                    token: token
                },
                success: function(resp)
                {
                    $(userAuth.responseMessage).html('');
                    if(resp)
                    {
                        $(userAuth.responseMessage).html('<div class="alert alert-success"><p>'+resp.message+'</p></div>');
                        $(userAuth.resendOtp).find('.fa-spinner').replaceWith('<i class="fas fa-check"></i> ');
                        setTimeout(function(){
                            $(userAuth.resendOtp).find('i').remove();
                        }, messageHideInterval);
                    }
                    setTimeout(function(){
                        $(userAuth.responseMessage).html(''); 
                    }, messageHideInterval);
                }
            });
        }
    },
    recoverPassword: function() {
        if($(userAuth.resetPasswordUser).valid() && !$(userAuth.resetPasswordUser + ' .submit_button button[type="submit"] i').length)
        {
            let that = $(this);
            let url = that.attr('action');
            let data = $(userAuth.resetPasswordUser).serialize();
            that.find('.submit_button button[type="submit"]').prepend('<i class="far fa-spin fa-spinner"></i> ');

            let authReq;
            if(authReq && authReq.readyState != 4)
            {
                authReq.abort();
            }
            authReq = $.ajax({
                url: url,
                type: "post",
                data: data,
                success: function (resp)
                {
                    $(userAuth.responseMessage).html(''); 
                    if(resp.status == 'success')
                    {
                        $(userAuth.responseMessage).html('<div class="alert alert-success"><p>'+resp.message+'</p></div>');
                        $(userAuth.resetPasswordModalId+' form')[0].reset();
                        $(userAuth.resetPasswordModalId).resetForm();
                    }
                    if(resp.status == 'error')
                    {
                        $(userAuth.responseMessage).html('<div class="alert alert-danger"><p>'+resp.message+'</p></div>');
                    }
                    that.find('.submit_button button[type="submit"] i').remove();
                    
                    setTimeout(function(){
                        $(userAuth.responseMessage).html(''); 
                        $(userAuth.resetPasswordModalId).modal('hide');
                    }, 2000);

                    setTimeout(function(){
                        window.history.replaceState('','', site_url);
                    }, 2500);
                },
            });
        }
        return false;
    },
    recoverPasswordModal: function() {
        $(userAuth.resetPasswordModalId).modal('show');
    },
    recoverPasswordModalHide: function(){
        $(userAuth.resetPasswordModalId+' form')[0].reset();
        $(userAuth.resetPasswordModalId).resetForm();
        $(userAuth.resetPasswordModalId).modal('hide');
    },
    closeModalResetForm: function(){
        // Signup
        $(userAuth.signUpModalId+' form')[0].reset();
        $(userAuth.signUpModalId).resetForm();
        // Login
        $(userAuth.loginModalId+' form')[0].reset();
        $(userAuth.loginModalId).resetForm();
        // Forgot
        $(userAuth.forgotModalId+' form')[0].reset();
        $(userAuth.forgotModalId).resetForm();
        // OTP
        $(userAuth.otpModalId+' form')[0].reset();
        $(userAuth.otpModalId).resetForm();
        // Reset Password
        $(userAuth.resetPasswordModalId+' form')[0].reset();
        $(userAuth.resetPasswordModalId).resetForm();
    },
    googleWithLogin: function(){
        let that = $(this);
        let action = that.attr('href');
        if(!that.find('.right_area p i').length)
        {
            that.addClass('no_event');
            that.find('.google_btn_area').css({'background': '#eee'});
            that.find('.right_area p').append(' <i class="far fa-spin fa-spinner"></i>');
            window.location.href = action;
        }
        return false;
    }
}
userAuth.init();



// Edit Profile
if($('.gz_profile_section').length)
{
    let editProfile = {
        body: null,
        editProfileModalId: null,
        editProfileUser: null,
        responseMessage: null,
        profilePic: null,

        init: function(){
            this.body = $('body');
            this.editProfileModalId = '#profile_edit';
            this.editProfileUser = '#editProfileUser';
            this.responseMessage = '.response_message';
            this.profilePic = '#profile_pic';

            this.body.on('submit', this.editProfileUser, this.editProfile);
            this.body.on('change', this.profilePic, this.updateProfilePic);
        },
        editProfile: function(){
            if($(editProfile.editProfileUser).valid() && !$(editProfile.editProfileUser + ' .button_row button[type="submit"] i').length)
            {
                let that = $(this);
                let url = that.attr('action');
                let data = $(editProfile.editProfileUser).serialize();
                that.find('.button_row button[type="submit"]').prepend('<i class="far fa-spin fa-spinner"></i> ');

                let profileReq;
                if(profileReq && profileReq.readyState != 4)
                {
                    profileReq.abort();
                }
                profileReq = $.ajax({
                    url: url,
                    type: "post",
                    data: data,
                    success: function (resp)
                    {
                        $(editProfile.responseMessage).html(''); 

                        if(resp.status == 'success')
                        {
                            $(editProfile.responseMessage).html('<div class="alert alert-success"><p>'+resp.message+'</p></div>');
                            //$(editProfile.editProfileModalId).modal('hide');
                            setTimeout(function(){
                                location.reload();
                            }, 1000);
                        }
                        else if(resp.status == 'error')
                        {
                            $(editProfile.responseMessage).html('<div class="alert alert-danger"><p>'+resp.message+'</p></div>');
                        }

                        that.find('.button_row button[type="submit"] i').remove();

                        
                        setTimeout(function(){
                            $(editProfile.responseMessage).html(''); 
                        }, 2000);
                    },
                });
            }
            return false;
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
                            $('.dashboard_section .dashboard_sec_area .dashboard_inner_area .left_sidebar .user_profile .img_area img').attr('src', resp.image);
                            $(editProfile.responseMessage).html('<div class="alert alert-success"><p>'+resp.message+'</p></div>');
                        }
                        else
                        {
                            $(editProfile.responseMessage).html('<div class="alert alert-danger"><p>'+resp.message+'</p></div>');
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

// Modal
if($('.add_modal_form').length || $('.edit_modal_form').length)
{
    /* Handle All add, edit, view modal cases start */
    let handleAddEditViewModal = {
        body:null,

        addModalFormOption: null,
        addModalFormResetOption: null,

        editModalFormOption: null,
        editModalFormResetOption: null,

        getEditModalOption: null,
        getViewModalOption: null,
        getDeleteModalOption: null,

        responseMessage: null,
        frontLoader: null,

        init: function(){
            this.body = $('body');
            this.responseMessage = '.response_message';
            this.frontLoader = '.front_loader';

            this.getDeleteModalOption = '.delete_modal_box';
            this.body.on('click', this.getDeleteModalOption, this.getDeleteModal);
            
            if($('.add_modal_form').length)
            {
                this.addModalFormOption = '.insert_modal_form';
                this.addModalFormResetOption = '.add_modal_form';

                this.body.on('submit', this.addModalFormOption, this.addModalForm);
                this.body.on('hidden.bs.modal', this.addModalFormResetOption, this.addModalFormReset);
            }

            if($('.edit_modal_form').length)
            {
                this.editModalFormOption = '.update_modal_form';
                this.editModalFormResetOption = '.edit_modal_form';

                this.body.on('submit', this.editModalFormOption, this.editModalForm);
                this.body.on('hidden.bs.modal', this.editModalFormResetOption, this.editModalFormReset);
            }

            if($('.get_edit_modal').length)
            {
                this.getEditModalOption = '.get_edit_modal';
                this.body.on('click', this.getEditModalOption, this.getEditModal);
            }

            if($('.get_view_modal').length)
            {
                this.getViewModalOption = '.get_view_modal';
                this.body.on('click', this.getViewModalOption, this.getViewModal);
            }
        },
        addModalForm: function(){
            if($(handleAddEditViewModal.addModalFormOption).valid())
            {
                let that = $(this);
                that.find('button[type="submit"]').attr('disabled', true).prepend('<i class="far fa-spin fa-spinner"></i> ');
                let action = that.attr('action');
                let data = $(handleAddEditViewModal.addModalFormOption).serialize();

                let modalReq;
                if(modalReq && modalReq.readyState != 4)
                {
                    modalReq.abort();
                }

                modalReq = $.ajax({
                    url: action,
                    type: 'POST',
                    data: data,
                    success: function(resp)
                    {
                        $(handleAddEditViewModal.responseMessage).html('');

                        if(resp.status == 'success')
                        {
                            $(handleAddEditViewModal.responseMessage).html('<div class="alert alert-success"><p>'+resp.message+'</p></div>');
                            
                            $(handleAddEditViewModal.addModalFormResetOption + ' form')[0].reset();
                            
                            setTimeout(function(){ 
                                window.location.reload();
                            }, messageHideInterval);
                        }

                        if(resp.status == 'error')
                        {
                            $(handleAddEditViewModal.responseMessage).html('<div class="alert alert-danger"><p>'+resp.message+'</p></div>');
                        }

                        that.find('button[type="submit"]').attr('disabled', false).find('i').remove();

                        setTimeout(function(){
                            $(handleAddEditViewModal.responseMessage).html(''); 
                        }, messageHideInterval);
                    }
                });
            }
            return false;
        },
        addModalFormReset: function(){
            $(handleAddEditViewModal.addModalFormResetOption + ' form')[0].reset();
            $(handleAddEditViewModal.addModalFormOption).validate().resetForm();
        },
        editModalForm: function(){
            if($(handleAddEditViewModal.editModalFormOption).valid())
            {
                let that = $(this);
                that.find('button[type="submit"]').attr('disabled', true).prepend('<i class="far fa-spin fa-spinner"></i> ');
                let action = that.attr('action');
                let data = $(handleAddEditViewModal.editModalFormOption).serialize();

                let modalReq;
                if(modalReq && modalReq.readyState != 4)
                {
                    modalReq.abort();
                }

                modalReq = $.ajax({
                    url: action,
                    type: 'POST',
                    data: data,
                    success: function(resp)
                    {
                        if(resp.status == 'success')
                        {
                            $(handleAddEditViewModal.responseMessage).html('<div class="alert alert-success"><p>'+resp.message+'</p></div>');
                            
                            $(handleAddEditViewModal.editModalFormResetOption + ' form')[0].reset();
                            $(handleAddEditViewModal.editModalFormResetOption + ' form input').val('');
                            $(handleAddEditViewModal.editModalFormResetOption + ' form select').val('');
                            $(handleAddEditViewModal.editModalFormResetOption + ' form textarea').val('');
                            
                            setTimeout(function(){ 
                                window.location.reload();
                            }, messageHideInterval);
                        }

                        if(resp.status == 'error')
                        {
                            $(handleAddEditViewModal.responseMessage).html('<div class="alert alert-danger"><p>'+resp.message+'</p></div>');
                        }

                        that.find('button[type="submit"]').attr('disabled', false).find('i').remove();

                        setTimeout(function(){
                            $(handleAddEditViewModal.responseMessage).html(''); 
                        }, messageHideInterval);
                    }
                });
            }
            return false;
        },
        editModalFormReset: function(){
            $(handleAddEditViewModal.editModalFormResetOption+' form')[0].reset();
            $(handleAddEditViewModal.editModalFormOption).validate().resetForm();
        },
        getEditModal: function(){
            $(handleAddEditViewModal.frontLoader).addClass('show');
            let that = $(this);
            let url = that.attr('data-url');
            let modal_class = that.attr('data-bs-target');
            $(modal_class + ' .modal-content .form-append').html('');

            let modalReq;
            if(modalReq && modalReq.readyState != 4)
            {
                modalReq.abort();
            }

            modalReq = $.ajax({
                url: url,
                type: 'get',
                success: function(resp)
                {
                    $(handleAddEditViewModal.frontLoader).removeClass('show');

                    $(modal_class + ' .modal-content .form-append').append(resp.html);
                    $(modal_class).modal('show');
                    $(handleAddEditViewModal.editModalFormOption).validate();
                },
                complete: function()
                {
                    initTelInput('#phone-input');
                    initTelInput('#edit-phone-input');
                    initTelInput('#alternative-input');
                    initTelInput('#edit-alternative-input');
                }
            });
            return false;
        },
        getViewModal: function(){
            $(handleAddEditViewModal.frontLoader).addClass('show');
            let that = $(this);
            let url = that.attr('data-url');
            let modal_class = that.attr('data-bs-target');
            $(modal_class + ' .modal-content .view-append').html('');

            let modalReq;
            if(modalReq && modalReq.readyState != 4)
            {
                modalReq.abort();
            }

            modalReq = $.ajax({
                url: url,
                type: 'get',
                success: function(resp)
                {
                    $(handleAddEditViewModal.frontLoader).removeClass('show');
                    $(modal_class + ' .modal-content .view-append').append(resp.html);
                    $(modal_class).modal('show');
                }
            });
            return false;
        },
        getDeleteModal: function(){
            $(handleAddEditViewModal.frontLoader).addClass('show');
            let that = $(this);
            let url = that.attr('data-url');
            let modal_class = that.attr('data-bs-target');
            $(modal_class + ' .modal-content .delete-append').html('');

            let modalReq;
            if(modalReq && modalReq.readyState != 4)
            {
                modalReq.abort();
            }

            modalReq = $.ajax({
                url: url,
                type: 'get',
                success: function(resp)
                {
                    $(handleAddEditViewModal.frontLoader).removeClass('show');
                    $(modal_class + ' .modal-content .delete-append').append(resp.html);
                    $(modal_class).modal('show');
                }
            });
            return false;
        },
    }
    handleAddEditViewModal.init();
    /* Handle All add, edit modal cases end */
}

// Save Address
if($('.save_address_section').length || $('.shipping_section').length)
{
    /* Country, State, City, PostalCode */
    let selectLocation = {
        body: null,
        countryId: null,
        stateId: null,
        cityId: null,
        postalCodeId: null,
        frontLoader: null,
        
        init: function(){
            this.body = $('body');
            this.countryId = '#country_id';
            this.stateId = '#state_id';
            this.cityId = '#city_id';
            this.postalCodeId = '#pincode_id';
            this.frontLoader = $('.front_loader');

            this.body.on('change', this.countryId, this.getStatesByCountryId);
            this.body.on('change', this.stateId, this.getCityByStateId);
            this.body.on('change', this.cityId, this.getPostalCodeByCityId);
        },
        getStatesByCountryId: function(){
            let that = $(this);
            let countryId = that.val();
            $(selectLocation.stateId).empty();

            let stateAjax;
            if(stateAjax && stateAjax.readyState != 4)
            {
                stateAjax.abort();
            }
            
            //selectLocation.frontLoader.addClass('show');
            stateAjax = $.ajax({
                url: site_url + '/actions/states/' + countryId,
                type: 'get',
                success: function(resp)
                {
                    $('#country_id-error').html('').css({'display':'none'});
                    $(selectLocation.stateId).html(resp.html);
                    //selectLocation.frontLoader.removeClass('show');
                    $(selectLocation.cityId).html('<option value="">Select City</option>');
                    $(selectLocation.stateId).select2();
                    $(selectLocation.cityId).select2();
                }
            });
        },
        getCityByStateId: function(){
            let that = $(this);
            let stateId = that.val();
            $(selectLocation.cityId).empty();

            let cityAjax;
            if(cityAjax && cityAjax.readyState != 4)
            {
                cityAjax.abort();
            }
            
            //selectLocation.frontLoader.addClass('show');
            cityAjax = $.ajax({
                url: site_url + '/actions/cities/' + stateId,
                type: 'get',
                success: function(resp)
                {
                    $('#country_id-error').html('').css({'display':'none'});
                    $('#state_id-error').html('').css({'display':'none'});
                    $(selectLocation.cityId).html(resp.html);
                    //selectLocation.frontLoader.removeClass('show');
                    $(selectLocation.cityId).select2();
                }
            });
        },
        getPostalCodeByCityId: function(){
            let that = $(this);
            let cityId = that.val();
            $(selectLocation.postalCodeId).empty();

            let cityAjax;
            if(cityAjax && cityAjax.readyState != 4)
            {
                cityAjax.abort();
            }
            
            //selectLocation.frontLoader.addClass('show');
            cityAjax = $.ajax({
                url: site_url + '/actions/postal-codes/' + cityId,
                type: 'get',
                success: function(resp)
                {
                    $('#country_id-error').html('').css({'display':'none'});
                    $('#state_id-error').html('').css({'display':'none'});
                    $('#city_id-error').html('').css({'display':'none'});
                    $(selectLocation.postalCodeId).html(resp.html);
                    //selectLocation.frontLoader.removeClass('show');
                    $(selectLocation.postalCodeId).select2();
                }
            });
        },
    }
    selectLocation.init();
    /* Country, State, City, PostalCode*/
}

/* Delete saved address */
let deleteAddress = {
    body: null,
    deleteAddress: null,

    init: function(){
        this.body = $('body');
        this.deleteAddress = '.delete_address';

        this.body.on('click', this.deleteAddress, this.confirmDeleteAddress);
    },
    confirmDeleteAddress: function(){
        let that = $(this);
        let url = that.attr('data-url');
        if(!that.find('i').length)
        {
            that.prepend('<i class="far fa-spin fa-spinner"></i> ');
            that.addClass('no_event');
            window.location.href = url;
        }
    }
};
deleteAddress.init();
/* Delete saved address */