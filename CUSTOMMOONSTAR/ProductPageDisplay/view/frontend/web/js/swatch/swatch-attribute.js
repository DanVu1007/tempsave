/*jshint browser:true jquery:true*/
/*global alert*/
define([
    'jquery',
    'mage/utils/wrapper'
], function ($, wrapper) {
    'use strict';

    return function(targetModule){

        var updatePrice = targetModule.prototype._UpdatePrice;
        targetModule.prototype.dynamic = {};

        $('[data-dynamic]').each(function(){
            var code = $(this).data('dynamic');
            var value = $(this).html();

            targetModule.prototype.dynamic[code] = value;
        });

        var updatePriceWrapper = wrapper.wrap(updatePrice, function(original){
            var dynamic = this.options.jsonConfig.dynamic;

            for (var code in dynamic){
                var optionsClass = Object.keys(this.options.jsonConfig.dynamic[code]);
                if (dynamic.hasOwnProperty(code)) {
                    var value = '',
                        products = this._CalcProducts(),
                        onlineValue = this.options.jsonConfig.dynamic[code][optionsClass[0]].value,
                        offlineValue = this.options.jsonConfig.dynamic[code][optionsClass[1]].value,
                        value = this.options.jsonConfig.dynamic[code][products.slice().shift()].value;

                    if(value === onlineValue) {
                        $('.offline-class').hide();
                        $('.online-class').show();
                        $('.select-time-course').css('display','block');
                    }
                    if(value === offlineValue) {
                        $('.offline-class').show();
                        $('.online-class').hide();
                        $('.select-time-course').css('display','block');
                    }
                }
            }
            return original();
        });

        targetModule.prototype._UpdatePrice = updatePriceWrapper;
        return targetModule;

    };

});
