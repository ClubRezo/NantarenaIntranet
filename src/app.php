<?php
/**
 * Application Silex, initilisation et inclusion de la config, des services et modules
 * 
 * On définit aussi les routes de base de l'application
 * 
 * @author Drake <drake@nantarena.net>
 *
 */

require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;

use Nantarena\IntranetApplication;
use Nantarena\Utils\Middlewares\UserMiddleware;

$app = new IntranetApplication();

// requires pour la configuration de l'app
require_once __DIR__.'/config.php';
require_once __DIR__.'/services.php';
require_once __DIR__.'/modules.php';

$app->match('/', require 'Nantarena/Common/Controllers/Default.php')->bind('home')->before(UserMiddleware::filter($app));

$app->match('/login/', require 'Nantarena/Common/Controllers/Login.php')->bind('login')->before(UserMiddleware::reverseFilter($app));

$app->match('/logout/', require 'Nantarena/Common/Controllers/Logout.php')->bind('logout')->before(UserMiddleware::filter($app));

return $app;
