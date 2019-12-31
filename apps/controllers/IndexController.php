<?php

namespace Apps\Controllers;

use Apps\Mvc\JsonRpcController;

class IndexController extends JsonRpcController
{
    public function notFoundAction()
    {
        return $this->error(\Apps\Application\Exception::ERROR_METHOD_NOT_FOUND);
    }

    public function serverErrorAction()
    {
        return $this->error(\Apps\Application\Exception::ERROR_INTERNAL_ERROR);
    }
}
