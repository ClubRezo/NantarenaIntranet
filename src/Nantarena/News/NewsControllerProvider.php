<?php

namespace Nantarena\News;

use Silex\Application;
use Silex\ControllerProviderInterface;

use Nantarena\Utils\Middlewares\UserMiddleware;

/**
 * Controleurs du module de news
 * 
 * @author Drake <drake@nantarena.net>
 *
 */
class NewsControllerProvider implements ControllerProviderInterface {
    public function connect(Application $app) {
        $controllers = $app['controllers_factory'];
    
        $controllers->get('/', require 'Controllers/NewsDefault.php')->bind('news');
        
        $controllers->before(UserMiddleware::filter($app));
        
        return $controllers;
    }
}