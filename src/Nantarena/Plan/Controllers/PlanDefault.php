<?php

use Silex\Application;

use Symfony\Component\HttpFoundation\Request;

return function (Application $app, Request $request) {
    $filepath = __DIR__.'/../../../../data/';
    $plan = json_decode(file_get_contents($filepath.'plan.json'), true);
    $players = json_decode(file_get_contents($filepath.'players.json'), true);

    $width = 6;

    $nbRangeesOuest = $plan['ouest'];
    $nbRangeesEst = $plan['est'];

    $marginOuest = floor((100 - $width * $nbRangeesOuest) / ($nbRangeesOuest - 1));
    $marginEst = floor((45 - $width * $nbRangeesEst) / ($nbRangeesEst - 1));

    if ($marginEst > $marginOuest) 
        $marginEst = $marginOuest;

    $rangees = array('ouest' => array(), 'est' => array());

    // Plan de la salle
    for ($i=0; $i<$nbRangeesOuest; $i++) {
        $rangees['ouest'][$i] = array('width'=>$width, 'margin'=> ($i==0)? 0:$marginOuest, 'numero'=>chr(65+$i), 'ind'=>$i);
    }

    for ($i=0; $i<$nbRangeesEst; $i++) {
        $rangees['est'][$i] = array('width'=>$width, 'margin'=> ($i==0)? 0:$marginEst, 'numero'=>chr(65+$i+$nbRangeesOuest), 'ind'=>$i);
    }

    // Plan des rangées
    $teams = array();
    $nbRangees = $nbRangeesOuest + $nbRangeesEst;
    $rg = array();

    for ($i=0; $i<$nbRangees; $i++) {
        $rg[$i] = array(
            'numero' => chr(65+$i),
            'games' => array(), 
            'slot1' => array(), 
            'slot2' => array(), 
            'slot3' => array(), 
            'slot4' => array(),
            'teams' => array()
        );
    }

    foreach ($players as $player) {
        if ($player['rank'] <= 2) {
            $teams[$player['team']]['name'] = $player['team'];
            $teams[$player['team']]['game'] = $player['tournament'];
            $teams[$player['team']]['players'][] = $player['login'];

            if (isset($player['slot'])) {
                $s = $player['slot'] - 1;
                $rg[floor($s/4)]['teams'][] = $player['team'];  
                $rg[floor($s/4)]['slot'.(($s%4)+1)][] = $player['team']; 
            } 
        }
    }

    for ($i=0; $i<$nbRangees; $i++) {

        $rg[$i]['teams'] = array_unique($rg[$i]['teams']);
        $rg[$i]['slot1'] = array_unique($rg[$i]['slot1']);
        $rg[$i]['slot2'] = array_unique($rg[$i]['slot2']);
        $rg[$i]['slot3'] = array_unique($rg[$i]['slot3']);
        $rg[$i]['slot4'] = array_unique($rg[$i]['slot4']);

        $t = array();
        foreach ($rg[$i]['teams'] as $team) {$t[] = $teams[$team];}
        $rg[$i]['teams'] = $t;

        foreach ($rg[$i]['teams'] as $t) {$rg[$i]['games'][] = $t['game'];}
        $rg[$i]['games'] = array_unique($rg[$i]['games']);
    }

    $rangees['all'] = $rg;
    
    return $app->render('plan.twig', array('rangees' => $rangees));
};
