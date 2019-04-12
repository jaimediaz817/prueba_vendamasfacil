<?php

// autoload_psr4.php @generated by Composer

$vendorDir = dirname(dirname(__FILE__));
$baseDir = dirname($vendorDir);

return array(
    'camaleon\\viewControllers\\' => array($baseDir . '/core/application/controllers'),
    'camaleon\\system\\database\\' => array($baseDir . '/core/system/database'),
    'camaleon\\mvc\\' => array($baseDir . '/core/system/mvc'),
    'camaleon\\models\\' => array($baseDir . '/core/application/models'),
    'camaleon\\helpers\\' => array($baseDir . '/core/system/helpers'),
    'camaleon\\examples\\' => array($baseDir . '/core/examples'),
    'camaleon\\errorControllers\\' => array($baseDir . '/core/application/controllers/errors'),
    'camaleon\\apis\\' => array($baseDir . '/core/application/apis'),
    'camaleon\\RouterControllers\\' => array($baseDir . '/core/application/router'),
    'Symfony\\Polyfill\\Ctype\\' => array($vendorDir . '/symfony/polyfill-ctype'),
    'Slim\\' => array($vendorDir . '/slim/slim/Slim'),
    'Psr\\Http\\Message\\' => array($vendorDir . '/psr/http-message/src'),
    'Psr\\Container\\' => array($vendorDir . '/psr/container/src'),
    'PHPMailer\\PHPMailer\\' => array($vendorDir . '/phpmailer/phpmailer/src'),
    'Interop\\Container\\' => array($vendorDir . '/container-interop/container-interop/src/Interop/Container'),
    'FastRoute\\' => array($vendorDir . '/nikic/fast-route/src'),
    'Dotenv\\' => array($vendorDir . '/vlucas/phpdotenv/src'),
);
