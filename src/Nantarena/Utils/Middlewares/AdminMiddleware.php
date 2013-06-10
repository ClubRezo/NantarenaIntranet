<?php

namespace Nantarena\Utils\Middlewares;

use Silex\Application;

/**
 * Admin Middleware donnant accès à des filtres pour limiter les accès aux différentes
 * parties de l'intranet
 * 
 * @author Drake <drake@nantarena.net>
 *
 */
class AdminMiddleware {
    static function filter(Application $app) {
        return function () use ($app) {
            if ($app['session']->has('user')) {
                $user = $app['session']->get('user');
                
                if ($user['rank'] < 3) {
                    return $app->redirect($app['url_generator']->generate('home'));
                }
            } else {
                return $app->redirect($app['url_generator']->generate('home'));
            }
        };
    }
    
    static function reverseFilter(Application $app) {
        return function () use ($app) {
            if ($app['session']->has('user')) {
                $user = $app['session']->get('user');
    
                if ($user['rank'] >= 3) {
                    return $app->redirect($app['url_generator']->generate('home'));
                }
            } else {
                return $app->redirect($app['url_generator']->generate('home'));
            }
        };
    }
}