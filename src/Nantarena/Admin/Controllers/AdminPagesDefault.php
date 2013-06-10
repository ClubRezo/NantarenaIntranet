<?php
/**
 * Controleur de l'administration des pages statiques
 * 
 * @author Drake <drake@nantarena.net>
 *
 */

use Silex\Application;

use Symfony\Component\HttpFoundation\Request;

return function (Application $app, Request $request, $page) {
    $filepath = __DIR__.'/../../../../data/pages.json';
    $pages = json_decode(file_get_contents($filepath), true);
    
    // vérification que la page existe bien
    if (!array_key_exists($page, $pages)) {
        return $app->redirect($app['url_generator']->generate('admin'));
    }
    
    
    $title = $pages[$page]['title'];
    $subtitle = $pages[$page]['subtitle'];
    $content = $pages[$page]['content'];
    
    $form = $app['form.factory']->createBuilder('form', array(
        'title' => $title, 'subtitle' => $subtitle, 'content' => $content))
        ->add('title', 'text')
        ->add('subtitle', 'text')
        ->add('content', 'textarea')
        ->getForm();
    
    if ('POST' == $request->getMethod()) {
        $form->bind($request);
    
        if ($form->isValid()) {
            $data = $form->getData();
            
            $pages[$page]['title'] = $data['title'];
            $pages[$page]['subtitle'] = $data['subtitle'];
            $pages[$page]['content'] = $data['content'];
            
            file_put_contents($filepath, json_encode($pages, JSON_PRETTY_PRINT));
            
            $app['session']->getFlashBag()->add('success', 'La page a été éditée avec succès');
        }
    }
    
    return $app->render('admin/page.twig', array(
        'form' => $form->createView(),
        'page' => $page,
        'title' => $title,
        'subtitle' => $subtitle,
        'content' => $content,
    ));
};
