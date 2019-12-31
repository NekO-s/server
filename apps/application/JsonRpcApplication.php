<?php

namespace Apps\Application;

use Apps\Http\JsonResponse;
use Apps\Mvc\JsonRpcDispatcher;

class JsonRpcApplication extends \Phalcon\Application
{
    public function checkJsonRequest($json)
    {
        if (!array_key_exists('jsonrpc', $json) ||
            !array_key_exists('method', $json) ||
            !array_key_exists('params', $json) ||
            !array_key_exists('id', $json)
        ) {
            throw new Exception(Exception::ERROR_INVALID_REQUEST['message'], Exception::ERROR_INVALID_REQUEST['code']);
        }
    }

    public function getJsonFromRequest() :?array
    {
        $json = $this->request->getJsonRawBody(true);

        if (!$json) {

            throw new Exception(Exception::ERROR_PARSE_ERROR['message'], Exception::ERROR_PARSE_ERROR['code']);
        }

        $isJsonValid = false;


        if (isset($json['jsonrpc'])) {

            $isJsonValid = true;
            $this->checkJsonRequest($json);

        } else {

            if (is_array($json) && count($json)) {

                $isJsonValid = true;

                foreach ($json as $row) {

                    if (!isset($row['jsonrpc'])) {

                        $isJsonValid = false;

                    } else {

                        $this->checkJsonRequest($row);
                    }
                }
            }
        }

        if (!$isJsonValid) {

            throw new Exception(Exception::ERROR_PARSE_ERROR['message'], Exception::ERROR_PARSE_ERROR['code']);
        }

        return $json;
    }
    public function handle()
    {
        try {

            if (!$this->dispatcher instanceof JsonRpcDispatcher) {

                throw new Exception(Exception::ERROR_INVALID_DISPATCHER['message'], Exception::ERROR_INVALID_DISPATCHER['code']);
            }

            $this->dispatcher->setParam('json', $this->getJsonFromRequest());
            $this->dispatcher->dispatch();
            $this->response->setJsonContent($this->dispatcher->getJsonReturnedValue());


        }
        catch (\Exception $e) {
            $this->response->setJsonContent(JsonResponse::error($e->getMessage(), $e->getCode(), null));
        }

        return $this->response;
    }
}