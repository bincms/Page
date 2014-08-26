'use strict';

var PageUpdateExtensionController = BaseController.extend({

    init: function (scope, pageService, page, fileUploader) {
        this.pageService = pageService;
        this.fileUploader = fileUploader;
        this.page = page;

        this._super(scope);
    },

    onSave: function (form, pageModel) {
        if (form.validate()) {
            this.pageService.update({id: this.page.id}, pageModel,
                this.saveSuccessCallback.bind(this),
                this.saveErrorCallback.bind(this, form)
            );
        }
    },

    saveSuccessCallback: function () {
    },

    saveErrorCallback: function (form, result) {
        form.setErrors(result.data.errors);
    },

    uploadImageSuccessCallback: function (event, xhr, item, response) {
        var image = angular.fromJson(xhr.responseText);

        if (image) {
            this.$scope.pageModel.imageId = image.id;
            this.$scope.image = image;
        }
    },

    selectTagCallback: function (event, value, rawValue) {

        if (angular.isDefined(value) && angular.isObject(value)) {

        } else {

            if (this.$scope.pageModel.tags.indexOf(rawValue) == -1) {
                this.$scope.pageModel.tags.push(rawValue);
            }
        }

        this.$scope.selected.tag = null;
        this.$scope.$apply();
    },

    onRemoveTagClick: function (tag) {
        angular.removeItemWithArray(this.$scope.pageModel.tags, false, tag);
    },

    defineListeners: function () {
        this._super();

    },

    /**
     * Use this function to define all scope objects.
     * Give a way to instantaly view whats available
     * publicly on the scope.
     */
    defineScope: function () {
        this._super();
        this.$scope.onSave = this.onSave.bind(this);
        this.$scope.onRemoveTagClick = this.onRemoveTagClick.bind(this);
        this.$scope.image = null;
        this.$scope.selected = {
            tag: null
        };

        var imageId = null;
        if (this.page.image !== null) {
            imageId = this.page.image.id;
            this.$scope.image = this.page.image;
        }

        this.$scope.pageModel = this.page;

        this.uploader = this.fileUploader.create({
            scope: this.$scope,
            url: '/api/upload/image',
            autoUpload: true
        });

        this.uploader.bind('complete', this.uploadImageSuccessCallback.bind(this));

        this.$scope.$on('$typeahead.select.tag', this.selectTagCallback.bind(this));
    }
});

PageUpdateExtensionController.$inject = [
    '$scope', '$pageService', 'page', '$fileUploader'
];

angular.adminModule('page').controller('PageUpdateExtensionController', PageUpdateExtensionController);