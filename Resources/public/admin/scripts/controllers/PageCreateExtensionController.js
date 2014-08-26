'use strict';

var PageCreateExtensionController = BaseController.extend({

    init: function (scope, pageService, fileUploader) {
        this.pageService = pageService;
        this.fileUploader = fileUploader;
        this.uploader = null;
        this._super(scope);
    },

    getDefaultModel: function () {
        return {
            title: '',
            content: '',
            slug: '',
            imageId: null,
            tags: []
        };
    },

    onSave: function (form, model) {
        if (form.validate()) {
            this.pageService.save(
                model,
                this.saveSuccessCallback.bind(this),
                this.saveErrorCallback.bind(this, form)
            );
        }
    },

    saveSuccessCallback: function () {
        this.resetForm();
    },

    saveErrorCallback: function (form, result) {
        form.setErrors(result.data.errors);
    },

    resetForm: function () {
        this.$scope.image = null;
        this.$scope.pageModel = this.getDefaultModel();
    },

    uploadImageSuccessCallback: function (event, xhr, item, response) {
        var image = angular.fromJson(xhr.responseText);

        if (image) {
            this.$scope.pageModel.imageId = image.id;
            this.$scope.image = image;
        }
    },

    getTags: function () {
        return [];
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
        this.$scope.pageModel = this.getDefaultModel();
        this.$scope.image = null;
        this.$scope.selected = {
            tag: null
        };

        this.uploader = this.fileUploader.create({
            scope: this.$scope,
            url: '/api/upload/image',
            autoUpload: true
        });

        this.uploader.bind('complete', this.uploadImageSuccessCallback.bind(this));

        this.$scope.$on('$typeahead.select.tag', this.selectTagCallback.bind(this));
    }
});

PageCreateExtensionController.$inject = [
    '$scope', '$pageService', '$fileUploader'
];


angular.adminModule('page').controller('PageCreateExtensionController', PageCreateExtensionController);