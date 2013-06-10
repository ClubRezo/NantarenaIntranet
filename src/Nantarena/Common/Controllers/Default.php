<?php
/**
 * Controleur de la page par défaut du site
 * 
 * @author Drake <drake@nantarena.net>
 * 
 */

use Silex\Application;

use Symfony\Component\HttpFoundation\Request;

return function(Request $request) use ($app) {
    $news = json_decode(file_get_contents(__DIR__.'/../../../../data/news.json'), true);
    
    return $app->render('home.twig', array('news' => $news[count($news) - 1]));
};
