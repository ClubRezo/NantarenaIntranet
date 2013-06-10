<?php

namespace Nantarena\Admin;

use Silex\Application;
use Silex\ControllerProviderInterface;

use Nantarena\Utils\Middlewares\AdminMiddleware;

/**
 * Controleur de l'administration du plan
 * 
 * @author Jaconil <jaconil@nantarena.net>
 *
 */
class AdminPlanControllerProvider implements ControllerProviderInterface {
    public function connect(Application $app) {
        $controllers = $app['controllers_factory'];
        
        $controllers->match('/', require 'Controllers/AdminPlanDefault.php')->bind('admin.plan');
        
        // application filtre admin
        $controllers->before(AdminMiddleware::filter($app));
        
        return $controllers;
    }
}