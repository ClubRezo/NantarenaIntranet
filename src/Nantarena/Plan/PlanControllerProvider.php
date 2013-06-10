<?php

namespace Nantarena\Plan;

use Silex\Application;
use Silex\ControllerProviderInterface;

use Nantarena\Utils\Middlewares\UserMiddleware;

class PlanControllerProvider implements ControllerProviderInterface {
    public function connect(Application $app) {
        $controllers = $app['controllers_factory'];
    
        $controllers->get('/', require 'Controllers/PlanDefault.php')->bind('plan');
        
        $controllers->before(UserMiddleware::filter($app));
        
        return $controllers;
    }
}