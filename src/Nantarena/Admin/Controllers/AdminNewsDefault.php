<?php
/**
 * Controleur de l'administration des news
 * 
 * @author Drake <drake@nantarena.net>
 *
 */

use Silex\Application;

use Symfony\Component\HttpFoundation\Request;

return function (Application $app, Request $request) {
    $filepath = __DIR__.'/../../../../data/news.json';
    $news = json_decode(file_get_contents($filepath), true);
    
    $form = $app['form.factory']->createBuilder('form', array('title', 'content'))
        ->add('title', 'text')
        ->add('content', 'textarea')
        ->getForm();
    
    // traitement d'une nouvelle news
    if ('POST' == $request->getMethod()) {
        $form->bind($request);
    
        if ($form->isValid()) {
            $data = $form->getData();
    
            $news[] = array(
                'title' =>$data['title'],
                'content' => $data['content'],
                'date' => date('\L\e d/m à H:i')
            );
    
            file_put_contents($filepath, json_encode($news, JSON_PRETTY_PRINT));
    
            $app['session']->getFlashBag()->add('success', 'La news vient d\'être publiée avec succès');
        }
    }
    
    return $app->render('admin/news.twig', array(
        'news' => $news,
        'form' => $form->createView(),
    ));
};
