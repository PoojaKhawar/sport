// Update Profile Picture
if($('#profile_img').length){
    $('body').on('change','#profile_img', function () {
        that = $(this);
        if(that.attr('data-url'))
        {
            that.parent().css({'opacity': 0.7});
            that.parent().children().prepend('<i class="far fa-spin fa-spinner"></i> ');
            var fd = new FormData();
            var files = $('#profile_img')[0].files;
            fd.append('image',files[0]);
            fd.append('_token', csrf_token());
            fd.append('id', that.attr('data-id'));
            $.ajax({
                url: that.attr('data-url'),
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function(resp){
                    window.scrollTo(0,0);
                    if(resp.status)
                    {
                        $('.profileUpdateImage').find('.profile-user-img').attr('src', resp.image);
                        //$('.dashboard_section').find('.profile-user-img').attr('src', resp.image);
                        $('.flash-message').html('<p class="alert alert-success">'+resp.message+'<button type="button" class="btn close" data-dismiss="alert" aria-label="Close" style="cursor:pointer;"><span aria-hidden="true">×</span></button></p>');
                        that.parent().children().find('i').remove();
                        that.parent().css({'opacity': 1});
                    }
                    else
                    {
                        $('.flash-message').html('<p class="alert alert-danger">'+resp.message+'<button type="button" class="btn close" data-dismiss="alert" aria-label="Close" style="cursor:pointer;"><span aria-hidden="true">×</span></button></p>');
                    }
                    setTimeout(function(){
                        $('.flash-message .alert').fadeOut();
                    }, 2000);
                },
                complete: function(){
                    $('#profile_img').val('');
                }
            })
        }
    });
}

// Confirm Delete
$('body').on('click', '.delete_confirm', function(){
    if(!confirm('Are you sure to delete this record?'))
    {
        return false;
    }
});

// Flash messages hide
$('body').on('click', '.alert .btn.close', function(){
    $(this).parent().remove();
});

// Filter Dropdown Start
$('body').on('click', '.filter-dropdown .btn-default', function() {
     $(this).closest('.dropdown-menu').show();
});

$('.filter-dropdown .dropdown-menu').click(function(e) {
    e.stopPropagation();
});
$('body').on('click', '.filter-dropdown .closeit', function() {
    $(this).parents('.dropdown-menu').hide();
});
// Filter Dropdown End 

if($('#editor1').length){
    init_editor('#editor1');
}

if($('#editor2').length){
    init_editor('#editor2');
}

if($('#editor3').length){
    init_editor('#editor3');
}

// Password Generate Start
$('body').on('click', '.passwordGroup .regeneratePassword', function() {
    var input = $(this).parents('.passwordGroup').find('input');
    input.val(randomString(20));
});

$('#sendPasswordEmail').on('change', function(){
    if($(this).is(':checked'))
    {
        $('.passwordGroup input').removeAttr('required');
        $('.passwordGroup').addClass('d-none');
    }
    else
    {
        $('.passwordGroup input').attr('required', 'required');
        $('.passwordGroup').removeClass('d-none');   
    }
});
// Password Generate End


// Permissions
$('#isAdmin').on('change', function(){
    if($(this).is(':checked'))
        $('#permissionTable').addClass('d-none')
    else
        $('#permissionTable').removeClass('d-none')
});

/* Handle All add, edit modal cases start */
if($('.add_modal_form').length)
{
    insertModalValidate = $('.insert_modal_form').validate();
    $('body').on('submit', '.insert_modal_form', function(){
        if($('.insert_modal_form').valid())
        {
            that = $(this);
            that.find('button[type="submit"]').attr('disabled', true).prepend('<i class="far fa-spin fa-spinner"></i> ');
            action = that.attr('action');
            data = $('.insert_modal_form').serialize();
            $.ajax({
                url: action,
                type: 'POST',
                data: data,
                success: function(resp)
                {
                    if(resp.status == 'success')
                    {
                        that.find('.response_message').html('<p class="alert alert-success">'+resp.message+'<button type="button" class="btn close" data-dismiss="alert" aria-label="Close" style="cursor:pointer;"><span aria-hidden="true">&times;</span></button></p>');
                        
                        $('.add_modal_form form')[0].reset();
                        setTimeout(function(){ 
                            window.location.reload();
                        }, 1000);
                    }

                    if(resp.status == 'error')
                    {
                        that.find('.response_message').html('<p class="alert alert-danger">'+resp.message+'<button type="button" class="btn close" data-dismiss="alert" aria-label="Close" style="cursor:pointer;"><span aria-hidden="true">&times;</span></button></p>');
                    }

                    that.find('button[type="submit"]').attr('disabled', false).find('i').remove();
                }
            });
        }
        return false;
    });

    // Form reset
    $('.add_modal_form').on('hidden.bs.modal', function () {
        $('.add_modal_form form')[0].reset();
        insertModalValidate.resetForm();
    });
}

// Handle Edit all modal cases
if($('.edit_modal_form').length)
{
    updateModalValidate = $('.update_modal_form').validate();
    $('body').on('submit', '.update_modal_form', function(){
        if($('.update_modal_form').valid())
        {
            that = $(this);
            that.find('button[type="submit"]').attr('disabled', true).prepend('<i class="far fa-spin fa-spinner"></i> ');
            action = that.attr('action');
            data = $('.update_modal_form').serialize();
            $.ajax({
                url: action,
                type: 'POST',
                data: data,
                success: function(resp)
                {
                    if(resp.status == 'success')
                    {
                        that.find('.response_message').html('<p class="alert alert-success">'+resp.message+'<button type="button" class="btn close" data-dismiss="alert" aria-label="Close" style="cursor:pointer;"><span aria-hidden="true">&times;</span></button></p>');

                        $('.edit_modal_form form')[0].reset();
                        $('.edit_modal_form form input').val('');
                        
                        setTimeout(function(){
                            window.location.reload();
                        }, 1000);
                    }

                    if(resp.status == 'error')
                    {
                         that.find('.response_message').html('<p class="alert alert-danger">'+resp.message+'<button type="button" class="btn close" data-dismiss="alert" aria-label="Close" style="cursor:pointer;"><span aria-hidden="true">&times;</span></button></p>');
                    }

                    that.find('button[type="submit"]').attr('disabled', false).find('i').remove();
                }
            });
        }
        return false;
    });

    // Form reset
    $('.edit_modal_form').on('hidden.bs.modal', function () {
        $('.edit_modal_form form')[0].reset();
        updateModalValidate.resetForm();
    });
}

// Handle get all modal cases
if($('.get_edit_modal').length)
{
    $('body').on('click', '.get_edit_modal', function(){
        $('.admin_loader').addClass('show');
        url = $(this).attr('data-url');
        modal_class = $(this).attr('data-bs-target');
        $(modal_class + ' .modal-content .form-append').html('');
        $.ajax({
            url: url,
            type: 'get',
            success: function(resp)
            {
                $('.admin_loader').removeClass('show');
                $(modal_class + ' .modal-content .form-append').append(resp.html);
                $(modal_class).modal('show');
            }
        });
        return false;
    });
}

if($('.get_view_modal').length)
{
    $('body').on('click', '.get_view_modal', function(){
        $('.admin_loader').addClass('show');
        url = $(this).attr('data-url');
        modal_class = $(this).attr('data-bs-target');
        $(modal_class + ' .modal-content .view-append').html('');
        $.ajax({
            url: url,
            type: 'get',
            success: function(resp)
            {
                $('.admin_loader').removeClass('show');
                $(modal_class + ' .modal-content .view-append').append(resp.html);
                $(modal_class).modal('show');
            }
        });
        return false;
    });
}
/* Handle All add, edit modal cases end */