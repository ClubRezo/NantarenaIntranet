<?php
/**
 * Controleur de la page de connexion du site
 *
 * @author Drake <drake@nantarena.net>
 *
 */

use Silex\Application;

use Symfony\Component\HttpFoundation\Request;

use Nantarena\Utils\System;

return function(Application $app, Request $request) use ($app) {
$filepath = __DIR__.'/../../../../data/';
    $players = json_decode(file_get_contents($filepath.'players.json'), true);
    $plan = json_decode(file_get_contents($filepath.'plan.json'), true);

    $nbRangees = $plan['ouest'] + $plan['est'];
    $choices = array();
    for ($i = 0; $i < $nbRangees; $i++) {
        $choices['Rangée '.chr(65 + $i)] = array(
            ($i*4 + 1) => 'Slot '.($i*4 + 1),
            ($i*4 + 2) => 'Slot '.($i*4 + 2),
            ($i*4 + 3) => 'Slot '.($i*4 + 3),
            ($i*4 + 4) => 'Slot '.($i*4 + 4),
        );
    }
    
    $form = $app['form.factory']->createBuilder('form', array('login', 'password'))
        ->add('key', 'text')
        ->add('slot', 'choice', array(
            'choices'   => $choices,
            'empty_value' => 'Numéro de slot'
        ))
        ->getForm();
    
    if ('POST' == $request->getMethod()) {
        $form->bind($request);
    
        if ($form->isValid()) {
            $success = true;
            $data = $form->getData();
            $key = $data['key'];
            $slot = $data['slot'];
            
            if (!empty($players[$key])) {
                $player = $players[$key];

                if (!empty($slot) || $player['rank'] > 2) { // Vérif validité slot  
                
                    if (empty($player['ip']) || $player['ip'] == $_SERVER['REMOTE_ADDR']
                        || $player['rank'] > 2) {
                        // paramétrage session utilisateur

                        $sess = array(
                            'key' => $key,
                            'login' => $player['login'],
                            'rank' => $player['rank'],
                            'ip' => $_SERVER['REMOTE_ADDR']
                        );

                        if ($plan['active_slots'] == 1) {
                            $sess['slot'] = $slot;
                        } else if (isset($player['slot'])) {
                            $sess['slot'] = $player['slot'];
                        }

                        $app['session']->set('user', $sess);
                        
                        // mise a jour fichier si non admin et première connexion
                        if ($player['rank'] <= 2 && empty($player['ip'])) {
                            $retvalue = System::addPlayer($_SERVER['REMOTE_ADDR']);
                            
                            // vérification retour du script iptables
                            if ($retvalue == 3) {
                                $app['session']->getFlashBag()->add('error', 'L\'adresse IP n\'a pas pu être ajoutée au Firewall car une entrée sur cette IP existe déjà (code = 3)');
                                $success = false;
                            } elseif ($retvalue == 10) {
                                $app['session']->getFlashBag()->add('error', 'Erreur lors de l\'ajout de l\'adresse, veuillez recommencer (code = 10)');
                                $success = false;
                            } else {
                                $players[$key]['ip'] = $_SERVER['REMOTE_ADDR'];
                                $players[$key]['slot'] = $slot;

                                /*if ($plan['active_slots'] == 1) {
                                    $players[$key]['slot'] = $slot;
                                }*/

                                // enregistrement dans le fichier texte avec une lecture exclusive
                                // afin d'éviter les conflit d'écriture parallèle
                                if (false === file_put_contents($filepath.'players.json', json_encode($players, JSON_PRETTY_PRINT), LOCK_EX)) {
                                    $success = false;
                                }
                            }
                        }
                        
                        if ($success) {
                            $app['session']->getFlashBag()->add('success', 'Vous êtes désormais connecté à l\'intranet');
                            return $app->redirect($app['url_generator']->generate('home'));
                        } else {
                            $app['session']->clear(); // clear session car le login a échoué
                            $app['session']->getFlashBag()->add('error', 'Impossible de se connecter à l\'intranet, veuillez recommencer');
                        }
                    } else {
                        $app['session']->getFlashBag()->add('error', 
                            'Votre clé d\'accès a déjà été utilisée, ' .
                            'veuillez demander à un admin de vous révoquer ' . 
                            'l\'accès si vous désirez vous connecter.');
                    }
                } else {
                    $app['session']->getFlashBag()->add('error', 'Le numéro de slot est incorrect');
                }
            } else {
                $app['session']->getFlashBag()->add('error', 'La clé que vous venez d\'entrer est incorrecte, si le problème persiste, veuillez vous adresser à un admin');
            }
        }
    }
    
    return $app->render('login.twig', array(
        'form' => $form->createView(),        
    ));
};
