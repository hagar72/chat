<?php
namespace Message;

use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class Module implements ConfigProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
    
    public function getServiceConfig()
    {
        return [
            'factories' => [
                Model\MessageTable::class => function($container) {
                    $tableGateway = $container->get(Model\MessageTableGateway::class);
                    return new Model\MessageTable($tableGateway);
                },
                Model\MessageTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Message());
                    return new TableGateway('message', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    }
    
    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\MessageController::class => function($container) {
                    return new Controller\MessageController(
                        $container->get(Model\MessageTable::class)
                    );
                },
            ],
        ];
    }
}