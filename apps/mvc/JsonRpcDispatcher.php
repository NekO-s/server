<?php

namespace Apps\Mvc;

use Apps\Http\JsonResponse;
use Phalcon\Http\Request;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Router;

class JsonRpcDispatcher extends Dispatcher
{
    private $jsonReturnedValueList = [];

    public function dispatch() :bool
    {
        /** @var Request $request */
        $request = $this->getDI()->get('request');

        /** @var Router $router */
        $router = $this->getDI()->get('router');

        $json = $request->getJsonRawBody(true);

        $requests = $json;

        if (isset($requests['jsonrpc'])) {

            $requests = [$json];
        }

        foreach ($requests as $request) {

            /** @var \Phalcon\Mvc\Router\Route $route */
            $route = $router->getRouteByName($request['method']);

            if ($route) {

                $paths = $route->getPaths();

                $this->setNamespaceName($paths['namespace']);
                $this->setControllerName($paths['controller']);
                $this->setActionName($paths['action']);
                $this->setParams($request['params']);

                parent::dispatch();

                $result = $this->getReturnedValue();

                $this->jsonReturnedValueList[] = JsonResponse::success($result, $request['id']);

            }
        }

        return true;
    }
    public function getJsonReturnedValue()
    {
        if (count($this->jsonReturnedValueList) === 1) {
            return $this->jsonReturnedValueList[0];
        }
        return $this->jsonReturnedValueList;
    }
}