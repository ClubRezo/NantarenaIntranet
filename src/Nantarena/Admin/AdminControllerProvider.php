<?php

namespace Nantarena\Admin;

use Silex\Application;
use Silex\ControllerProviderInterface;

use Nantarena\Utils\Middlewares\AdminMiddleware;

/**
 * Controleur de l'administration
 * 
 * @author Drake <drake@nantarena.net>
 *
 */
class AdminControllerProvider implements ControllerProviderInterface {
    public function connect(Application $app) {
        $controllers = $app['controllers_factory'];
    
        $controllers->match('/', require 'Controllers/AdminDefault.php')->bind('admin');
        
        // application filtre admin
        $controllers->before(AdminMiddleware::filter($app));
        
        return $controllers;
    }
}
