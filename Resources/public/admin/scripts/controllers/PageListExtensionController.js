'use strict';

var PageListExtensionController = BaseController.extend({

    init: function (scope, pageService, locationService) {
        this.pageService = pageService;
        this.locationService = locationService;
        this.searchData = this.locationService.search();
        this._super(scope);
    },

    onLoadPageClick: function (page) {
        this.loadPage(page);
    },

    onPageRemoveSuccessCallback: function (page, result) {
        if (result.success) {
            angular.removeItemWithArray(this.$scope.pages, 'id', page.id);
        }
    },

    onSelectPage: function (current) {
        this.loadPage(current);
    },

    loadPage: function (page) {

        this.$scope.currentPage = page;

        var params = {
            page: page,
            per_page: 10
        };

        var result = this.pageService.get(params, function () {
            this.$scope.pages = result.items;
            this.$scope.pagination = result.pagination;
            this.locationService.search('page', page);
        }.bind(this));
    },

    onPageRemoveClick: function (page) {
        this.pageService.delete(
            {id: page.id},
            this.onPageRemoveSuccessCallback.bind(this, page)
        );
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
        this.$scope.onLoadPageClick = this.onLoadPageClick.bind(this);
        this.$scope.onPageRemoveClick = this.onPageRemoveClick.bind(this);
        this.$scope.onSelectPage = this.onSelectPage.bind(this);
        var page = this.searchData.page || null;
        this.loadPage(page);
    }
});

PageListExtensionController.$inject = [
    '$scope', '$pageService', '$location'
];

angular.adminModule('page').controller('PageListExtensionController', PageListExtensionController);