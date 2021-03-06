<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite4239b4e30e7d14d44923da51bb98428
{
    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'ThisApp\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'ThisApp\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static $prefixesPsr0 = array (
        'T' => 
        array (
            'Twig_' => 
            array (
                0 => __DIR__ . '/..' . '/twig/twig/lib',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInite4239b4e30e7d14d44923da51bb98428::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInite4239b4e30e7d14d44923da51bb98428::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInite4239b4e30e7d14d44923da51bb98428::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}
