<?php

namespace Nantarena\Admin;

use Silex\Application;
use Silex\ControllerProviderInterface;

use Nantarena\Utils\Middlewares\AdminMiddleware;

/**
 * Controleur de l'administration des news
 * 
 * @author Drake <drake@nantarena.net>
 *
 */
class AdminNewsControllerProvider implements ControllerProviderInterface {
    public function connect(Application $app) {
        $controllers = $app['controllers_factory'];
        
        $controllers->match('/news/', require 'Controllers/AdminNewsDefault.php')->bind('admin.news');
        $controllers->match('/news/delete/{id}/', require 'Controllers/AdminNewsDelete.php')->bind('admin.news.delete');
        
        // application filtre admin
        $controllers->before(AdminMiddleware::filter($app));
        
        return $controllers;
    }
}