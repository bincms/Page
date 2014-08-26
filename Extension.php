<?php

namespace Extension\Page;

use BinCMS\BaseExtension;
use Extension\Page\Converter\PageConverter;
use Extension\Page\Converter\PageMetadataConverter;
use Silex\Application;

class Extension extends BaseExtension
{

    /**
     * Registers services on the given app.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param Application|\BinCMS\Application $app An Application instance
     */
    public function register(Application $app)
    {
        $app
            ->registerDataRepository($this, 'Page')
        ;

        $app->registerExtensionController($this, 'Controller\\PageController', '', function($app) {
            return [
                $app['extension.page.repository.page'],
                $app['bincms.repository.image'],
                $app['service.converter'],
                $app['validator'],
            ];
        });

        $app['converter_factory']
            ->registerConverter('Extension\\Page\\Document\\Page', new PageConverter())
            ->registerConverter('Extension\\Page\\Document\\PageMetadata', new PageMetadataConverter())
        ;
    }

    /**
     * Bootstraps the application.
     *
     * This method is called after all services are registered
     * and should be used for "dynamic" configuration (whenever
     * a service must be requested).
     */
    public function boot(Application $app)
    {
        // TODO: Implement boot() method.
    }
}