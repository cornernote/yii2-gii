<?php

namespace cornernote\gii\giiant\crud\providers;

use cornernote\gii\helpers\TabPadding;

class RelationProvider extends \schmunk42\giiant\generators\crud\providers\RelationProvider
{

    public $inputWidget = 'select2';

    public function columnFormat($column, $model)
    {
        return TabPadding::pad(parent::columnFormat($column, $model), 2, true);
    }

    public function activeField($column)
    {
        return TabPadding::pad(parent::activeField($column));
    }

    public function attributeFormat($column)
    {
        return TabPadding::pad(parent::attributeFormat($column), 3, true);
    }

    public function relationGrid($name, $relation, $showAllRecords = false)
    {
        $data = parent::relationGrid($name, $relation, $showAllRecords);
        $data = str_replace('return Url::toRoute',"\$params['ru'] = ReturnUrl::getToken();\n                return Url::toRoute",$data);
        return TabPadding::pad($data, 1);
    }

}