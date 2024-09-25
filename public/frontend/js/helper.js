// Password Checker
$.validator.addMethod("pwcheck", function(value) {
    return /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*#?&])[A-Za-z\d$@$!%*#?&]{8,}$/.test(value);
});

// Email Checker
$.validator.addMethod("emailcheck", function(value) {
    return /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i.test(value);
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

function ucfirst(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

function checkFileExtension(filename) {
    return filename.substr((filename.lastIndexOf('.') +1));
}
// success and error message
setTimeout(function(){
    $('.flash-message .alert').fadeOut();
    $('.flash-message .callout').fadeOut();
}, 8000);

$('body').on('click', '.flash-message .btn.close', function(){
    $(this).parents('.flash-message').html('');
});

// Add astr
function asterisk()
{
    $('[required]').parents('.form-group').find('label.set_error').append('<span class="text-danger"> *</span>');
}
asterisk();

// Form Validation for all forms
if($('.form-validation').length){
    $('.form-validation').validate();
}

// Select 2
if($('.select2').length){
    $('.select2').select2();
}

// Tooltip
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
});

$('body').on('click', '.delete_confirm', function(){
    if(!confirm('Are you sure to delete this record?')){
        return false;
    }
});

/** Handle all Upload File with one function **/
if($('.upload-image-section').length)
{
     $('body').on('click','.file_upload',function(){
        $(this).parents('div.upload').find('div.upload-image-section').find('.button-ref').click();        
    });


    $('.upload-section').on('dragenter', function() {
        $(this).addClass('dragging');
    });

    $('.upload-section').on('dragleave', function() {
        $(this).removeClass('dragging');
    });
    
    /** Upload File Script **/
    $('body').on('change', '.upload-image-section .button-drag input[type=file]', async function(){
        var that = $(this);
        if(that.val()) {
            var parentUpload = that.parents('.upload-image-section');
            var uploadSection = parentUpload.find('.upload-section');
            var textArea = parentUpload.find('textarea[name="image[]"]');
            var textAreaThumb = parentUpload.find('textarea[name="thumbnail"]');
            var showSection = parentUpload.find('.show-section');
            var fixedEditSection = parentUpload.find('.fixed-edit-section');
            var progerssBar = parentUpload.find('.progress-bar');
            var isMultiple = parentUpload.attr('data-multiple') == 'true' ? true : false;
            var fileType = parentUpload.attr('data-type');
            var path = parentUpload.attr('data-path');
            var resizeLarge = parentUpload.attr('data-resize-large');
            resizeLarge = resizeLarge ? resizeLarge : "";
            var resizeMedium = parentUpload.attr('data-resize-medium');
            resizeMedium = resizeMedium ? resizeMedium : "";
            var resizeSmall = parentUpload.attr('data-resize-small');
            resizeSmall = resizeSmall ? resizeSmall : "";

            // Custom
            var dataSort = parentUpload.attr('data-sort-option') == 'true' ? true : false;
            var progerssLoader = parentUpload.find('.progress_loader');
            if(fileType && path)
            {
                var fd = new FormData();
                fd.append('_token', csrf_token());
                fd.append('file_type', fileType);
                fd.append('path', path);
                fd.append('resize_large', resizeLarge);
                fd.append('resize_medium', resizeMedium);
                fd.append('resize_small', resizeSmall);
                fd.append('file', that[0].files[0]);

                progerssBar.parent().removeClass('d-none');
                progerssBar.css('width', '0');
                progerssLoader.removeClass('d-none');
                //console.log(fd);
                
                let formAjax = await fetch(
                    site_url+'/actions/cropperUploadFile', 
                    {
                        method: 'POST',
                        body: fd
                    }
                );
                let response = await formAjax.json();
                //console.log(result);

                if(response.status == 'success')
                {
                    parentUpload.find('.upload-message').empty();
                    if(fileType == 'image')
                    {
                        sortHtml = '';
                        if(dataSort)
                        {
                            sortHtml = '<div class="arrow_icon"><a href="javascript:;" class="icon_box"><i class="far fa-arrows"></i></a></div>';   
                        }
                        showSection.html('<div class="single-image"><a href="javascript:;" class="fileRemoverCropper single-cross image" data-path="'+response.path+'"><i class="fas fa-times"></i></a><a href="javascript:;" class="edit_image" data-bs-toggle="modal" data-bs-target=".add_modal_cropper"><i class="fas fa-pencil"></i></a>'+sortHtml+'<img src="'+response.url+'"></div>');
                        showSection.removeClass('d-none');
                    }
                    uploadSection.addClass('d-none');
                    fixedEditSection.addClass('d-none');
                    textArea.val( JSON.stringify({path:response.path, crop: null}) );
                    
                }
                else
                {
                    parentUpload.find('.upload-message').html('<p class="alert alert-danger">'+response.message+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></p>');
                    
                    if(progerssLoader)
                    {
                        $.toaster({
                            priority : 'danger',
                            message : response.message
                        });
                    }
                }
            }
            else
            {
                set_notification('error', 'File path and type are missing.');
            }
        }
    });
    
    $('body').on('click', '.upload-image-section .fileRemoverCropper', function() {
        var parent = $(this).parents('.upload-image-section');
        var uploadSection = parent.find('.upload-section');
        var showSection = parent.find('.show-section');
        var progerssBar = parent.find('.progress-bar');
        var progerssLoader = parent.find('.progress_loader');
        var confirm_status = parent.attr('data-confirm') ? parent.attr('data-confirm') : confirm("Are you sure to delete this file ?");
        if(confirm_status)
        {
            var relation = $(this).attr('data-relation') ? $(this).attr('data-relation') : null;
            var relationThumbnail = $(this).attr('data-relation-thumbnail') ? $(this).attr('data-relation-thumbnail') : null;
            var id = $(this).attr('data-id') ? $(this).attr('data-id') : null;
            var isMultiple = !$(this).hasClass('single-cross');
            var that = $(this);
            //var path = $(this).attr('data-path');
            var path = parent.find('textarea').val();
            var thumbnail = $(this).attr('data-thumbnail');
            parent.find('textarea').val('');
            parent.find('.required_upload_field').attr('required','required');
            
            $.ajax({
                url: site_url + '/actions/removeFileCropper',
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
                        showSection.addClass('d-none');
                        progerssBar.css('width', 0);
                        progerssLoader.addClass('d-none');
                    }
                }
            });
        }
    });

    $('body').on('click', '.upload-image-section .button-ref', function(){
        var that = $(this);
        var parentUpload = that.parents('.upload-image-section');
        var uploadSection = parentUpload.find('.upload-section');
        var textArea = parentUpload.find('.file_upload') ? parentUpload.find('.file_upload') : parentUpload.find('textarea');
        var textAreaThumb = parentUpload.find('textarea[name="thumbnail"]');
        var showSection = parentUpload.find('.show-section');
        var fixedEditSection = parentUpload.find('.fixed-edit-section');
        var progerssBar = parentUpload.find('.progress-bar');
        var isMultiple = parentUpload.attr('data-multiple') == 'true' ? true : false;
        var fileType = parentUpload.attr('data-type');
        var path = parentUpload.attr('data-path');
        var baseName = parentUpload.find('#getFileValue');
        var resizeLarge = parentUpload.attr('data-resize-large');
        resizeLarge = resizeLarge ? resizeLarge : "";
        var resizeMedium = parentUpload.attr('data-resize-medium');
        resizeMedium = resizeMedium ? resizeMedium : "";
        var resizeSmall = parentUpload.attr('data-resize-small');
        resizeSmall = resizeSmall ? resizeSmall : "";

        // Custom
        var dataSort = parentUpload.attr('data-sort-option') == 'true' ? true : false;
        var progerssLoader = parentUpload.find('.progress_loader');
        
        if(fileType && path)
        {
            parentUpload.find('input[type=hidden]').val('');
            var form = $('#fileUploadForm');
            form.find('input[name=file_type]').val(fileType);
            form.find('input[name=path]').val(path);
            form.find('input[name=resize_large]').val(resizeLarge);
            form.find('input[name=resize_medium]').val(resizeMedium);
            form.find('input[name=resize_small]').val(resizeSmall);
        
            $('#fileUploadForm input[type=file]').val('');
            $('#fileUploadForm input').click();
            
            $('#fileUploadForm input').unbind('change');
            
            $('#fileUploadForm input').on('change', function() {
                $('#fileUploadForm').ajaxSubmit({
                    beforeSend: function() {
                        progerssBar.parent().removeClass('d-none');
                        progerssBar.css('width', '0');
                        progerssLoader.removeClass('d-none');
                    },
                    uploadProgress: function(event, position, total, percentComplete) {
                        progerssBar.css('width', percentComplete + '%');
                    },
                    success: function(response) {
                        //console.log(response);
                        if(response.status == 'success')
                        {
                            parentUpload.find('.upload-message').empty();
                            if(!isMultiple)
                            {
                                if(fileType == 'image')
                                {
                                    sortHtml = '';
                                    if(dataSort)
                                    {
                                        sortHtml = '<div class="arrow_icon"><a href="javascript:;" class="icon_box"><i class="far fa-arrows"></i></a></div>';   
                                    }
                                    showSection.html('<div class="single-image"><a href="javascript:;" class="fileRemover single-cross image" data-path="'+response.path+'"><i class="fas fa-times"></i></a>'+sortHtml+'<img src="'+response.url+'"></div>');
                                }
                                else if(fileType == 'video')
                                {
                                    sortHtml = '';
                                    if(dataSort)
                                    {
                                        sortHtml = '<div class="arrow_icon"><a href="javascript:;" class="icon_box_video"><i class="far fa-arrows"></i></a></div>';
                                    }

                                    showSection.html('<div class="single-image"><a href="javascript:;" class="fileRemover single-cross image" data-thumbnail="'+response.thumbnail+'" data-path="'+response.path+'"><i class="fas fa-times"></i></a>'+sortHtml+'<img src="'+response.thumbnail_url+'"></div>');
                                }
                                else if(fileType == 'files')
                                {
                                    ext = checkFileExtension(response.path);

                                    if($.inArray(ext.toLowerCase(), ['jpg', 'jpeg', 'png']) !== -1)
                                    {
                                        showSection.html('<div class="single-image d-none"><a href="javascript:;" class="fileRemover single-cross image" data-value="'+response.base_name+'" data-path="'+response.path+'"><i class="fas fa-times"></i></a><img src="'+response.url+'"></div>');
                                    }
                                    else if($.inArray(ext.toLowerCase(), ['pdf']) > -1)
                                    {
                                        showSection.html('<div class="single-image d-none"><a href="javascript:;" class="fileRemover single-cross image" data-value="'+response.base_name+'" data-path="'+response.path+'"><i class="fas fa-times"></i></a><img src="'+site_url+'/frontend/images/icon/pdf.png"></div>');
                                    }
                                    else if($.inArray(ext.toLowerCase(), ['docx']) > -1)
                                    {
                                        showSection.html('<div class="single-image d-none"><a href="javascript:;" class="fileRemover single-cross image" data-value="'+response.base_name+'" data-path="'+response.path+'"><i class="fas fa-times"></i></a><img src="'+site_url+'/frontend/images/icon/docx.png"></div>');
                                    }
                                    else if($.inArray(ext.toLowerCase(), ['doc']) > -1)
                                    {
                                        showSection.html('<div class="single-image d-none"><a href="javascript:;" class="fileRemover single-cross image" data-value="'+response.base_name+'" data-path="'+response.path+'"><i class="fas fa-times"></i></a><img src="'+site_url+'/frontend/images/icon/docx.png"></div>');
                                    }
                                }
                                else if(fileType == 'only_files')
                                {
                                    ext = checkFileExtension(response.path);

                                    if($.inArray(ext.toLowerCase(), ['jpg', 'jpeg', 'png']) !== -1)
                                    {
                                        showSection.html('<div class="single-image d-none"><a href="javascript:;" class="fileRemover single-cross image" data-value="'+response.base_name+'" data-path="'+response.path+'"><i class="fas fa-times"></i></a><img src="'+response.url+'"></div>');
                                    }
                                    else if($.inArray(ext.toLowerCase(), ['pdf']) > -1)
                                    {
                                        showSection.html('<div class="single-image d-none"><a href="javascript:;" class="fileRemover single-cross image" data-value="'+response.base_name+'" data-path="'+response.path+'"><i class="fas fa-times"></i></a><img src="'+site_url+'/frontend/images/icon/pdf.png"></div>');
                                    }
                                    else if($.inArray(ext.toLowerCase(), ['docx']) > -1)
                                    {
                                        showSection.html('<div class="single-image d-none"><a href="javascript:;" class="fileRemover single-cross image" data-value="'+response.base_name+'" data-path="'+response.path+'"><i class="fas fa-times"></i></a><img src="'+site_url+'/frontend/images/icon/docx.png"></div>');
                                    }
                                    else if($.inArray(ext.toLowerCase(), ['doc']) > -1)
                                    {
                                        showSection.html('<div class="single-image d-none"><a href="javascript:;" class="fileRemover single-cross image" data-value="'+response.base_name+'" data-path="'+response.path+'"><i class="fas fa-times"></i></a><img src="'+site_url+'/frontend/images/icon/docx.png"></div>');
                                    }
                                }
                                else
                                {
                                    showSection.html('<div class="single-file"><a href="'+site_url + response.path +'" target="_blank"><i class="fas fa-file"></i>'+response.name+'</a><a href="javascript:; file" class="fileRemover single-cross file" data-path="'+response.path+'"><i class="fas fa-times-circle"></i></a></div>');
                                }
                                // uploadSection.addClass('d-none');
                                fixedEditSection.addClass('d-none');
                            }
                            else
                            {
                                if(fileType == 'image')
                                {
                                    showSection.prepend('<div class="single-image"><a href="javascript:;" class="fileRemover single-cross image" data-path="'+response.path+'"><i class="fas fa-times"></i></a><img src="'+response.url+'"></div>');
                                }
                                else
                                {
                                    showSection.prepend('<div class="single-file"><a href="'+site_url + response.path +'" target="_blank"><i class="fas fa-file"></i>'+response.name+'</a><a href="javascript:; file" class="fileRemover single-cross file" data-path="'+response.path+'"><i class="fas fa-times-circle"></i></a></div>');
                                }
                            }
                            showSection.removeClass('d-none');
                            updateFileValues(textArea, fileType, isMultiple, baseName);
                            textAreaThumb.val(response.thumbnail);
                        }
                        else
                        {
                            parentUpload.find('.upload-message').html('<p class="alert alert-danger">'+response.message+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></p>');
                            
                            progerssBar.addClass('d-none');
                            if(progerssLoader)
                            {
                                $.toaster({
                                    priority : 'danger',
                                    message : response.message
                                });
                            }
                        }
                    },
                    complete: function() {
                        if(progerssBar.css('width', '100%'))
                        {
                             progerssBar.addClass('d-none');
                        }
                        
                        if(progerssLoader)
                        {
                            progerssLoader.addClass('d-none');
                        }
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

        var parent = $(this).parents('.upload-image-section');
        var uploadSection = parent.find('.upload-section');
        var showSection = parent.find('.show-section');
        var progerssBar = parent.find('.progress-bar');
        var confirm_status = parent.attr('data-confirm') ? parent.attr('data-confirm') : confirm("Are you sure to delete this file ?");
        if(confirm_status)
        {
            var relation = $(this).attr('data-relation') ? $(this).attr('data-relation') : null;
            var relationThumbnail = $(this).attr('data-relation-thumbnail') ? $(this).attr('data-relation-thumbnail') : null;
            var id = $(this).attr('data-id') ? $(this).attr('data-id') : null;
            var isMultiple = !$(this).hasClass('single-cross');
            var that = $(this);
            var path = $(this).attr('data-path');
            var thumbnail = $(this).attr('data-thumbnail');
            parent.find('textarea').val('');
            parent.find('.required_upload_field').attr('required','required');
            
            $.ajax({
                url: site_url + '/actions/removeFile',
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
                        showSection.addClass('d-none');
                        progerssBar.css('width', 0);
                    }
                }
            });
        }
    });

    function updateFileValues(textArea, fileType, isMultiple, baseName)
    {
        if(isMultiple)
        {
            files = [];
            textArea.next('.show-section').find('.fileRemover').each(function() {
                var file = $(this).attr('data-path');
                files.push(file);
            });
            textArea.val(files.length > 0 ? JSON.stringify(files) : "");
        }
        else
        {
            textArea.val(textArea.parents('.upload-image-section').find('.fileRemover').attr('data-path'));
            baseName.val(textArea.parents('.upload-image-section').find('.fileRemover').attr('data-value'));
            textArea.siblings('label.error').empty();
            textArea.parents('.required_with_image').find('label.error').empty();
        }
    }
    /** Upload File Script **/
}

// Enable Scrolling pagination in case your are using ajax
if($('.ajaxPaginationEnabled').length > 0)
{
    var tableReq;
    function get_table_listing(table, type = '')
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

                if(table.find('.ads_append').length)
                    search = table.find('.listing-search').val();
                else
                    search = table.parents('.listing-block').find('.listing-search').val();

                sort = table.find('thead i.active').length ? table.find('thead i.active').attr('data-field') : '';
                direction = table.find('thead i.active').length ? table.find('thead i.active').attr('data-sort') : '';

                filters = $('#filters').length ? $('#filters').serialize() : '';
                data = 'page=' + next_page + '&sort=' + sort + '&direction=' + direction + '&search=' + search + (filters ? '&' + filters : '');
                
                if(tableReq && tableReq.readyState != 4)
                {
                    tableReq.abort();
                }

                tableReq = $.ajax({
                    url: url,
                    data: data,
                    success: function(resp){
                        table.find('.loader').attr('data-page', resp.page);
                        table.find('.loader').attr('data-counter', resp.pagination_counter);
                        table.find('.loader').attr('data-total', resp.count);
                        
                        if(resp.html)
                        {
                            if(type == 'favourite')
                            {
                                table.find('.fav_append').append(resp.html);
                            }
                            if(type == 'ads')
                            {
                                table.find('.ads_append').append(resp.html);
                            }
                            else
                            {
                                table.find('tbody').append(resp.html);
                            }
                            
                            if(resp.pagination_counter >= resp.count)
                            {
                                table.find('.loader').addClass('d-none');
                                table.find('.loader').attr('data-page', '');
                            }
                        }
                        else
                        {
                            table.find('.loader').attr('data-page', '');
                            table.find('.loader').addClass('d-none');
                        }

                        table.removeClass('processing');
                    }
                });
            }
            else
            {
               $('.res_load_more').hide('slow');
            }
        }
    }
}

if($('.listing-table').length)
{
    $(window).scroll(function(){
        if( $(this).scrollTop() > ($(document).height()-$(window).height() - 30) )
        {
            table = $('.listing-table');
            get_table_listing(table);
        }
    });

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

    $('body').on('click', '.listing-table .mark_all', function(){
        $('.listing-table .listing_check').prop('checked', $(this).is(':checked'));
    });

    $('.listing-table thead th:not(:first-child)').on('click', function(){
        if($(this).find('i').length)
        {
            $(this).parents('thead').find('i').removeClass('active');
            //$(this).parents('thead').find('i').removeClass('fa-sort').addClass('fa-sort-shapes-down');
            sort = $(this).find('i').attr('data-sort');
            direction =  sort && sort == 'asc' ? 'desc' : 'asc';
            icon = sort && sort == 'asc' ? 'fa-sort-shapes-up' : 'fa-sort-shapes-down';
            $(this).find('i').attr('data-sort', direction);
            $(this).find('i').addClass('active');
            $(this).find('i').removeClass('fa-sort-shapes-up');
            $(this).find('i').removeClass('fa-sort-shapes-down');
            $(this).find('i').addClass(icon);
            loader = $(this).parents('table').find('tfoot .loader');
            pagination_limit = loader.attr('data-limit');
            loader.attr('data-page', 0);
            loader.attr('data-counter', pagination_limit);
            loader.removeClass('hidden');

            table = $(this).parents('table');
            table.find('tbody').html('');
            get_table_listing(table);
        }
    });
}