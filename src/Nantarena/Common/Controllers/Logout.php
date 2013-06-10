<?php
/**
 * Controleur de la page de logout
 *
 * @author Drake <drake@nantarena.net>
 *
 */

use Silex\Application;

use Symfony\Component\HttpFoundation\Request;

return function(Application $app, Request $request) {
    $app['session']->clear();
    $app['session']->getFlashBag()->add('success', 'Vous êtes désormais déconnecté de l\'intranet');
    
    return $app->redirect($app['url_generator']->generate('login'));
};
