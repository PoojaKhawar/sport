let AddMoreAudits = {
    index: null,
    auditContainer: null,
    
    init: function() {
        this.auditContainer = $('#auditContainer');
        this.bindEvents();
    },
    
    bindEvents: function() {
        $('#addMore').on('click', () => {
            this.addAuditItem();
        });
        
        $(document).on('click', '.remove-item', (e) => {
            this.removeAuditItem(e);
        });
    },
    
    addAuditItem: function() {

        if (this.auditContainer.find('.audit-item').length > 8) {
            alert('You cannot add more than 8 items.');
            return;
        }
        
        let lastIndex = parseInt(this.auditContainer.find('.audit-item:last .index').val(), 10);
        let index = isNaN(lastIndex) ? 0 : lastIndex + 1; 

        const newItem = this.auditContainer.find('.audit-item:last').clone().attr('data-index', index);

        newItem.find('input.index').val(index);

        newItem.find('input[name^="json[service]"]').each(function() {
            const name = $(this).attr('name').replace(/\[\d+\]/, `[${index}]`);
            $(this).attr('name', name).val('');
        });

        newItem.find('textarea[name^="json[service]"]').each(function() {
            const name = $(this).attr('name').replace(/\[\d+\]/, `[${index}]`);
            $(this).attr('name', name).val('');
        });

        newItem.find('label.error').attr('for', function() {
            return $(this).attr('for').replace(/\[\d+\]/, `[${index}]`);
        });

        newItem.find('textarea').val('');

        newItem.find('.fixed-edit-section').remove();

        newItem.find('.upload-section').removeClass('d-none');
        newItem.find('.show-section').addClass('d-none');
        newItem.find('textarea[name^="json[service]"][name$="[icon]"]').val('');
        newItem.find('i.remove-item').show();

        this.auditContainer.append(newItem);
    },
    
    removeAuditItem: function(event) {
        $(event.currentTarget).closest('.audit-item').remove();
    }
};

AddMoreAudits.init();



$(".validation1").validate();
$(".validation2").validate();
$(".validation3").validate();
$(".validation4").validate();
$(".validation5").validate();
$(".validation6").validate();
$(".validation7").validate();
$(".validation8").validate();
$(".validation9").validate();
$(".validation10").validate();

