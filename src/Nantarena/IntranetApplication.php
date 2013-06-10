<?php
// src/Nantarena/IntranetApplication.php

namespace Nantarena;

use Silex\Application;

/**
 * Définit notre application Intranet étendue de Application
 * 
 * @author Drake <drake@nantarena.net>
 */
class IntranetApplication extends Application {
    use Application\TwigTrait;
    use Application\SecurityTrait;
    use Application\FormTrait;
    use Application\UrlGeneratorTrait;
}
