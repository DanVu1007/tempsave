define([
    'Magento_Ui/js/form/element/file-uploader',
    'underscore',
    'uiRegistry',
    'prototype'
], function (fileUploader, _, registry) {
    return fileUploader.extend({
        getFilePreviewType: function (file) {
            if (!_.isUndefined(file.previewUrl)) {
                return 'image';
            }

            return this._super();
        },
        getFileLink: function(file) {
            return file.url;
        },
        getFilePreview: function (file) {
            if (!_.isUndefined(file.previewUrl)) {
                return file.previewUrl;
            }

            return file.url;
        },
        addFile: function (file) {
            var fileNameField = registry.get(this.parentName + '.filename_container.filename'),
                titleField = registry.get(this.parentName + '.title');

            fileNameField.value(file.filename);
            if (typeof titleField !== 'undefined' && !titleField.value()) {
                titleField.value(file.title);
            }
            registry.get(this.parentName + '.filename_container.extension').value(file.file_extension);

            this._super();
        }
    })
});
