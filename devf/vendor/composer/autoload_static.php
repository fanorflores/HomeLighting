<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit608e189a7ed7bf72fc8ee454840a4271
{
    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'Felip\\HomeLighting\\' => 19,
        ),
        'A' => 
        array (
            'Automattic\\WooCommerce\\' => 23,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Felip\\HomeLighting\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
        'Automattic\\WooCommerce\\' => 
        array (
            0 => __DIR__ . '/..' . '/automattic/woocommerce/src/WooCommerce',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit608e189a7ed7bf72fc8ee454840a4271::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit608e189a7ed7bf72fc8ee454840a4271::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit608e189a7ed7bf72fc8ee454840a4271::$classMap;

        }, null, ClassLoader::class);
    }
}
