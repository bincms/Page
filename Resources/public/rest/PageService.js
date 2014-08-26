'use strict';

var PageServiceProvider = Class.extend({
    /**
     * Initialize
     * @return {$resource}
     */
    $get: ['$resource',
        function ($resource) {
            var resourceUrl = '/api/extension/Page';
            return $resource(resourceUrl + '/:id', null, {
                update: { method: 'PUT' }
            });
        }
    ]
});

angular.module('bincms.rest').provider('$pageService', PageServiceProvider);