<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit9938501bb0dd55657ca0a59ad1798f46
{
    public static $prefixLengthsPsr4 = array (
        'D' => 
        array (
            'DolphPHP\\' => 9,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'DolphPHP\\' => 
        array (
            0 => __DIR__ . '/..' . '/dolph-php/framework/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit9938501bb0dd55657ca0a59ad1798f46::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit9938501bb0dd55657ca0a59ad1798f46::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit9938501bb0dd55657ca0a59ad1798f46::$classMap;

        }, null, ClassLoader::class);
    }
}
