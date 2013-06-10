<?php

namespace Nantarena\Utils\Middlewares;

use Silex\Application;

/**
 * User Middleware donnant accès à des filtres pour limiter les accès aux différentes
 * parties de l'intranet
 *
 * @author Drake <drake@nantarena.net>
 *
 */
class UserMiddleware {
    static function filter(Application $app) {
        return function () use ($app) {
            if (!$app['session']->has('user')) {
                return $app->redirect($app['url_generator']->generate('login'));
            }
        };
    }
    
    static function reverseFilter(Application $app) {
        return function () use ($app) {
            if ($app['session']->has('user')) {
                return $app->redirect($app['url_generator']->generate('home'));
            }
        };
    }
}