<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit92f73e497637e8bab26c70a625d684f8
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PragmaRX\\Google2FA\\' => 19,
            'ParagonIE\\ConstantTime\\' => 23,
        ),
        'D' => 
        array (
            'DASPRiD\\Enum\\' => 13,
        ),
        'B' => 
        array (
            'BaconQrCode\\' => 12,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PragmaRX\\Google2FA\\' => 
        array (
            0 => __DIR__ . '/..' . '/pragmarx/google2fa/src',
        ),
        'ParagonIE\\ConstantTime\\' => 
        array (
            0 => __DIR__ . '/..' . '/paragonie/constant_time_encoding/src',
        ),
        'DASPRiD\\Enum\\' => 
        array (
            0 => __DIR__ . '/..' . '/dasprid/enum/src',
        ),
        'BaconQrCode\\' => 
        array (
            0 => __DIR__ . '/..' . '/bacon/bacon-qr-code/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit92f73e497637e8bab26c70a625d684f8::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit92f73e497637e8bab26c70a625d684f8::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit92f73e497637e8bab26c70a625d684f8::$classMap;

        }, null, ClassLoader::class);
    }
}
