// Password Checker
$.validator.addMethod("pwcheck", function(value) {
    return /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*#?&])[A-Za-z\d$@$!%*#?&]{8,}$/.test(value);
});

// Email Checker
$.validator.addMethod("emailcheck", function(value) {
    return /^([\w-\.]+@([\w-]+\.)+[\w-]{2,10})?$/.test(value);
});

// Text Checker
var namesregex = new RegExp("^[a-zA-Z ]*$");
$.validator.addMethod("checkname", function(value) {
    return namesregex.test(value);
});

// Input type number validations
$('input[type="number"]').keydown(function(e){
    return event.keyCode !== 69 ? true : !isNaN(Number(event.key));
});

// Only numbers allowed
$(".number_only").keyup(function(e) {
    var regex = /^[0-9\.]+$/;
    if (regex.test(this.value) !== true)
    this.value = this.value.replace(/[^0-9]+/, '');
});

// Only alphabetic with space allowed
$(".alpha_space").keyup(function(e) {
    var regex = /^[a-zA-Z\s]+$/;
    if (regex.test(this.value) !== true)
    this.value = this.value.replace(/[^a-zA-Z\s]+/, '');
});

// Only alphabetic allowed
$(".alpha_no_space").keyup(function(e) {
    var regex = /^[a-zA-Z]+$/;
    if (regex.test(this.value) !== true)
    this.value = this.value.replace(/[^a-zA-Z]+/, '');
});

// Only alphabetic and number allowed
$(".alpha_number").keyup(function(e) {
    var regex = /^[a-zA-Z0-9]+$/;
    if (regex.test(this.value) !== true)
    this.value = this.value.replace(/[^a-zA-Z0-9]+/, '');
});

// First word Capital
function ucfirst(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

// Check File Extension
function checkFileExtension(filename) {
    return filename.substr((filename.lastIndexOf('.') +1));
}

// Generate a password string
function randomString(limit){
    limit = limit > 0 ? limit : 10;
    var possible = '';
    possible += 'abcdefghijklmnopqrstuvwxyz';
    possible += 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    possible += '0123456789';
    possible += '![]{}()%&*$#^<>~@|';

    var text = '';
    for(var i=0; i < limit; i++) {
        text += possible.charAt(Math.floor(Math.random() * possible.length));
    }
    return text;
}

// Add astr
function asterisk()
{
    $('[required]').parents('.form-group').find('label.form-label').append('<span class="text-danger"> *</span>');
}
asterisk();

// Form Validation
if($('.form-validation').length)
{
    $('.form-validation').validate({
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
    $('body').on('submit', '.form-validation', function(){
        if($('.form-validation').valid())
        {
            $(".form-validation button[type='submit']").prepend('<i class="far fa-spin fa-spinner"></i> ').attr('disabled', true);
            return true;
        }
    });
}

// Reset password validation
if($('.reset-password-validation').length)
{
    $('.reset-password-validation').validate();
    $('body').on('submit', '.reset-password-validation', function(){
        if($('.reset-password-validation').valid())
        {
            $(".reset-password-validation button[type='submit']").prepend('<i class="far fa-spin fa-spinner"></i> ').attr('disabled', true);
            return true;
        }
    });
}

// Recapcha Validation
if($('.recapcha-validation').length)
{
    $('.recapcha-validation').validate();
    $('body').on('submit', '.recapcha-validation', function(){
        if($('.recapcha-validation').valid())
        {
            $(".recapcha-validation button[type='submit']").prepend('<i class="far fa-spin fa-spinner"></i> ').attr('disabled', true);
            return true;
        }
    });
}

// Date & Time Validation
if($('.date-time-validation').length)
{
    $('.date-time-validation').validate();
    $('body').on('submit', '.date-time-validation', function(){
        if($('.date-time-validation').valid())
        {
            $(".date-time-validation button[type='submit']").prepend('<i class="far fa-spin fa-spinner"></i> ').attr('disabled', true);
            return true;
        }
    });
}

// SMTP Validation
if($('.smtp-validation').length)
{
    $('.smtp-validation').validate();
    $('body').on('submit', '.smtp-validation', function(){
        if($('.smtp-validation').valid())
        {
            $(".smtp-validation button[type='submit']").prepend('<i class="far fa-spin fa-spinner"></i> ').attr('disabled', true);
            return true;
        }
    });
}

/* Confirm Delete Start */
let confirmDelete = {
    body: null,
    confirmMessageOption: null,

    init: function(){
        this.body = $('body');
        this.confirmMessageOption = '.delete_confirm';

        this.body.on('click', this.confirmMessageOption, this.confirmMessage);
    },
    confirmMessage: function(){
        if(!confirm('Are you sure to delete this record?'))
        {
            return false;
        }    
    },
}
confirmDelete.init();
/* Confirm Delete End */

/* Flash messages hide start */
let hideFlashMessage = {
    body: null,
    closeAlertOption: null,

    init: function(){
        this.body = $('body');
        this.closeAlertOption = '.alert .btn.close';

        this.body.on('click', this.closeAlertOption, this.closeAlert);
    },
    closeAlert: function(){
        $(this).parent().remove();    
    },
}
hideFlashMessage.init();
/* Flash messages hide end */

// Change Password
if($('.change_password').length)
{
    $(".change_password").validate({
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
    $('body').on('submit', '.change_password', function(){
        if($('.change_password').valid())
        {
            $(".change_password button[type='submit']").prepend('<i class="far fa-spin fa-spinner"></i> ').attr('disabled', true);
            return true;
        }
    });
}

/* Update Profile Picture Start */
if($('#profile_img').length){
    let uploadProfilePicture = {
        body: null,
        profileImage: null,

        init: function(){
            this.body = $('body');
            this.profileImage = '#profile_img';

            this.body.on('change', this.profileImage, this.changeProfilePicture);
        },
        changeProfilePicture: function(){
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
        }
    }
    uploadProfilePicture.init();
}
/* Update Profile Picture End */

/** Handle all Upload File with one function **/
if($('.upload-image-section').length)
{
    /** Upload File Script **/
    $('body').on('click', '.upload-image-section .button-ref button', function(){
        var that = $(this);
        var parent = that.parents('.upload-image-section');
        var uploadSection = parent.find('.upload-section');
        var textArea = parent.find('textarea');
        var textAreaName = textArea.attr('name');
        var textAreaThumb = parent.find('textarea[name="thumbnail"]').length > 0 ? parent.find('textarea[name="thumbnail"]') : parent.find('#thumbnail');
        var showSection = parent.find('.show-section');
        var fixedEditSection = parent.find('.fixed-edit-section');
        var progerssBar = parent.find('.progress-bar');
        var isMultiple = parent.attr('data-multiple') == 'true' ? true : false;
        var fileType = parent.attr('data-type');
        var fileSize = parent.attr("data-size") ? parent.attr("data-size") : null;
        var path = parent.attr('data-path');
        var resizeLarge = parent.attr('data-resize-large');
        resizeLarge = resizeLarge ? resizeLarge : "";
        var resizeMedium = parent.attr('data-resize-medium');
        resizeMedium = resizeMedium ? resizeMedium : "";
        var resizeSmall = parent.attr('data-resize-small');
        var imageLimit = parent.attr("data-images-limit");
        resizeSmall = resizeSmall ? resizeSmall : "";
        
        if(fileType && path)
        {
            parent.find('input[type=hidden]').val('');
            var form = $('#fileUploadForm');
            form.find('input[name=file_type]').val(fileType);
            form.find('input[name=path]').val(path);
            form.find('input[name=resize_large]').val(resizeLarge);
            form.find('input[name=resize_medium]').val(resizeMedium);
            form.find('input[name=resize_small]').val(resizeSmall);
            if(form.find("input[name=file_size]").length)
            {
                form.find("input[name=file_size]").remove();
            } 
            if(fileSize)
            {
                form.append("<input type='hidden' name='file_size' value='"+fileSize+"'>");
            }
        
            $('#fileUploadForm input[type=file]').val('');
            $('#fileUploadForm input').click();
            
            $('#fileUploadForm input').unbind('change');
            
            $('#fileUploadForm input').on('change', function(){
                $('#fileUploadForm').ajaxSubmit({
                    beforeSend: function(){
                        progerssBar.parent().removeClass('d-none');
                        progerssBar.css('width', '0');
                    },
                    uploadProgress: function(event, position, total, percentComplete){
                        progerssBar.css('width', percentComplete + '%');
                    },
                    success: function(response){
                        //console.log(response);
                        if(response.status == 'success')
                        {
                            if(!isMultiple)
                            {
                                if(fileType == 'image' || fileType == 'svg')
                                {
                                    showSection.html('<div class="single-image"><a href="javascript:;" class="fileRemover single-cross image" data-path="'+response.path+'"><i class="fas fa-times"></i></a><img src="'+response.url+'"></div>');
                                }
                                else if(fileType == 'video')
                                {
                                    showSection.html('<div class="single-image"><a href="javascript:;" class="fileRemover single-cross image" data-thumbnail="'+response.thumbnail+'" data-path="'+response.path+'"><i class="fas fa-times"></i></a><img src="'+response.thumbnail_url+'"><a class="video_play" href="'+site_url+response.path+'" target="_blank"><i class="fas fa-play"></i></a></div>');
                                }
                                else if(fileType == 'files')
                                {
                                    ext = checkFileExtension(response.path);

                                    if($.inArray(ext.toLowerCase(), ['jpg', 'jpeg', 'png', 'svg']) !== -1)
                                    {
                                        showSection.html('<div class="single-image"><a href="javascript:;" class="fileRemover single-cross image" data-path="'+response.path+'"><i class="fas fa-times"></i></a><img src="'+response.url+'"></div>');
                                    }
                                    else if($.inArray(ext.toLowerCase(), ['pdf']) > -1)
                                    {
                                        showSection.html('<div class="single-file"><a href="'+site_url + response.path +'" target="_blank"><i class="far fa-file-pdf"></i>'+response.name+'</a><a href="javascript:;" class="fileRemover single-cross file" data-path="'+response.path+'"><i class="fas fa-times-circle"></i></a></div>');
                                    }
                                    else if($.inArray(ext.toLowerCase(), ['docx']) > -1)
                                    {
                                        showSection.html('<div class="single-file"><a href="'+site_url + response.path +'" target="_blank"><i class="far fa-file-word"></i>'+response.name+'</a><a href="javascript:;" class="fileRemover single-cross file" data-path="'+response.path+'"><i class="fas fa-times-circle"></i></a></div>');
                                    }
                                    else if($.inArray(ext.toLowerCase(), ['mp3']) > -1)
                                    {
                                        showSection.html('<div class="single-file"><a href="'+site_url + response.path +'" target="_blank"><i class="fas fa-volume"></i>'+response.name+'</a><a href="javascript:;" class="fileRemover single-cross file" data-path="'+response.path+'"><i class="fas fa-times-circle"></i></a></div>');
                                    }
                                    else if($.inArray(ext.toLowerCase(), ['mp4', 'avi', 'flv', 'mov']) > -1)
                                    {
                                        showSection.html('<div class="single-image"><a href="javascript:;" class="fileRemover single-cross image" data-thumbnail="'+response.thumbnail+'" data-path="'+response.path+'"><i class="fas fa-times"></i></a><img src="'+response.thumbnail_url+'"><a class="video_play" href="'+site_url+response.path+'" target="_blank"><i class="fas fa-play"></i></a></div>');
                                    }
                                }
                                else
                                {
                                    if(fileType == 'audio')
                                    {
                                        icon = '<i class="fas fa-volume"></i>';
                                    }
                                    else
                                    {
                                        icon = '<i class="fas fa-file"></i>';
                                    }
                                    showSection.html('<div class="single-file"><a href="'+site_url + response.path +'" target="_blank">'+icon+''+response.name+'</a><a href="javascript:;" class="fileRemover single-cross file" data-path="'+response.path+'"><i class="fas fa-times-circle"></i></a></div>');
                                }
                                uploadSection.addClass('d-none');
                                fixedEditSection.addClass('d-none');
                            }
                            else
                            {
                                if(fileType == 'image' || fileType == 'svg')
                                {
                                    showSection.prepend('<div class="single-image"><a href="javascript:;" class="fileRemover single-cross image" data-path="'+response.path+'"><i class="fas fa-times"></i></a><img src="'+response.url+'"></div>');
                                }
                                else
                                {
                                    showSection.prepend('<div class="single-file"><a href="'+site_url + response.path +'" target="_blank"><i class="fas fa-file"></i>'+response.name+'</a><a href="javascript:; file" class="fileRemover single-cross file" data-path="'+response.path+'"><i class="fas fa-times-circle"></i></a></div>');
                                }
                            }
                            showSection.removeClass('d-none');
                            updateFileValues(textArea, fileType, isMultiple);
                            textAreaThumb.val(response.thumbnail);

                            parent.find('.required_upload_field').removeAttr('required','');
                            $('.'+textAreaName+'_error').html('');
                        }
                        else
                        {
                            set_notification('error', response.message);
                        }
                    },
                    complete: function() {
                        progerssBar.css('width', '100%');
                        setTimeout(function(){ 
                            if(fileSize)
                            {
                                form.find("input[name=file_size]").remove();
                            }
                            progerssBar.parent().addClass('d-none');
                        }, 100);
                    }
                });
            });
        }
        else
        {
            set_notification('error', 'File path and type are missing.');
        }
    });

    $('body').on('click', '.upload-image-section .fileRemover', function() {
        var that = $(this);
        var parent = that.parents('.upload-image-section');
        var fileType = parent.attr('data-type');
        var textArea = parent.find('textarea');
        var uploadSection = parent.find('.upload-section');
        var showSection = parent.find('.show-section');
        var progerssBar = parent.find('.progress-bar');
        var isMultiple = parent.attr('data-multiple') == 'true' ? true : false;
        if(confirm("Are you sure to delete this file ?"))
        {
            var relation = that.attr('data-relation') ? that.attr('data-relation') : null;
            var relationThumbnail = that.attr('data-relation-thumbnail') ? that.attr('data-relation-thumbnail') : null;
            var id = that.attr('data-id') ? that.attr('data-id') : null;
            //var isMultiple = !$(this).hasClass('single-cross');
            var path = that.attr('data-path');
            var thumbnail = that.attr('data-thumbnail') ? that.attr('data-thumbnail') : null;
            
            $.ajax({
                url: admin_url + '/actions/removeFile',
                type: "post",
                data: {
                    "_token": csrf_token(),
                    "file": path,
                    "relation": relation,
                    "relationThumbnail": relationThumbnail,
                    "thumbnail": thumbnail,
                    "id": id
                },
                success: function(resp) {
                    that.parent().remove();
                    if(!isMultiple)
                    {
                        uploadSection.removeClass('d-none');
                        //showSection.addClass('d-none');
                        progerssBar.parent().addClass('d-none');
                        progerssBar.css('width', 0);

                        parent.find('textarea').val('');
                        parent.find('.required_upload_field').attr('required','required');
                        $('.'+textAreaName+'_error').html('');
                    }

                    updateFileValues(textArea, fileType, isMultiple);
                }
            });
        }
    });

    function updateFileValues(textArea, fileType, isMultiple)
    {
        if(isMultiple)
        {
            files = [];
            textArea.next('.show-section').find('.fileRemover').each(function() {
                var file = $(this).attr('data-path');
                files.push(file);
            });
            textArea.val(files.length > 0 ? JSON.stringify(files) : "");
            textArea.siblings('label.error').empty();
        }
        else
        {
            textArea.val(textArea.parents('.upload-image-section').find('.fileRemover').attr('data-path'));
            textArea.siblings('label.error').empty();
            
            //textArea.val(textArea.next('.show-section').find('.fileRemover').attr('data-path'));
        }
    }
    /** Upload File Script **/
}

// Enable in case ajax paniations working
if($('.listing-table .ajaxPaginationEnabled').length > 0)
{
    var tableReq;
    function get_table_listing(table, data)
    {
        if(!table.hasClass('processing'))
        {
            url = table.find('.loader').attr('data-url');
            page = table.find('.loader').attr('data-page');
            if(page != "")
            {
                table.find('.loader').removeClass('d-none');
                table.addClass('processing');
                next_page = (page*1+1);
                
                search = table.parents('.listing-block').find('.listing-search').val();
                sort = table.find('thead i.active').length ? table.find('thead i.active').attr('data-field') : '';
                direction = table.find('thead i.active').length ? table.find('thead i.active').attr('data-sort') : '';

                filters = $('#filters-form').length ? $('#filters-form').serialize() : '';

                data = 'page=' + next_page + '&sort=' + sort + '&direction=' + direction + '&search=' + search + (filters ? '&' + filters : '');
                if(tableReq && tableReq.readyState != 4)
                {
                    tableReq.abort();
                }
                tableReq = $.ajax({
                    url: url,
                    data: data,
                    success: function(resp){
                        table.find('tbody').append(resp.html);
                        table.find('.loader').attr('data-page', resp.page);
                        table.find('.loader').attr('data-counter', resp.counter);
                        table.find('.loader').attr('data-total', resp.count);
                        if(resp.pagination_counter >= resp.count)
                        {
                            table.find('.loader').addClass('d-none');
                            table.find('.loader').attr('data-page', '');
                        }
                        table.removeClass('processing');
                    }
                });
            }
        }
    }

    $(window).scroll(function(){
       if($(this).scrollTop() > ($(document).height()-$(window).height() - 50))
       {
            table = $('.listing-table');
            get_table_listing(table);
        }
    });
}

//Sorting Tables
if($('.listing-block').length)
{
    //Sorting Tables
    $('.listing-table thead th:not(:first-child)').on('click', function(){
        field = $(this).find('i').attr('data-field');
        sort = $(this).find('i').attr('data-sort');
        direction =  sort && sort == 'asc' ? 'desc' : 'asc';
        icon = sort && sort == 'asc' ? 'fa-sort-up' : 'fa-sort-down';

        if($('.listing-table .ajaxPaginationEnabled').length > 0 && $(this).find('i').length > 0)
        {
            // ajax pagination table  case
            $(this).parents('thead').find('i').removeClass('active').removeClass('fa-sort').removeClass('fa-sort-up').removeClass('fa-sort-down');
            $(this).parents('thead').find('i').addClass('fa-sort');
            $(this).find('i').attr('data-sort', direction);
            $(this).find('i').addClass('active');
            $(this).find('i').addClass(icon);
            loader = $(this).parents('table').find('tfoot .loader')
            loader.attr('data-page', 0);
            loader.removeClass('d-none');

            table = $(this).parents('table');
            table.find('tbody').html('');
            get_table_listing(table);
        }
        else if($(this).find('i').length > 0)
        {
            // refresh pagination table  case
            search = $(this).parents('.listing-block').find('.listing-search').val();
            window.location.href = current_url + "?search=" + search + '&sort=' + field + '&direction=' + direction;
        }
    });

    // Mark all checkbox
    $('body').on('click', '.listing-table .mark_all', function(){
        $('.listing-table .listing_check').prop('checked', $(this).is(':checked'));
    });

    // Search
    $('body').on('keyup', '.listing-search', function(event){
        if($('.listing-table .ajaxPaginationEnabled').length > 0)
        {
            table = $(this).parents('.listing-block').find('.listing-table');
            loader = table.find('tfoot .loader')
            loader.attr('data-page', 0);
            loader.removeClass('d-none');
            table.removeClass('processing');
            table.find('tbody').html('');
            get_table_listing(table);
        }
        else if(event.which === 13) 
        {
            // refresh pagination table case
            search = $(this).val();
            window.location.href = current_url + "?search=" + search;
        }
    });
}

// Bulk Action
function bulk_actions(url, action)
{
    if($('table.listing-table').find('.listing_check:checked').length > 0)
    {
        if(confirm('Are you sure to perform this action?'))
        {
            ids = [];
            $('table.listing-table').find('.listing_check').each(function(){
                if($(this).is(':checked'))
                    ids.push($(this).val());
            });
            if(ids.length > 0)
            {
                $.ajax({
                    url: url,
                    type: 'post',
                    data: {
                        ids : ids,
                        _token: csrf_token()
                    },
                    success: function(resp){
                        if(resp.status == 'success')
                        {
                            window.location.reload();
                        }
                        else
                        {
                            set_notification('error', resp.message);
                        }
                    }
                })
            }
            else
            {
                set_notification('error', 'Please select atleast one record.');
            }
        }
    }
    else
    {
        set_notification('error', 'Please select atleast one record.');
    }
}

// Swith Action
function switch_action(url, that)
{
    $.ajax({
        url: url,
        type: 'post',
        data: {
            flag: $(that).is(':checked') ? 1 : 0,
            _token: csrf_token()
        },
        success: function(resp){
            
            if(resp.status == 'success')
            {
                set_notification('success', resp.message);
            }
            else
            {
                set_notification('error', resp.message);
            }
        }
    })
}

// Toast notification
function set_notification(type, text, placementFrom, placementAlign, animateExit)
{
    if(type == 'success'){
        var colorName = 'bg-success';
    }
    else if(type == 'error'){
        var colorName = 'bg-danger';
    }
    else{
        var colorName = 'bg-primary';
    }

    if(!placementFrom){ 
        placementFrom = 'bottom-0'; 
    }
    if(!placementAlign){ 
        placementAlign = 'end-0'; 
    }
    
    if(!animateExit){
        animateExit = '2000';
    }

    template = '<div class="bs-toast toast toast-placement-ex m-2 fade '+colorName+' '+placementFrom+' '+placementAlign+' hide" role="alert" aria-live="assertive" aria-atomic="true" data-delay="'+animateExit+'">' +
        '<div class="toast-header pb-0">' +
        '<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>' +
        '</div>' +
        '<div class="toast-body">'+text+'</div>' +
        '</div>';

    $('.notificaiton_toaster').html(template);
    $('.toast').toast('show');
}

/* Filter Dropdown Start */
let filterDropdown = {
    body: null,
    
    filterDropdownOption: null,
    dropDownMenuOption: null,
    dropDownMenuCloseOption: null,

    init: function(){
        this.body = $('body');
        this.filterDropdownOption = '.filter-dropdown .btn-default';
        this.dropDownMenuOption = '.filter-dropdown .dropdown-menu';
        this.dropDownMenuCloseOption = '.filter-dropdown .closeit';

        this.body.on('click', this.filterDropdownOption, this.filterDropdown);
        this.body.on('click', this.dropDownMenuOption, this.dropDownMenu);
        this.body.on('click', this.dropDownMenuCloseOption, this.dropDownMenuClose);
    },
    filterDropdown: function(){
        $(this).closest('.dropdown-menu').show();
    },
    dropDownMenu: function(e){
        e.stopPropagation();    
    },
    dropDownMenuClose: function(e){
        $('.dropdown-menu.dropdown-menu-end').click();
        //$(this).parents('.dropdown-menu').click();
    }
}
filterDropdown.init();
/* Filter Dropdown End */ 

/* Ck Editor Start */
let handleCkEditor = {
    init: function(){
        if($('#editor1').length){
            handleCkEditor.editor1();
        }
        if($('#editor2').length){
            handleCkEditor.editor2();
        }
        if($('#editor3').length){
            handleCkEditor.editor3();
        }
    },
    editor1: function(){
        init_editor('#editor1');
    },
    editor2: function(){
        init_editor('#editor2');
    },
    editor3: function(){
        init_editor('#editor3');
    }
}
handleCkEditor.init();
/* Ck Editor End */

/* Password Generate Start */
let passwordGenerate = {
    body: null,
    regeneratePasswordOption: null,
    sendPasswordEmailOption: null,
    init: function(){
        this.body = $('body');
        this.regeneratePasswordOption = '.regeneratePassword';
        this.sendPasswordEmailOption = '#sendPasswordEmail';

        this.body.on('click', this.regeneratePasswordOption, this.regeneratePassword);
        this.body.on('change', this.sendPasswordEmailOption, this.sendPasswordEmail);
    },
    regeneratePassword: function(){
        let input = $(this).parents('.passwordGroup').find('input');
        input.val(randomString(20));
    },
    sendPasswordEmail: function(){
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
    },
}
passwordGenerate.init();
/* Password Generate End */

/* Permissions Start */
let permission = {
    body: null,
    checkedPermissionOption: null,
    init: function(){
        this.body = $('body');
        this.checkedPermissionOption = '#isAdmin';
        this.body.on('change', this.checkedPermissionOption, this.checkedPermission);
    },
    checkedPermission: function(){
        if($(this).is(':checked'))
            $('#permissionTable').addClass('d-none')
        else
            $('#permissionTable').removeClass('d-none')
    },
}
permission.init();
/* Permissions End */

/* Handle All add, edit, view modal cases start */
let handleAddEditViewModal = {
    body:null,

    addModalFormOption: null,
    addModalFormResetOption: null,

    editModalFormOption: null,
    editModalFormResetOption: null,

    getEditModalOption: null,
    getViewModalOption: null,
    
    adminLoader: null,

    init: function(){
        this.body = $('body');

        this.adminLoader = $('.admin_loader');
        
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
        let insertModalForm = $('.insert_modal_form');
        insertModalForm.validate();
        if(insertModalForm.valid())
        {
            let that = $(this);
            that.find('button[type="submit"]').attr('disabled', true).prepend('<i class="far fa-spin fa-spinner"></i> ');
            let action = that.attr('action');
            let data = insertModalForm.serialize();
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
    },
    addModalFormReset: function(){
        $('.add_modal_form form')[0].reset();
        $('.insert_modal_form').validate().resetForm();
    },
    editModalForm: function(){
        let updateModalForm = $('.update_modal_form');
        updateModalForm.validate();
        if(updateModalForm.valid())
        {
            let that = $(this);
            that.find('button[type="submit"]').attr('disabled', true).prepend('<i class="far fa-spin fa-spinner"></i> ');
            let action = that.attr('action');
            let data = updateModalForm.serialize();
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
    },
    editModalFormReset: function(){
        $('.edit_modal_form form')[0].reset();
        $('.update_modal_form').validate().resetForm();
    },
    getEditModal: function(){
        handleAddEditViewModal.adminLoader.addClass('show');
        let that = $(this);
        let url = that.attr('data-url');
        let modal_class = that.attr('data-bs-target');
        $(modal_class + ' .modal-content .form-append').html('');

        $.ajax({
            url: url,
            type: 'get',
            success: function(resp)
            {
                handleAddEditViewModal.adminLoader.removeClass('show');

                $(modal_class + ' .modal-content .form-append').append(resp.html);
                $(modal_class).modal('show');
            }
        });
        return false;
    },
    getViewModal: function(){
        handleAddEditViewModal.adminLoader.addClass('show');
        let that = $(this);
        let url = that.attr('data-url');
        let modal_class = that.attr('data-bs-target');
        $(modal_class + ' .modal-content .view-append').html('');

        $.ajax({
            url: url,
            type: 'get',
            success: function(resp)
            {
                handleAddEditViewModal.adminLoader.removeClass('show');
                $(modal_class + ' .modal-content .view-append').append(resp.html);
                $(modal_class).modal('show');
            }
        });
        return false;
    },
}
handleAddEditViewModal.init();
/* Handle All add, edit modal cases end */

/* Location Like: Country, State, City via ajax start */
let selectLocation = {
    body: null,
    countryId: null,
    stateId: null,
    adminLoader: null,

    init: function(){
        this.body = $('body');
        this.countryId = '#country_id';
        this.stateId = '#state_id';

        this.adminLoader = $('.admin_loader');

        this.body.on('change', this.countryId, this.getStatesByCountryId);
    },
    getStatesByCountryId: function(){
        let stateAjax;
        if(stateAjax && stateAjax.readyState != 4)
        {
            stateAjax.abort();
        }

        let that = $(this);
        let countryId = that.val();
        $('#state_id').empty();
        selectLocation.adminLoader.addClass('show');
        stateAjax = $.ajax({
            url: admin_url + '/actions/states/' + countryId,
            type: 'get',
            success: function(resp)
            {
                $('#state_id').html(resp.html);
                selectLocation.adminLoader.removeClass('show');
            }
        });
    },
}
selectLocation.init();
/* Location Like: Country, State, City via ajax end */


/* Membership add more option start */
if($('.membership_section').length)
{
    let handleMembershipAddMoreFields = {
        body: null,
        createAddonsOptions: null,
        removeAddonsOptions: null,
        init: function(){
            this.body = $('body');

            this.createAddonsOptions = '.create_addons_options';
            this.removeAddonsOptions = '.remove_create_addons_options';

            this.body.on('click', this.createAddonsOptions, this.createAddons);
            this.body.on('click', this.removeAddonsOptions, this.removeAddons);
        },
        getAddMoreOptionsHtml: function(first, key){
            let html =  '<div class="custom_group_option"><div class="left_options_form"><div class="left_f_group"><div class="form-group"><input type="text" class="form-control" name="data['+key+'][title]" value="" placeholder="Enter title" required=""><label id="data['+key+'][title]-error" for="data['+key+'][title]" class="error"></label></div></div><div class="left_f_group"><div class="form-group"><input type="text" class="form-control" name="data['+key+'][description]" value="" placeholder="Enter description" required><label id="data['+key+'][description]-error" for="data['+key+'][description]" class="error"></label></div></div><div class="left_f_group"><div class="form-group"><input type="text" class="form-control" name="data['+key+'][amount]" value="" placeholder="Enter amount" required=""><label id="data['+key+'][amount]-error" for="data['+key+'][amount]" class="error"></label></div></div></div><div class="close_option remove"><a href="javascript:;" class="btn btn-icon btn-danger remove_create_addons_options" data-description="Remove" data-toggle="tooltip"><i class="far fa-times"></i></a></div></div>';

            return html;
        },
        createAddons: function(){
            that = $(this);
            let parent = that.parents('.append_addons_html');

            let first = parent.find('.add_addons_with_options').index();
            let key = parent.find('.add_menu_options_fields').find('.custom_group_option').length;
            let html = handleMembershipAddMoreFields.getAddMoreOptionsHtml(first, key);
            parent.find('.add_menu_options_fields').append(html);

            //
            count = $(".add_menu_options_fields").children(".custom_group_option").find(".left_options_form").length;
            if(count > 0)
            {
                $('.add_menu_options_fields').css({'opacity': 1});
            }
            else
            {
                $('.add_menu_options_fields').css({'opacity': 0});
            }
        },
        removeAddons: function(){
            parent = $(this).parents('.custom_group_option');
            parent.empty();
            parent.css({'border': 0, 'padding-top': 0, 'margin-top': 0});

            //
            count = $(".add_menu_options_fields").children(".custom_group_option").find(".left_options_form").length;
            if(count > 0)
            {
                $('.add_menu_options_fields').css({'opacity': 1});
            }
            else
            {
                $('.add_menu_options_fields').css({'opacity': 0});
            }
        },
    }
    handleMembershipAddMoreFields.init();
}
/* Membership add more option end */


/* Sortable Media Start */
if($('.media_sort').length)
{
    function media_sortable(){
        $(".media_sort").sortable({

            update: function(event, ui){
                that = $(this);
                url = $(this).attr('data-url');
                if(url){
                    saveNewPositionsOFMedia(url,that);
                }
            }
        });
    }

    function saveNewPositionsOFMedia(url,that){
       
        var paths = [];
        var table = "";
        var pageId = "";

        that.find('.single-image').find("a").each(function(){ 
            paths.push($(this).attr('data-path'));
            table = $(this).attr('data-relation');
            pageId = $(this).attr('data-id');
        });

        $.ajax({        
            url: url,
            type:'POST',
            data: {
                paths: paths,
                relation: table,
                id: pageId,
                _token: csrf_token(),
            },
            success:function(resp)
            {
                console.log(resp);
            }
        });
    }
    
    media_sortable();
}
/* Sortable Media End */

/* Allow Table Height Start */
let tableHeight = {
    headerBackground: null,
    
    init: function(){
        this.headerBackground = '.header_background';

        windowHeight = $(window).height();
        let headerHeight = $(this.headerBackground).innerHeight();
        let headerBodyHeight = $('.content-wrapper .header-body').innerHeight();

        $('.listing-block .table-responsive').css({'min-height': (windowHeight-(headerHeight+headerBodyHeight+40))+'px'});
    }
}
tableHeight.init();
/* Allow Table Height End */

/* Export File Start */
let exportFile = {
    body:null,

    exportModalFormOption: null, 
    exportModalFormResetOption: null,
    adminLoader: null,

    daterangepickerOption: null,
    exportTypeOption: null,
    exportOption: null,

    init: function(){
        this.body = $('body');
        this.adminLoader = $('.admin_loader');

        this.exportOption = '#export_excel';
        this.exportModalFormOption = '#exportRecords';
        this.exportModalFormResetOption = '#export';

        this.daterangepickerOption = '#datarangepicker';
        this.exportTypeOption = '#exportRecords input[name="type"]';

        this.body.on('change', this.exportTypeOption, this.exportType);
        this.body.on('click', this.exportOption, this.exportModalData);

        this.dateRangePicker();
        this.body.on('hidden.bs.modal', this.exportModalFormResetOption, this.exportModalFormReset);
    },
    exportModalData: function(){
        let that = $(this);
        that.prepend('<i class="far fa-spin fa-spinner"></i> ');
        let parent = that.parents('form');
        let action = parent.attr('action');

        let filters = $(exportFile.exportModalFormOption+' .filter-query').val();
        let type = parent.find('input[name="type"]:checked').val();
        let daterange = parent.find('input[name="daterange"]').val();
        let data = '?t='+type+'&d='+daterange;
        data += filters != "" ? ('&' + filters) : "";
        var url = action + data;
        window.location.href = url;

        exportFile.exportModalFormReset();

    },
    exportModalFormReset: function(){
        $(exportFile.exportModalFormResetOption).modal('hide');
        $(exportFile.exportOption).find('.fa-spinner').remove();
        // $(exportFile.exportModalFormResetOption+' form')[0].reset();
    },
    dateRangePicker: function(){
        $(exportFile.daterangepickerOption).val('');
        
        $(exportFile.daterangepickerOption).daterangepicker({
            autoUpdateInput: false,
            parentEl: '#daterangeFilter'
        });
        
        $(exportFile.daterangepickerOption).on('apply.daterangepicker', function(ev, picker) {
            $(exportFile.daterangepickerOption).val(picker.startDate.format('MM/DD/YYYY') + '-' + picker.endDate.format('MM/DD/YYYY'));
        });

        $(exportFile.daterangepickerOption).on('cancel.daterangepicker', function(ev, picker) {
            $(exportFile.daterangepickerOption).val('');
        });
    },
    exportType: function(){
        $('#daterangeFilter input').val("");
        let that = $(this);

        if(that.val() == 'all')
        {
            $('#exportRecords .filter-query').val("");
            $('#daterangeFilter').removeClass('d-none');
            $('#filteredMessage').addClass('d-none');
        }
        else if(that.val() == 'filtered')
        {
            $('#exportRecords .filter-query').val($('#filters-form').serialize());
            $('#daterangeFilter').addClass('d-none');
            $('#filteredMessage').removeClass('d-none');
            $('#filteredMessage .filter-rows').remove();
            
            var title = null;
            var value = null;
            var html = '';
            
            $('#filters-form .dropdown-item').each(function(){
                title = null;
                value = null;
                that = $(this);

                if(that.find('input').val())
                {
                    if(that.find('input[name="created_on[0]"]').val() && that.find('input[name="created_on[1]"]').val())
                    {
                        title = that.find('.form-label').text();
                        value = that.find('input[name="created_on[0]"]').val() + ' - ' + that.find('input[name="created_on[1]"]').val();
                    }
                    else
                    {
                        if(that.find('input[name="last_login[0]"]').val() && that.find('input[name="last_login[1]"]').val())
                        {
                            title = that.find('.form-label').text();
                            value = that.find('input[name="last_login[0]"]').val() + ' - ' + that.find('input[name="last_login[1]"]').val();    
                        }
                        else
                        {
                            title = that.find('.form-label').text();
                            value = that.find('input').val();
                        }
                    }
                }

                if(that.find('input[type="radio"]:checked').val())
                {
                    title = that.find('.form-label').text();
                    value = ucfirst(that.find('input[type="radio"]:checked').attr('id'));
                }

                if(that.find('select').val())
                {
                    title = that.find('.form-label').text();
                    value = that.find("select option:selected").map(function () {
                        return $(this).text();
                    }).get().join(', ');
                }

                if(title && value)
                {
                    html += '<span><i class="fas fa-dot-circle me-2 text-primary"></i><span class="status"><b>'+title+':</b> '+value+'</span></span><br />';
                }
            });

            if(html != "")
            {
                $('#filteredMessage').append('<p class="filter-rows">' + html + '</p>');
            }
        }
    }
}
exportFile.init();
/* Export File End */

/* Admin role form-group show and hide start */
let selectRole = {
    body: null,
    roleId: null,
    adminRoleOption: null,
    adminId: null,

    init: function(){
        this.body = $('body');
        this.roleId = '#role';
        this.adminId = '#isAdmin';
        this.adminRoleOption = '.admin_role_col';

        this.body.on('change', this.adminId, this.roleSelect);
    },
    roleSelect: function(){
        let that = $(this);
        if(that.is(":checked"))
        {
            $(selectRole.adminRoleOption).addClass('d-none');
        }
        else
        {
            $(selectRole.adminRoleOption).removeClass('d-none');
        }
    }
}
selectRole.init();
/* Admin role form-group show and hide end */


windowWidth = $(window).width();

if(windowWidth > 1300 && windowWidth < 1400)
{
    // Function to set the zoom level
    function setZoomLevel(zoomLevel){
        document.body.style.zoom = zoomLevel;
    }

    // Set the zoom level on page load
    window.onload = function(){
        // Set the desired zoom level (e.g., 1.2 for 120% zoom)
        var desiredZoomLevel = 0.9;
        
        // Call the function to set the zoom level
        setZoomLevel(desiredZoomLevel);
    };
}