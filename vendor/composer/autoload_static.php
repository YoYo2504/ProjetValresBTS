<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit10143024ce1ef8acf09404303693180c
{
    public static $prefixLengthsPsr4 = array (
        'C' => 
        array (
            'Calendar\\' => 9,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Calendar\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/Calendar',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit10143024ce1ef8acf09404303693180c::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit10143024ce1ef8acf09404303693180c::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
