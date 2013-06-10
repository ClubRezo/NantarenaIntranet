<?php
/**
 * Modules de l'application
 * 
 * Chargez ici les modules nécessaires à l'application.
 * 
 * @author Drake <drake@nantarena.net>
 * 
 */

// montage des modules front-end
$app->mount('/news', new Nantarena\News\NewsControllerProvider());
$app->mount('/plan', new Nantarena\Plan\PlanControllerProvider());

// montage modules administration
$app->mount('/admin', new Nantarena\Admin\AdminControllerProvider());
$app->mount('/admin/news', new Nantarena\Admin\AdminNewsControllerProvider());
$app->mount('/admin/players', new Nantarena\Admin\AdminPlayersControllerProvider());
$app->mount('/admin/pages', new Nantarena\Admin\AdminPagesControllerProvider());
$app->mount('/admin/plan', new Nantarena\Admin\AdminPlanControllerProvider());
