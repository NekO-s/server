<?php

namespace Apps\Models;

use Phalcon\Mvc\Model;

class Url extends Model
{
    public $id;

    public $url;

    public $created_at;

    public function initialize()
    {
        $this->setSource("url");
    }
}
