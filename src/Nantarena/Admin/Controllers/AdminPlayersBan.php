<?php
/**
 * Controleur de l'administration pour ban les joueurs
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
                // retrait des iptables
                $retvalue = System::banPlayer($players[$id]['ip']);
                
                if ($retvalue != 0) {
                    $app['session']->getFlashBag()->add('error', 'Impossible d\'effectuer l\'action sur le Firewall (code = ' . $retvalue . ')');
                } else {
                    // enregistrement des modifs
                    $players[$id]['ban'] = 1;
                
                    file_put_contents($filepath, json_encode($players, JSON_PRETTY_PRINT));
        
                    $app['session']->getFlashBag()->add('success', 'Le joueur ' . $players[$id]['login'] . ' est maintenant banni du réseau');
                }
            } else {
                $app['session']->getFlashBag()->add('error', 'Impossible de bannir ce joueur car il n\'a pas d\'adresse IP');
            }
        }
    }
    
    return $app->redirect($app['url_generator']->generate('admin.players'));
};
