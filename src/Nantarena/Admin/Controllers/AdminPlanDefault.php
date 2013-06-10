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
    $filepath = __DIR__.'/../../../../data/';
    $players = json_decode(file_get_contents($filepath.'players.json'), true);

    $teams = array();

    foreach ($players as $player) {
        if ($player['rank'] <= 2) {
            $teams[$player['tournament']][$player['team']] = $player['team'];
        }
    }

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

    $form = $app['form.factory']->createBuilder('form', array('team', 'slot'))
        ->add('team', 'choice', array(
            'choices'   => $teams
        ))
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

            $team = $data['team'];
            $slot = $data['slot'];

            foreach ($players as $key => $player) {
                if ($player['rank'] <= 2 && $player['team'] == $team) {
                    $players[$key]['slot'] = $slot;
                }
            }

            // enregistrement dans le fichier texte avec une lecture exclusive
            // afin d'éviter les conflit d'écriture parallèle
            if (false === file_put_contents($filepath.'players.json', json_encode($players, JSON_PRETTY_PRINT), LOCK_EX)) {
                $success = false;
            }

            if ($success) {
                $app['session']->getFlashBag()->add('success', 'Changement effectué');
            } else {
                $app['session']->clear(); // clear session car le login a échoué
                $app['session']->getFlashBag()->add('error', 'Erreur d\'écriture dans le fichier');
            }
        }
    }
    
    return $app->render('admin/plan.twig', array(
        'form' => $form->createView()
    ));
};
