<?php
namespace Blog;

return array(
    'view_manager' => array(
        'template_path_stack' => array(
            strtolower(__NAMESPACE__) => __DIR__ . '/../view',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
    'controller_plugin_repository' => include __DIR__ . '/controller_plugin_repository.config.php',
    'controller_plugins' => include __DIR__ . '/controller_plugins.config.php',
    'controllers'        => include __DIR__ . '/controllers.config.php',
    'doctrine'           => include __DIR__ . '/doctrine.config.php',
    'doctrine_event_listeners' => include __DIR__ . '/doctrine_event_listeners.config.php',
    'file_uploader'      => include __DIR__ . '/file_uploader.config.php',
    'navigation'         => include __DIR__ . '/navigation.config.php',
    'router'             => include __DIR__ . '/router.config.php',
    'service_manager'    => include __DIR__ . '/service_manager.config.php',
    'translator'         => include __DIR__ . '/translator.config.php',
);
