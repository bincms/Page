var config = {
    title: 'Контент',
    menu: {
        items: [
            {
                title: 'Страницы',
                url: 'extension.page.list',
                items: [
                    {title: 'Список', url: 'extension.page.list'},
                    {title: 'Добавить', url: 'extension.page.create'}
                ]
            }
        ]
    }
};

angular.adminModule('page', [
        'bincms.rest',
        'bincms.admin.page.templates',
        'ui.router',
        'textAngular',
        'mgcrea.ngStrap',
        'angularFileUpload'
    ], config)
    .config(['$stateProvider', function ($stateProvider) {

        $stateProvider
            .state('extension.page', {
                url: '/page'
            })
            .state('extension.page.list', {
                url: '/list',
                views: {
                    'content@layout': {
                        templateUrl: 'admin/page/list.html',
                        controller: 'PageListExtensionController'
                    }
                }
            })
            .state('extension.page.create', {
                url: '/create',
                views: {
                    'content@layout': {
                        templateUrl: 'admin/page/create.html',
                        controller: 'PageCreateExtensionController'
                    }
                }
            })
            .state('extension.page.update', {
                url: '/update/:id',
                views: {
                    'content@layout': {
                        templateUrl: 'admin/page/update.html',
                        controller: 'PageUpdateExtensionController',
                        resolve: {
                            page: ['$pageService', '$stateParams', function (pageService, stateParams) {
                                return pageService.get({id: stateParams.id}).$promise;
                            }]
                        }
                    }
                }
            })
        ;
    }]);