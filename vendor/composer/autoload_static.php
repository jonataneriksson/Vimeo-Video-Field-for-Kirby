<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit12389852b9ca10354a2fee77ca7307e0
{
    public static $prefixLengthsPsr4 = array (
        'V' => 
        array (
            'Vimeo\\' => 6,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Vimeo\\' => 
        array (
            0 => __DIR__ . '/..' . '/vimeo/vimeo-api/src/Vimeo',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit12389852b9ca10354a2fee77ca7307e0::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit12389852b9ca10354a2fee77ca7307e0::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
