"use strict";
$(function () {
    var t = $(".select2");
    t.length && t.each(function () {
        var e = $(this);
        e.wrap('<div class="position-relative"></div>').select2({ 
            placeholder: "Select value", 
            dropdownParent: e.parent() 
        });
    });
});
