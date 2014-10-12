<?php
namespace Blog;
return array(
    'invokables' => array(
        'em'                             => __NAMESPACE__ . '\Controller\Plugin\EntityManager',
        'paginator'                      => __NAMESPACE__ . '\Controller\Plugin\Paginator',
        'messenger'                      => __NAMESPACE__ . '\Controller\Plugin\Messenger',
        'string'                         => __NAMESPACE__ . '\Controller\Plugin\ExpressivePregTransform',
        'routeParamTransform'            => __NAMESPACE__ . '\Controller\Plugin\RouteParamsTransformer',
        'guessControllerEntityClassname' => __NAMESPACE__ . '\Controller\Plugin\ControllerEntityClassname',
        'getEntityFromParamIdOrNew'      => __NAMESPACE__ . '\Controller\Plugin\GetEntityFromParamIdOrNew',
        'deleteEntitiesByIds'            => __NAMESPACE__ . '\Controller\Plugin\DeleteEntitiesByIds',
        'actionBulk'                     => __NAMESPACE__ . '\Controller\Plugin\BulkAction',
        'bulkForm'                       => __NAMESPACE__ . '\Controller\Plugin\BulkForm',
    ),
    'factories' => array(
        'repository'         => function ($controllerPluginManager) {
            $sm = $controllerPluginManager->getServiceLocator();
            $plugin = new Controller\Plugin\Repository;
            $config = $sm->get('Config');
            $plugin->setPreparationCallbacks($config['controller_plugin_repository']['preparation_callbacks']);
            return $plugin;
        },
    ),
);
