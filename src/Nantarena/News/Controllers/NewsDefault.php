<?php
/**
 * Controleur de la page par défaut des news
 *
 * @author Drake <drake@nantarena.net>
 *
 */

use Silex\Application;

use Symfony\Component\HttpFoundation\Request;

return function (Application $app, Request $request) {
    $filepath = __DIR__.'/../../../../data/news.json';
    $news = json_decode(file_get_contents($filepath), true);
    
    // tri des news en ordre décroissant
    krsort($news);
    
    return $app->render('news.twig', array('news' => $news));
};
