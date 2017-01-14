<?php
namespace Message;

use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;
use Zend\Router\Http\Literal;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\MessageController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'message' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/message[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\MessageController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'message' => __DIR__ . '/../view',
        ],
        'strategies'                => array(
            'ViewJsonStrategy',
        ),
    ],
];