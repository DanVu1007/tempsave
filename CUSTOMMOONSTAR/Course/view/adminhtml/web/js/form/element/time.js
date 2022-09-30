define([
    'Magento_Ui/js/form/element/date'
], function(Date) {
    'use strict';

    return Date.extend({
        defaults: {
            options: {
                showsDate: false,
                showsTime: true,
                timeOnly: true,
                timeFormat: "H:mm"
            },

            elementTmpl: 'ui/form/element/date'
        }
    });
});
