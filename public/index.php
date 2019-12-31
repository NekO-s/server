<?php

use Apps\Application\JsonRpcApplication;
use Phalcon\Di;
use Phalcon\Loader;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Http\Request;
use Phalcon\Http\Response;
use Phalcon\Db\Adapter\Pdo\Postgresql as Database;
use Phalcon\Mvc\Model\Manager as ModelManager;
use Phalcon\Mvc\Model\Metadata\Memory as ModelMetadata;

/**
 * Very simple MVC structure
 */

$loader = new Loader();


$loader->registerNamespaces(
    [
        'Apps\Mvc\Router' => '../apps/mvc/router',
        'Apps\Application' => '../apps/application',
        'Apps\Mvc' => '../apps/mvc',
        'Apps\Http' => '../apps/http',
        'Apps\Controllers' => '../apps/controllers',
        'Apps\Models' => '../apps/models',
        'Apps\Forms' => '../apps/forms',
    ]
);

$loader->register();

$di = new Di();

$di->set("eventsManager", \Phalcon\Events\Manager::class);


// Registering a dispatcher
$di->set("dispatcher", function () use($di) {

    $eventsManager = $di->getShared('eventsManager');
    $eventsManager->attach(
        'dispatch:beforeException',
        function($event, $dispatcher, $exception) {
            switch ($exception->getCode()) {
                case Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
                case Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
                    $dispatcher->forward(
                        [
                            'namespace' => 'Apps\\Controllers',
                            'controller' => 'Index',
                            'action' => 'notFound',
                        ]
                    );
                    return false;
                    break;
                default:
                    $dispatcher->forward(
                        [
                            'namespace' => 'Apps\\Controllers',
                            'controller' => 'Index',
                            'action' => 'serverError',
                        ]
                    );
                    return false;
                    break; // for checkstyle
            }
        }
    );

    $dispatcher = new \Apps\Mvc\JsonRpcDispatcher();
    $dispatcher->setDefaultNamespace(
        'Apps\Controllers'
    );

    return $dispatcher;
});

// Registering a Http\Response
$di->set("response", Response::class);

// Registering a Http\Request
$di->set("request", Request::class);

// Registering the view component
$di['view'] = function() {
    $view = new Phalcon\Mvc\View();
    $view->disable();
    return $view;
};

$di->set(
    "db",
    function () {
        return new Database(
            [
                "host"     => "localhost",
                "username" => "",
                "password" => "",
                "dbname"   => "phalcon",
            ]
        );
    }
);

//Registering the Models-Metadata
$di->set("modelsMetadata", ModelMetadata::class);

//Registering the Models Manager
$di->set("modelsManager", ModelManager::class);

$di->set("url", function (){

    $url = new \Phalcon\Mvc\Url();

    $url->setBaseUri('http://goog-gl/');

    return $url;
});

$di['router'] = function () {

    $router = new \Phalcon\Mvc\Router();

    $router->add('', [
        'namespace' => 'Apps\Controllers',
        'controller' => 'Url',
        'action' => 'create',
    ])->setName('url-create');

    $router->add('/url/{id}', [
            'namespace' => 'Apps\Controllers',
            'controller' => 'Url',
            'action' => 'view',
        ]
    )->setName('url-view');

    return $router;
};

$application = new JsonRpcApplication($di);
$response = $application->handle();

$response->send();
