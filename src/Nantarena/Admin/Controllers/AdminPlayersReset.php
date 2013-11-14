<?php
/**
 * Controleur de l'administration des joueurs (reset)
 *
 * @author Jaconil <jaconil@nantarena.net>
 *
 */

use Silex\Application;

use Symfony\Component\HttpFoundation\Request;

use Nantarena\Utils\System;

return function (Application $app, Request $request) {
    $filepath = __DIR__.'/../../../../data/players.json';
    $players = json_decode(file_get_contents($filepath), true);

    foreach($players as &$player) {
        $player['ban'] = 0;
        $player['ip'] = "";
        if ($player['rank'] <= 2) {
            $player['rank'] = 1;
        }
    }
    
    file_put_contents($filepath, json_encode($players, JSON_PRETTY_PRINT));
    
    return $app->redirect($app['url_generator']->generate('admin.players'));
};
