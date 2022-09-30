require([
    'Magento_Ui/js/lib/validation/validator',
    'jquery',
    'uiRegistry',
    'mage/translate'
], function (validator, $, registry) {
    var message = 'Invalid Google Video Drive File ID',
        validated = true;
    validator.addRule(
        'gg_file_id',
        function (value) {
            if (value) {
                $.ajax({
                    async: false,
                    url: '/moonstar/document/validate',
                    type: 'GET',
                    data: {
                        file_id: value
                    },
                    showLoader: true,
                    success: function (response) {
                        if (response.code == 200) {
                            registry.get('index = filename').value(response.file_name)
                            registry.get('index = extension').value(response.file_extension)
                        } else {
                            validated = false;
                            console.log(response.exception_message)
                            return false;
                        }
                    },
                    error: function (xhr, status, errorThrown) {
                        validated = false;
                        console.log('Error happens. Try again.');
                    }
                });
            }
            return validated;
        }, $.mage.__(message)
    );
});
