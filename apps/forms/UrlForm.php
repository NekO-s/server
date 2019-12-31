<?php

namespace Apps\Forms;

use Apps\Models\Url;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Form;

class UrlForm extends Form
{
    public function initialize()
    {
        $url = new Text('url');
        $url->addValidator(new \Phalcon\Validation\Validator\Url([
            'model' => $this,
            'message' => 'Укажите верный url.'
        ]));
        $url->addValidator(new \Phalcon\Validation\Validator\StringLength(
            [
                'max' => 150,
                'min' => 10,
                'messageMaximum' => "Слишком длинная ссылка",
                'messageMinimum' => "Слишком короткая ссылка",
                'includedMaximum' => true,
                'includedMinimum' => false,
            ]
        ));
        $this->add($url);
    }

    public function save() :?string
    {
        $data = $this->dispatcher->getParams();

        if (!$this->isValid($data)) {

            return null;
        }

        $url = new Url();

        $url->url = $data['url'];
        $url->created_at = time();

        if (!$url->save()) {

            $this->get('url')->setMessages($url->getMessages()[0]);
            return null;
        }

        /** @var \Phalcon\Url $diUrl */
        $diUrl = $this->di->get('url');

        return $diUrl->get([
            'for' => 'url-view',
            'id' => $url->id,
        ]);
    }
}