<?php

namespace Apps\Controllers;

use Apps\Forms\UrlForm;
use Apps\Mvc\JsonRpcController;

class UrlController extends JsonRpcController
{
    public function createAction()
    {
        $form = new UrlForm();

        if ($url=$form->save()) {

            return [
                'url' => $url,
            ];
        }

        return $this->badRequestForm($form);
    }
}
