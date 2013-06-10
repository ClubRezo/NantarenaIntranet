<?php
/**
 * Controleur de la page pour afficher une page de contenu
 *
 * @author Drake <drake@nantarena.net>
 *
 */

use Silex\Application;

use Symfony\Component\HttpFoundation\Request;

return function (Application $app, Request $request) use ($value) {
    return $app->render('page.twig', array(
        'title' => $value['title'],
        'subtitle' => $value['subtitle'],
        'content' => $value['content'],
    ));
};
