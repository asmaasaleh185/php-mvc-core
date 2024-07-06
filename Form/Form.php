<?php

namespace corepackage\phpmvc\Form;

use corepackage\phpmvc\Model;
use corepackage\phpmvc\Form\InputField;

class Form{
    public static function begin($action, $method){
        echo sprintf('<form action="%s" method="%s">', $action, $method);
        return new Form();

    }
    public static function end(){
        echo '</form>';
    }
    public function field(Model $model, $attribute){
        return new InputField($model, $attribute);
    }
}