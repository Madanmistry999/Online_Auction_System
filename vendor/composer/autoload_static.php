<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit56cb3ced4c877f001c42303de0881155
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit56cb3ced4c877f001c42303de0881155::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit56cb3ced4c877f001c42303de0881155::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit56cb3ced4c877f001c42303de0881155::$classMap;

        }, null, ClassLoader::class);
    }
}
