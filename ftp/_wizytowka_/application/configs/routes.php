<?php

return array_merge(include 'previewRoutes.php', array(
    '/' => array('\App\Controller\IndexController', 'indexAction'),
    '/template/{templateId}' => array('\App\Controller\IndexController', 'templateAction'),
    '/map' => array('\App\Controller\IndexController', 'mapAction'),
    '/api/isNew' => array('\App\Controller\IndexController', 'isNewAction'),
    '/api/businesscard' => array('\App\Controller\BusinessCardController', 'indexAction'),
    '/api/businesscard/default' => array('\App\Controller\BusinessCardController', 'defaultAction'),
    '/api/businesscard/deactivate' => array('\App\Controller\BusinessCardController', 'deactivateAction'),
    '/api/businesscardform' => array('\App\Controller\BusinessCardFormController', 'getAction'),
    '/api/businesscardtemplate' => array('\App\Controller\IndexController', 'templatesAction'),
    '/error' => array('\App\Controller\ErrorController', 'indexAction'),
    '/?ga={ga}' => array('\App\Controller\IndexController', 'indexAction'),
));