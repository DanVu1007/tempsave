var config = {
    map: {
        '*': {
            formCart: 'Moonstarcz_ProductPageDisplay/js/form-product-add-to-cart',
            'Magento_Swatches/js/swatch-renderer':'Moonstarcz_ProductPageDisplay/js/swatch-render/swatch-render'
        }
    },
    config: {
        mixins: {
            'Moonstarcz_ProductPageDisplay/js/swatch-render/swatch-render': {
                'Moonstarcz_ProductPageDisplay/js/swatch/swatch-attribute': true
            }
        }
    }

};
