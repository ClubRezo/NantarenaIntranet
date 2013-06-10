<?php
/**
 * Controleur de l'administration des joueurs full accès
 *
 * @author Drake <drake@nantarena.net>
 *
 */

use Silex\Application;

use Symfony\Component\HttpFoundation\Request;

use Nantarena\Utils\System;

return function (Application $app, Request $request, $id) {
    $filepath = __DIR__.'/../../../../data/players.json';
    $players = json_decode(file_get_contents($filepath), true);
    
    if (array_key_exists($id, $players)) {
        if ($players[$id]['rank'] <= 2) {
            if (!empty($players[$id]['ip'])) {
                // ajout du joueurs dans iptables
                $retvalue = System::addFullPlayer($players[$id]['ip']);
                
                if ($retvalue != 0) {
                    $app['session']->getFlashBag()->add('error', 'Impossible d\'effectuer l\'action sur le Firewall (code = ' . $retvalue . ')');
                } else {
                    // enregistrement des modifications
                    $players[$id]['rank'] = 2;
                    
                    file_put_contents($filepath, json_encode($players, JSON_PRETTY_PRINT));
                    
                    $app['session']->getFlashBag()->add('success', 'Le joueur ' . $players[$id]['login'] . ' a maintenant un accès complet');
                }
            } else {
                $app['session']->getFlashBag()->add('error', 'Impossible de donner un accès complet à ce joueur car il n\'a pas d\'adresse IP');
            }
        }
    }
    
    return $app->redirect($app['url_generator']->generate('admin.players'));
};
