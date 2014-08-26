'use strict';

angular.adminModule('page').directive('chooserDialogPage', [
    '$pageService', '$modal',
    function ($pageService, $modal) {
        return {
            restrict: 'AE',
            scope: {
                onSelected: '&'
            },
            replace: false,
            link: function (scope, element, attrs, controller) {

                scope.pages = [];

                var chooserDialogPage = $modal({
                    scope: scope,
                    title: 'Страницы',
                    template: 'admin/page/modal/chooserDialogPage.html',
                    show: false
                });

                scope.onSelectClick = function (event, page) {
                    event.stopPropagation();
                    event.preventDefault();
                    scope.onSelected({
                        url: '/page/' + page.slug
                    });
                    chooserDialogPage.hide();
                };

                scope.onSelectPage = function (page) {
                    scope.loadPage(page);
                };

                scope.loadPage = function (page) {
                    $pageService.get({per_page: 15, page: page}, function (response) {
                        scope.pages = response.items;
                        scope.pagination = response.pagination;
                    });
                };

                element.bind('click', function () {
                    scope.loadPage(1);
                    chooserDialogPage.show();
                });
            }
        }
    }
]);
