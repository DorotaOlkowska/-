<?php
return array(
    'config' => array(
        '\App\Service\Config\Config', array(
            include sprintf('%s/application/configs/config.php', APP_DIR),
        )
    ),
    'session' => array(
        '\App\Service\Session\Session', array()
    ),
    'request' => array(
        '\App\Service\Request\Request', array(
            '@session'
        )
    ),
    'router' => array(
        '\App\Service\Router\Router', array(
            '@request',
            include 'routes.php'
        )
    ),
    'businessCard' => array(
        '\App\Service\BusinessCard\BusinessCard', array(
            array(
                'dataFile' => sprintf('%s/data/storages/data.json', APP_DIR),
                'dataFileDefault' => sprintf('%s/data/storages/default/data.json', APP_DIR)
            )
        )
    ),
    'BusinessCardUrlCrypt' => array(
        '\App\Service\BusinessCardUrlCrypt\BusinessCardUrlCryptService', array(
            'key'=>'C9EFE2339A2F18637D7DC6061649E4B7D3E895C4B5D62DEEDC7DBF851C680F58',
            'secondKey'=>'63A9CE2FD61D70DFDBB50DD97968BAC7EABA1BB6E91DAE5647B49B57977E863A'
        )
    ),
    'BusinessCardPreview' => array(
        '\App\Service\BusinessCardPreview\BusinessCardPreview', array()
    ),
    'logger' => array(
        '\App\Service\Logger\Logger', array(
            array(
                'ApplicationLogger' => array(
                    'dir' => sprintf('%s/data/logs/', APP_DIR),
                    'name' => 'app'
                ),
                'default' => 'ApplicationLogger'
            ),
            '@request'
        )
    ),
    'mailer' => array(
        '\App\Service\Mailer\Mailer', array(
            '@logger',
        )
    ),
    'httpAuth' => array(
        '\App\Service\HttpAuth\HttpAuth', array(
            '@request',
            '@logger',
            'authFile' => sprintf('%s/application/configs/basicPasswd.txt', APP_DIR)
        )
    )

);
