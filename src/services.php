<?php
/**
 * Configuration et enregistrement des services tiers ou internes
 * 
 * @author Drake <drake@nantarena.net>
 *
 */

// services Silex & Symfony
$app->register(new Silex\Provider\FormServiceProvider());
$app->register(new Silex\Provider\SessionServiceProvider(), array(
    'session.storage.options' => array(
        'cookie_lifetime' => 172800
    )
));

// test
$app['session.storage.options'] = array('lifetime' => 172800);

$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
));
$app->register(new Silex\Provider\ValidatorServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider(), array(
    'translator.messages' => array(),
));

// nos services
$app->register(new Nantarena\Pages\PagesServiceProvider());
