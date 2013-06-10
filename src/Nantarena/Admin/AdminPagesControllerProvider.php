<?php

namespace Nantarena\Admin;

use Silex\Application;
use Silex\ControllerProviderInterface;

use Nantarena\Utils\Middlewares\AdminMiddleware;

/**
 * Controleur de l'administration des pages statiques
 * 
 * @author Drake <drake@nantarena.net>
 *
 */
class AdminPagesControllerProvider implements ControllerProviderInterface {
    public function connect(Application $app) {
        $controllers = $app['controllers_factory'];
        
        $controllers->match('/{page}/', require 'Controllers/AdminPagesDefault.php')->bind('admin.page');
        
        // application filtre admin
        $controllers->before(AdminMiddleware::filter($app));
        
        return $controllers;
    }
}