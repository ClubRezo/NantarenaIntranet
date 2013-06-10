<?php
/**
 * Controleur de la page par défaut
 * 
 * @author Drake <drake@nantarena.net>
 *
 */

use Silex\Application;

use Symfony\Component\HttpFoundation\Request;

return function (Application $app, Request $request) {
    return $app->render('admin/admin.twig');
};
