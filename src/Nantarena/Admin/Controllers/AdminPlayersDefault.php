<?php
/**
 * Controleur de l'administration des joueurs par défaut
 *
 * @author Drake <drake@nantarena.net>
 *
 */

use Silex\Application;

use Symfony\Component\HttpFoundation\Request;

return function (Application $app, Request $request) {
    $filepath = __DIR__.'/../../../../data/players.json';
    $players = json_decode(file_get_contents($filepath), true);
    
    return $app->render('admin/players.twig', array(
        'players' => $players,
    ));
};
