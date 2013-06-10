<?php
/**
 * Controleur de l'administration des joueurs pour revoke un accès
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
                $retvalue = System::delPlayer($players[$id]['ip']);
    			$retvalue2 = 0;
    			
    			// delete de la table Full Web si acces complet
                if ($players[$id]['rank'] == 2) {
                    $retvalue2 = System::delFullPlayer($players[$id]['ip']);
                }
                
                if ($retvalue == 0 && $retvalue2 == 0) {
                    // enregistrement des modifs
                    $players[$id]['rank'] = 1;
                    $players[$id]['ip'] = '';
                    
                    file_put_contents($filepath, json_encode($players, JSON_PRETTY_PRINT));
                    
                    $app['session']->getFlashBag()->add('success', 'Le joueur ' . $players[$id]['login'] . ' a son accès maintenant révoqué');
                } else {
                    $app['session']->getFlashBag()->add('error', 'Impossible d\'effectuer l\'action sur le Firewall (code1 = ' . $retvalue . ' & code2 = ' . $retvalue2 . ')');
                }
            } else {
                $app['session']->getFlashBag()->add('error', 'Impossible de révoquer l\'accès de ce joueur car il n\'a pas d\'adresse IP');
            }
        }
    }
    
    return $app->redirect($app['url_generator']->generate('admin.players'));
};
