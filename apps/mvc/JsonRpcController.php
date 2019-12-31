<?php

namespace Apps\Mvc;

use Apps\Application\Exception;
use Phalcon\Forms\Form;
use Phalcon\Mvc\Controller;

class JsonRpcController extends Controller
{
    /**
     * @param Form $form
     * @throws Exception
     */
    protected function badRequestForm(Form $form)
    {
        throw new Exception($form->getMessages()[0]->getMessage(), Exception::ERROR_INVALID_PARAMS['code']);
    }

    /**
     * @param array $error
     * @throws Exception
     */
    protected function error(array $error)
    {
        throw new Exception($error['message'], $error['code']);
    }
}