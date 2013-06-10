<?php

namespace Nantarena\Admin;

use Silex\Application;
use Silex\ControllerProviderInterface;

use Nantarena\Utils\Middlewares\AdminMiddleware;

/**
 * Controleur de l'administration des joueurs
 * 
 * @author Drake <drake@nantarena.net>
 *
 */
class AdminPlayersControllerProvider implements ControllerProviderInterface {
    public function connect(Application $app) {
        $controllers = $app['controllers_factory'];
        
        $controllers->match('/', require 'Controllers/AdminPlayersDefault.php')->bind('admin.players');
        $controllers->match('/full/{id}', require 'Controllers/AdminPlayersFull.php')->bind('admin.players.full');
        $controllers->match('/normal/{id}', require 'Controllers/AdminPlayersNormal.php')->bind('admin.players.normal');
        $controllers->match('/revoke/{id}', require 'Controllers/AdminPlayersRevoke.php')->bind('admin.players.revoke');
        $controllers->match('/ban/{id}', require 'Controllers/AdminPlayersBan.php')->bind('admin.players.ban');
        $controllers->match('/unban/{id}', require 'Controllers/AdminPlayersUnban.php')->bind('admin.players.unban');
        
        // application filtre admin
        $controllers->before(AdminMiddleware::filter($app));
        
        return $controllers;
    }
}