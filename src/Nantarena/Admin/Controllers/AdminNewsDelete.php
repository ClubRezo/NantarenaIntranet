<?php
/**
 * Controleur de suppression d'une news
 * 
 * @author Drake <drake@nantarena.net>
 *
 */

use Silex\Application;

use Symfony\Component\HttpFoundation\Request;

return function (Application $app, Request $request, $id) {
    $filepath = __DIR__.'/../../../../data/news.json';
    $news = json_decode(file_get_contents($filepath), true);
    
    // vérification que la news existe effectivement
    if (array_key_exists($id, $news)) {
        unset($news[$id]);
        file_put_contents($filepath, json_encode($news, JSON_PRETTY_PRINT));
        
        $app['session']->getFlashBag()->add('success', 'La news a été supprimée avec succès');
    } else {
        $app['session']->getFlashBag()->add('error', 'La news n\'a pas pu être supprimée');
    }
    
    return $app->redirect($app['url_generator']->generate('admin.news'));
};
