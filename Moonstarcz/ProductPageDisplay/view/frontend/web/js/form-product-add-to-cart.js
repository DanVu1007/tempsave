define(['jquery'], function ($) {
    "use strict";
    return function formCart() {
        $('#select-moonstar-class input').on('change', function () {
            var value = $('input[name=class_id]:checked', '#select-moonstar-class').val();
            $('#add-to-cart-moonstar-class').val(value)
        });
    }
});
