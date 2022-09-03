<?php

return array(
    '/' => array('\App\Controller\IndexController', 'indexAction'),
    '/init/preview/update/{template}' => array('\App\Controller\PreviewFrontController', 'updateAction'),
    '/init/preview/?hash={hash}' => array('\App\Controller\PreviewController', 'indexAction'),
    '/apipreview/previewlink/{parameters}' => array('\App\Controller\PreviewController', 'getPreviewLinkAction'),
    '/apipreview/previewlink?{parameters}' => array('\App\Controller\PreviewController', 'getPreviewLinkAction'),
    '/apipreview/previewlink{parameters}' => array('\App\Controller\PreviewController', 'getPreviewLinkAction'),
    '/template/{templateId}' => array('\App\Controller\IndexController', 'templateAction'),
    '/error' => array('\App\Controller\ErrorController', 'indexAction'),
    '/map' => array('\App\Controller\IndexController', 'mapAction'),
);