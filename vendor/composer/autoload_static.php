<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite64b1c354690f45f4294e392dbe42e74
{
    public static $files = array (
        '99c2f991d81480e5945e079d7d11d25c' => __DIR__ . '/../..' . '/src/Resources/Helpers.php',
    );

    public static $prefixLengthsPsr4 = array (
        'D' => 
        array (
            'DynamicTerminal\\' => 16,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'DynamicTerminal\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInite64b1c354690f45f4294e392dbe42e74::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInite64b1c354690f45f4294e392dbe42e74::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInite64b1c354690f45f4294e392dbe42e74::$classMap;

        }, null, ClassLoader::class);
    }
}
