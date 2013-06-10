<?php

namespace Nantarena\Pages;

use Silex\Application;
use Silex\ServiceProviderInterface;

use Nantarena\Utils\Middlewares\UserMiddleware;

/**
 * Service pour gérer les pages à contenu du site
 * 
 * @author Drake <drake@nantarena.net>
 *
 */
class PagesServiceProvider implements ServiceProviderInterface {
    public function register(Application $app) {
        
    }
    
    public function boot(Application $app) {
        $controllers = $app['controllers_factory'];
   
        $data = json_decode(file_get_contents(__DIR__.'/../../../data/pages.json'), true);
        
        foreach ($data as $key => $value) {
            $controllers->get('/' . $key . '/', require 'Controllers/PageDefault.php')->bind('page.' . $key);
        }
        
        $controllers->before(UserMiddleware::filter($app));
        
        // montage des controleurs sur l'app
        $app->mount('/', $controllers);
    }
}