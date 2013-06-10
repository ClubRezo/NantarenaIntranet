<?php
// web/index.php

$app = require '../src/app.php';

// debug mode

$app['debug'] = true;

// definitions

$app->run();
